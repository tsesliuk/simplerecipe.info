(function($){
    /* add to post handlers. add here additional functionality for generating HTML in TinyMCE for  custom extensions */
    var addToPostHandlers = {};

    /* the toolset object contains actions to be taken when the actions of a thumbnail are being used */
    var toolset = {
        add: function(li, attachmentId) {
            var ext = li.attr('data-ext').toLowerCase();

            var addContent = function(ct) {
                impro.editor.getTinyMCE().execCommand('mceInsertContent',false, ct);
            };

            /* if we add an image */
            if (['jpg','jpeg','gif','png'].indexOf(ext) !== -1) {
                var $img = li.find('img');
                var src = $img.attr('src');
                content = '<img src="' + src + '" />';
                addContent(content);

                /* add animation of content */
                // TODO put it exactly over the image :D
                var contentIfr = $(impro.editor.getTinyMCE().contentAreaContainer);
                var $imgClone = $img.clone();
                $imgClone.css({
                    position: 'absolute',
                    top: $img.offset().top,
                    left: $img.offset().left,
                    'z-index': 10000
                }).appendTo('body').animate({
                        top: contentIfr.offset().top + contentIfr.height() / 2,
                        left: contentIfr.offset().left + contentIfr.width() / 2,
                        opacity: 0.5
                    }, 1000, function() {
                        $(this).remove();
                    });

            } else {	/* for any other extension, default is link, but we can easily override */
                $.getJSON(impro.url + '/src/request/getattachmentdata.php?id=' + attachmentId, function(json) {	/* get all the data of the attachment */
                    if (addToPostHandlers && typeof addToPostHandlers['extension_' + ext] === 'function') {	/* if user defined a custom function, use it */
                        content = addToPostHandlers['extension_' + ext].call(this, json, li);
                    } else {	/* if not, just make a link */
                        content = ' <a href="' + json.attachment_url + '" target="_blank">' + json.post_title + '</a> ';
                    }
                    addContent(content);
                });
            }

            return false;
        },
        library: function(li, attachmentId) {
            var content;
            content = impro.admin_url + 'media.php?attachment_id=' + attachmentId + '&action=edit';	/* build media edit link */

            $('#vimg-toolset [data-action=library]').attr('href', content).attr('target', '_blank');	/* set link */

            return true;	/* return true, such that the href link will be used */
        },
        open: function(li, attachmentId) {
            var content;

            $.getJSON(impro.url + '/src/request/getattachmentdata.php?id=' + attachmentId, function(json) {	/* get all the data of the attachment */
                var result = window.open(json.attachment_url, 'op');
                if (!result) {
                    impro.err(imageproFolderL10N.popupOpenError);
                }
            });

            return false;
        },
        link: function(li, attachmentId) {
            var content;

            $.getJSON(impro.url + '/src/request/getattachmentdata.php?id=' + attachmentId, function(json) {	/* get all the data of the attachment */
                prompt(imageproFolderL10N.attachmentLink, json.attachment_url);
            });

            return false;
        },
        remove: function(li, attachmentId) {
            if (confirm(imageproFolderL10N.deleteAttachmentConfirmation)) {
                $.post(impro.url + '/src/request/deleteattachment.php', {
                    id: attachmentId,
                    _ajax_nonce: impro.nonce.deleteNonce
                }, function(data) {
                    if (data.ok) {
                        loadImages();
                    } else {
                        impro.err(data.data.msg);
                    }
                });
            }
            return false;
        }
    };

    var init = function() {
        loadImages();
        $('#vimg-toolbar-filter').appendTo($('#impro_folder_box .hndle')).show();
        initEvents();
    };

    var initEvents = function() {
        var timerID = 0; /* reference for timer, used for event buffering for searching */
        /* searching text event. the event is buffered so requests are delayed until user finishes typing */
        $('#vimg-search').bind('keyup', function(ev) {
            if (ev.which && (/[a-zA-Z0-9 \.,;-_]/.test(String.fromCharCode(ev.which)) || ev.which === 8)) {
                clearTimeout(timerID);
                timerID = setTimeout(function() {
                    loadImages();
                }, 500);
            }
        });

        /* selecting a certain file type */
        $('#vimg-filetype').bind('change keyup', function(ev) {
            loadImages();
            ev.stopImmediatePropagation();
        });

        /* since the filter toolbar is in the header of the panel, any click should not pass through, as it may collapse it */
        $('#vimg-toolbar-filter').bind('click', false);

        /* the debug log */
        $('#vimg-dbg').bind('click', function(ev) {
            $('#vimg-dbg-content').show().find('textarea').load(impro.url + '/src/request/dbg.php?rnd='+Math.random(), {},  function(t) {
                $('#vimg-dbg-content textarea').val(t);
            });
            return false;
        });

        /* when any button from the toolset is clicked */
        $('#vimg-toolset').delegate('[data-action]', 'click', function(ev) {
            var $li = $(this).closest('li[data-attachment-id]');
            return toolset[$(this).attr('data-action')].call(this, $li, $li.attr('data-attachment-id'));
        });

        /* when the file upload field in the list changes, start file upload */
        $('#vimg-list').delegate('input[type="file"]', 'change', function(ev) {
            if (this.files && this.files.length) {
                ddu.uploadMultipleFiles(this.files);
                try {
                    this.reset();
                } catch(e) {}
            }
        });

        /* display the toolset */
        $('#vimg-list')
            .delegate('li[data-attachment-id]', 'mouseenter', function(ev) {
                $('#vimg-toolset').appendTo(this);
            })
            .delegate('li[data-attachment-id]', 'mouseleave', function(ev) {
                $('#vimg-toolset').appendTo('body');
            });

        /* when an image is double clicked, it is automatically added to content */
        $('#vimg-list').delegate('li[data-attachment-id] img', 'dblclick', function(ev) {
            var $li = $(this).closest('li[data-attachment-id]');
            return toolset['add'].call(this, $li, $li.attr('data-attachment-id'));
        });

        /* this event is used for blocking the dragging of non-image files to the editor */
        $('#vimg-list').bind('mousedown', function(ev) {
            var target = $(ev.target);

            if (target.is('img')) {	/* if began dragging an image */
                target = target.closest('li');	/* get its li parent */
            } else {
                return false;
            }

            var ext = target.attr('data-ext');	/* get extension */

            if (ext && ['jpg', 'jpeg', 'gif', 'png'].indexOf(ext) === -1) {	/* if not image */
                /* stop dragging */
                ev.stopPropagation();
                ev.preventDefault();
                setTimeout(function() {	/* it seems that showing an alert box immidiately makes the dragged image load. so we time out a bit */
                    //impro.err('You can only drag images over the editor! For other file types, click "Add to editor".');
                }, 500);
                return false;
            }
        });
    };

    var loadImages = function() {
        $.ajax({
            url: impro.url + '/src/request/getimages.php',
            cache: false,
            data: {
                filetype: $('#vimg-filetype').val(),
                search: $('#vimg-search').val(),
                sort: $('#vimg-sort').val()
            },
            dataType: 'json',
            type: 'GET',
            success: function(data, status, xhr) {
                var html = "";

                if (data.ok) {
                    /* build the "Upload" button */
                    html += '<li id="vupload"><input type="file" multiple /><div><span>+</span>' + imageproEditorL10N.uploadNew + '</div>';
                    html += '</li>';

                    /* build the HTML structure for the images from the server */
                    for(var i = 0; i < data.data.length; i++) {
                        html += '<li data-attachment-id="' + data.data[i].id + '" data-url="' + data.data[i].thumb + '" data-ext="' + data.data[i].ext + '">';
                        html += '<img data-lazy-src="' + data.data[i].thumb + '" />';
                        html += '<span>' + data.data[i].name + '</span>';
                        html += '</li>';
                    }

                    /* recover the toolset in case of deleting elements */
                    var $toolset = $('#vimg-list #vimg-toolset');
                    if ($toolset.length) {
                        $toolset.appendTo('body');
                    }

                    /* render the images */
                    $('#vimg-list ul').empty().append(html);
                }

                /* set up the lazy load of images on scroll*/
                lazyscroll();
                $('#vimg-list').scroll();
            },
            error: function() {

            }
        });
    };

    var lazyscroll = function() {
        var lazyscroll_timers = [];
        $('#vimg-list').scroll(function() {
            for(var i=0;i<lazyscroll_timers.length;i++) {
                clearTimeout(lazyscroll_timers[i]);
            }

            lazyscroll_timers.push(setTimeout(function() {
                var scrollTop = $('#vimg-list').scrollTop();
                var containerTop = Math.round($('#vimg-list').offset().top);

                /* if there are any images in the list */
                if ($('#vimg-list img:eq(0)').size() > 0) {
                    var firstImageTop = Math.round($('#vimg-list img:eq(0)').offset().top);

                    var j = 0;
                    $('#vimg-list img[data-lazy-src]').each(function(i) {
                        var _currentImageTop = $(this).offset().top;
                        if (_currentImageTop - containerTop > 0 || $(this).not(':visible')) {
                            var _el = $(this);
                            setTimeout(function() {
                                _el.attr('src',_el.attr('data-lazy-src')).removeAttr('data-lazy-src');
                            }, j++ * 20);

                            if (j == 26) {
                                return false;
                            }
                        }
                    });
                }

            }, 500));
        });
    };

    var ddu = new impro.DragDropUpload();
    ddu.init('vimg-list', {
        url: impro.url + '/src/request/upload.php',
        onProgress: function(e, file, i, currentFileProgress, totalProgress) {
            /* show progress */
            $('#vimg-progress-wrapper').show();
            $('#vimg-progress').show().width(totalProgress + '%');
        },
        onCompleted: function(e, files, filesSucceeded, filesFailed) {
            /* the progress events before may not have succesfully reach 100%, so we do it here */
            $('#vimg-progress').show().width('100%');
            /* hide progress, but a bit later to allow the animation to complete */
            setTimeout(function() {
                $('#vimg-progress-wrapper').hide();
                $('#vimg-progress').width('0%');
            }, 500);

            /* get the target - in this case de XMLHttpRequest */
            var target = e.target || e.originalTarget || e.currentTarget;

            /* if we have files that failed uploading */
            if (0 !== filesFailed.length) {
                var errContent = "";

                errContent += "<div style='margin: 15px;'>";
                errContent += "<p style='margin-top: 0;'><strong>";

                if (filesFailed.length === files.length) {
                    errContent += "There was a general error and no files could be uploaded!";
                } else {
                    errContent += "" + filesFailed.length + " files of the total of " + files.length + " failed!";
                }

                errContent += "</strong></p>";

                errContent += "<p>Please check out the list below for error messages</p>";

                errContent += "<div style='height: 250px; overflow: auto;'>";
                errContent += "<table cellspacing='0' cellpadding='3' border='0'>";

                errContent += "<tr>";
                errContent += "<td style='font-weight: bold; width: 110px; border: 1px solid #ddd;'>";
                errContent += "Filename";
                errContent += "</td>";
                errContent += "<td style='font-weight: bold; width: 255px; border: 1px solid #ddd;'>";
                errContent += "Error";
                errContent += "</td>";
                errContent += "</tr>";

                for (var i = 0; i < filesFailed.length; i++) {
                    var httpErrStr = ('object' === typeof filesFailed[i].httpResponse ? filesFailed[i].httpResponse.data.str : ('string' === typeof filesFailed[i].httpResponse ? "" : ""));
                    errContent += "<tr>";
                    errContent += "<td style='border: 1px solid #ddd;'>";
                    errContent += filesFailed[i].name;
                    errContent += "</td>";
                    errContent += "<td style='border: 1px solid #ddd;'>";
                    errContent += "Status: " + filesFailed[i].httpStatus + ", " + httpErrStr;
                    errContent += "</td>";
                    errContent += "</tr>";
                }

                errContent += "</table>"
                errContent += "</div>";
                errContent += "</div>";

                $(errContent).dialog({
                    title: 'File upload error',
                    modal: true,
                    draggable: false,
                    resizable: false,
                    width: '400px',
                    dialogClass: 'wp-dialog',
                    buttons: [ { text: "Ok", click: function() { $( this ).dialog( "close" ); } } ]
                });
            }

            /* load images on the server */
            loadImages();
        }
    });

    /* public methods */
    $.extend(this, {
        init: init
    });
}).call(impro.folder = {}, jQuery);

jQuery(function($) {
	impro.folder.init();
});