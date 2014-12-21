(function($) {

    /* the minimum width and height to which images can be resized */
    var MIN_W = 40;
    var MIN_H = 40;

    /* references to jQuery elements */
    var $editor, $imgSize, $imgW, $imgH, $imgMaxW, $imgAlign, $imgCaption, $imgFrame;
    var $clickedImage;

    /* the maximum width imposed by the current theme, if applicable */
    var themeMaxWidth;

    var init = function() {
        /* set a reference to the image editor and other elements */
        $editor = $('#impro_editor');
        $imgSize = $('#impro-editor-size');
        $imgW = $('#impro-editor-w');
        $imgH = $('#impro-editor-h');
        $imgMaxW = $('#impro-editor-maxwidth');
        $imgAlign = $('#impro-align').find('li');
        $imgCaption = $('#impro-cpt');
        $imgFrame = $('#impro-frm').find('li');

        /* start with the editor closed */
        $('#impro_editor_box').addClass('closed').find('.handlediv').hide();

        /* init events */
        initEvents();

        /* if the visual editor is enabled in the user preferences */
        if ($('#edButtonPreview').size() > 0 || $('#content-tmce').size() > 0) {
            /* hook up the switchEditors to find out when the editor is changed */
            /* TODO: This does not work for WordPress 3.2 */
            try {
                switchEditors.old_go = switchEditors.go;
                switchEditors.go = function(id, mode) {
                    switchEditors.old_go(id, mode);
                    onSwitchEditor(id, mode);
                };
            } catch(ex) {}

            /* tinyMCE will start initialization soon */
            var tinymceInitTimer = setInterval(function() {
                if (window.tinymce && getTinyMCE()) {
                    clearInterval(tinymceInitTimer);

                    /* prevent the user opening the image settings panel */
                    $('#impro_editor_box').find('.hndle').unbind('click');

                    /* initialize the editor */
                    onEditorInit(getTinyMCE());
                }
            }, 300);
        } else {
            impro.err(imageproEditorL10N.enableTinyMce);
        }
    };

    var getTinyMCE = function() {
        return tinymce.get('content');
    };

    var onEditorInit = function(editor) {
        /* now waiting for the iframe inside to render the post and have the body */
        var timer = setInterval(function() {
            /*
            of course tinymce.getDoc() is better, but in case of non existing,
            the jquery is easier to check
             */
            var $body = $(getTinyMCE().contentAreaContainer).find('iframe').contents().find('body');
            if ($body.length) {
                clearInterval(timer);

                /* link the click event to tiny mce */
                setTinyMCEInteractions($body, getTinyMCE());

                /* if we are re on Chrome or Safari, try to simulate the resize handles,
                but only if we're still on TinyMCE 3.X.
                TinyMCE 4 implemented it in the editor for Webkit */
                if (window.tinymce.isWebKit && window.tinymce.majorVersion != 4) {
                    impro.fakeImageResize();
                }
            }
        }, 300);
    };

    /**
     * starting with TinyMCE 4, in WebKit browsers and IE, it becomes
     * harder to drop images over the TinyMCE editor.
     * the reason is that the body does not have a fixed height
     * and if the post is empty or with very few content, the drop zone
     * exists only over that content.
     * this function attempts to fix this issue by ensuring that the
     * min-height of the body is just like the height of it's container
     * so that the drop zone is maximized.
     * TODO also get called on panel resize
     */
    var updateTinyMCEBodyToOuterIframeContainerHeight = function() {
        var $editorIframe = $(getTinyMCE().contentAreaContainer).find('iframe');
        var $body = $editorIframe.contents().find('body');
        var iframeHeight = $editorIframe.height();

        if (!isNaN(parseInt(iframeHeight))) {
            /* trying -25 to prevent vertical scrolling - may need special tuning later */
            $body.css('min-height', (iframeHeight - 25) + 'px');
        }
    };

    var setTinyMCEInteractions = function(body, editor) {

        /* get max width for images, if set by the WordPress theme */
        themeMaxWidth = getThemeMaxWidth(body);
        if ('number' !== typeof themeMaxWidth) {
            /* if the theme is not responsive, the responsiveness checkbox should be hidden */
            $('#impro-editor-maxwidth-container').hide();
        } else {
            $('#impro-editor-maxwidth-info').html($('#impro-editor-maxwidth-info').html().replace('%maxwidth%', themeMaxWidth));
        }

        /* update tinymce iframe body height */
        updateTinyMCEBodyToOuterIframeContainerHeight();

        /* block dragging of captioned/framed images */
        body.on('dragstart', '.wp-caption img', function(ev) {
            alert(imageproEditorL10N.noDrag);
            return false;
        });

        /* hide image toolbar buttons for tinymce 4 */
        if (window.tinymce.majorVersion == 4) {
            try {
                // TODO replace with editor_styles later
                $(getTinyMCE().getDoc().head).append('<style>#wp-image-toolbar { display: none !important; } img {cursor: move;} .wp-caption img {cursor: not-allowed;}</style>');
            } catch(e) {}
        }

        /* register drop event to catch drops */
        setInterval(function() {
            /* because the ondrop event is not at all reliable
             * not to say about its cross browser support,
             * I used a interval checking (polling) */
            var thumbs = body.find('img[src*="\\/thumb\\/phpThumb\\.php"]');

            /* in case we have an image with a frame,
            we look for the data-imagepro-frames attribute
            on the image tag, and if it exists and it does not
            exist on the .wp-caption, then we add it there as well
             */
            var unUpdatedFrames = body.find('.wp-caption').not('[class*="imagepro"]');
            if (unUpdatedFrames.length > 0) {
                unUpdatedFrames.each(function(i) {
                    $(this).addClass($(this).find('[data-imagepro-frames]').attr('data-imagepro-frames'));
                });
            }
            /* the same for alignments */
            var unUpdatedAlignments = body.find('.wp-caption img');
            if (unUpdatedAlignments.length > 0) {
                unUpdatedAlignments.each(function(i) {
                    var alignMatch = (this.className || '').match(/(alignnone|alignleft|aligncenter|alignright)/);
                    if (alignMatch && alignMatch[1]) {
                        if (!$(this).closest('.wp-caption').hasClass(alignMatch[1])
                            || !$(this).closest('.mceTemp').hasClass(alignMatch[1])) {
                            $(this).closest('.wp-caption').addClass(alignMatch[1]);
                            $(this).closest('.mceTemp').addClass(alignMatch[1]);
                        }
                    }
                });
            }

            if (thumbs.length > 0) {
                thumbs.each(function(i) {
                    /* get source image */
                    var thumb_w = $(this).width();
                    var thumb_h = $(this).height();

                    /* sometimes, these are 0. if so, we set them to minimum 50 */
                    if (0 === thumb_w) {
                        thumb_w = MIN_W;
                    }
                    if (0 === thumb_h) {
                        thumb_h = MIN_H;
                    }

                    var src = $(this).attr('src');
                    var pic_src;

                    /* get picture source */
                    var match = /\/thumb\/phpThumb\.php\?.*?&src=([^&]*)&?/i.exec(src);
                    if (match != null) {
                        pic_src = match[1];
                    }

                    /* apply picture source and dimensions */
                    if (pic_src) {
                        $(this).attr('src', pic_src).attr('data-mce-src', pic_src).attr('_mce_src', pic_src);
                        $(this).attr('width', thumb_w).attr('data-mce-width', thumb_w).attr('_mce_width', thumb_w);
                        $(this).attr('height', thumb_h).attr('data-mce-height', thumb_h).attr('_mce_height', thumb_h);

                        /* open the editor, for the last one
                         in theory, it should be JUST one, but if the user is fast enough
                         to drag more, we should only open the editor for one, in order
                         not to slow down the UI
                         we open the editor by simulating a mouseup on the image */
                        if (thumbs.length - 1 === i) {
                            var outerThis = this;
                            setTimeout(function() {
                                $(outerThis).trigger(impro.minIE10 ? 'mousedown' : 'click');
                            }, 100);
                        }
                    }
                });
            }
        }, 300);

        /* set the click event on body, then limit by images */
        body.bind(impro.minIE10 ? 'mousedown' : 'click', function(ev) {
            var target = $(ev.target);
            /* only process image clicks */
            if (target.is('img')) {
                showEditor(target);
            } else if (target.closest('.wp-caption').length > 0) {
                showEditor(target.closest('.wp-caption').find('img'));
            } else if (!(target.is('body') && target.find('img[data-mce-selected]').length > 0)) {
                /* on Chrome, when resizing an image, the selected image panel closes
                that's because it is similar to clicking outside it.
                for this, before closing the panel, we check if the image is still selected.
                if it is, do nothing (keep it open), if not, close the panel */
                closeEditor();
            }
            return true;
        });
    };

    var openEditor = function() {
        $('#impro_editor_box').removeClass('closed');
    };

    var closeEditor = function() {
        $('#impro_editor_box').addClass('closed');
    };

    /**
     * populates the editor in the right with the properties of the currently selected image
     * @param target the clicked image, as a jQuery element
     */
    var showEditor = function(target) {

        var currentSrc = $(target).attr('src');
        var currentDomain = document.location.protocol + '//' + document.location.host;

        /* if the image begins with http://my.domain/, it was uploaded with classic wordpress upload,
        or it was just moved around the document so it got a http:// at the beginning */
        if (0 === currentSrc.indexOf(currentDomain + '/')) {
            currentSrc = currentSrc.replace(currentDomain, '');
            target.attr('src', currentSrc).attr('data-mce-src', currentSrc).attr('_mce_src', currentSrc);
        }

        /* if does not begin with /, it means it is from an external domain */
        if (currentSrc[0] != "/") {
            impro.err(imageproEditorL10N.differentDomain);
            return;
        }

        /* open the editor panel */
        openEditor();

        /* remember the clicked image (currently in editor) */
        $clickedImage = null;
        $clickedImage = new impro.image(target, getTinyMCE());

        /* show thumb image in the panel to the right */
        $('#impro-preview').css({
            'background-image': 'url("' + $clickedImage.getSrc() + '")'
        });

        /* set the small frame icons with the current image */
        $imgFrame.find('small').css({
            'background-image': 'url("' + $clickedImage.getSrc() + '")',
            'background-size': 'cover'
        })

        /* set alt and title */
        $('.impro_alt').val($clickedImage.getAlt());
        $('.impro_title').val($clickedImage.getTitle());

        var align = $clickedImage.getAlignment();
        $imgAlign.removeClass('impro-align-selected');
        $imgAlign.filter('li[data-align="' + align + '"]').addClass('impro-align-selected');

        /* set link */
        if ($clickedImage.hasLink()) {
            $('.impro_link').attr('checked', 'checked');
        } else {
            $('.impro_link').removeAttr('checked');
        }

        /* decide if responsiveness checkbox should be displayed */
        var hasInlineMaxWidthNone = $clickedImage.extendedBeyondResponsiveness();

        /* if this image has a responsiveness setting attached */
        if (hasInlineMaxWidthNone || 'number' === typeof themeMaxWidth) {
            $('#impro-editor-maxwidth').show();
            if (hasInlineMaxWidthNone) {
                $('#impro-editor-maxwidth').attr('checked', 'checked');
            } else {
                $('#impro-editor-maxwidth').removeAttr('checked');
            }
        } else {
            $('#impro-editor-maxwidth').hide();
        }

        /* set image caption */
        $imgCaption.val($clickedImage.getCaption());

        var frame = $clickedImage.getFrame();
        $imgFrame.removeClass('impro-frame-selected');
        $imgFrame.filter('[data-value="' + frame + '"]').addClass('impro-frame-selected');

        /* set the size preset */
        selectCorrectPreset($clickedImage.getWidth(), $clickedImage.getHeight());

        /* set the height and width */
        $imgW.val($clickedImage.getWidth());
        $imgH.val($clickedImage.getHeight());
    };

    /* updates the image preset select box with the correct setting depending on the image size */
    var selectCorrectPreset = function(w, h) {
        /* set the size preset */
        var fullWidth = $clickedImage.getNaturalWidth();
        var fullHeight = $clickedImage.getNaturalHeight();

        /* the value to select at the end */
        var valueToSelect;

        /* if the image is the full size */
        if (fullWidth == w && fullHeight == h) {
            valueToSelect = '__full';
        }

        /* if not yet chosen */
        if (!valueToSelect) {
            /* search among the presets */
            $imgSize.find('option[data-preset-width]').each(function() {
                var presetWidth = parseInt($(this).attr('data-preset-width'), 10);
                if (presetWidth == w) {
                    valueToSelect = $(this).attr('value');
                    return false;
                }
            });
        }

        /* if not yet chosen */
        if (!valueToSelect) {
            if ('number' === typeof themeMaxWidth && w == themeMaxWidth && !$imgMaxW.is(':checked')) {
                valueToSelect = '__full';
            }
        }

        /* if not yet chosen */
        if (!valueToSelect) {
            valueToSelect = '__custom';
        }

        /* apply the selected value */
        $imgSize.val(valueToSelect);
    }

    /**
     * gets the current WordPress theme max-width, as set by its CSS stylesheets
     * @param $tinyMCEBody the reference to the jQuery body element tag inside the TinyMCE iframe
     * @returns {number|undefined} the maximum width recommended by the theme, or undefined if not defined
     */
    var getThemeMaxWidth = function($tinyMCEBody) {
        var tempImgMaxWidthTest = $('<img />').appendTo($tinyMCEBody);
        var tempMaxWidth = tempImgMaxWidthTest.css('max-width');
        tempImgMaxWidthTest.remove();
        tempImgMaxWidthTest = null;

        if ('string' === typeof tempMaxWidth) {
            /* if it is given as pixels (eg. 474px), return it */
            if (tempMaxWidth.indexOf('px') > -1) {
                tempMaxWidth = parseInt(tempMaxWidth, 10);
                if (!isNaN(tempMaxWidth)) {
                    return tempMaxWidth;
                }
            } else if (tempMaxWidth.indexOf('%') > -1) {    /* if it is given as percent */
                /* look for a pixel value on its parent body */
                tempMaxWidth = $tinyMCEBody.css('max-width');
                /* if it is defined in pixels, return it */
                if ('string' === typeof tempMaxWidth && tempMaxWidth.indexOf('px') > -1) {
                    tempMaxWidth = parseInt(tempMaxWidth, 10);
                    if (!isNaN(tempMaxWidth)) {
                        return tempMaxWidth;
                    }
                }
            }
        }
    };

    var getPresetSizeFor = function(presetId) {
        var fullWidth = $clickedImage.getNaturalWidth();
        var fullHeight = $clickedImage.getNaturalHeight();
        var proportion = fullWidth / fullHeight;

        if ('__full' === presetId) {
            return {
                width: fullWidth,
                height: fullHeight
            };
        } else if ('__custom' === presetId) {
            return {
                width: parseInt($clickedImage.getWidth(), 10),
                height: parseInt($clickedImage.getHeight(), 10)
            };
        } else {
            var $opt = $imgSize.find('option[value="' + presetId + '"]');
            return {
                width: parseInt($opt.attr('data-preset-width'), 10),
                height: Math.round(parseInt($opt.attr('data-preset-width'), 10) / proportion)
            }
        }
    };

    var setImageSize = function(newWidth, newHeight) {
        /* set image dimensions */
        $clickedImage.setWidth(newWidth);
        $clickedImage.setHeight(newHeight);

        /* clear old inline styles, as they interfere with responsiveness */
        $clickedImage.clearInlineStyles();

        /* update styles */
        $clickedImage.updateComplexImageSize();

        /* update the resizing rectangle to match the new image dimension */
        if (window.tinymce.isWebKit && window.tinymce.majorVersion != 4) {
            impro.updateResizeRect();
        }
    };

    /**
     * This function is triggered when any UI event that changes
     * a property of the image occurs from the Image Editor panel
     * in the right, and inside this function, action is taken
     * depending of the input field that changed. At the end, the
     * selected image in the post editor is updated with the new
     * settings
     */
    var updateImageSettings = function() {
        /* get the current width and height of the image */
        var newWidth = parseInt($clickedImage.getWidth(), 10);
        var newHeight = parseInt($clickedImage.getHeight(), 10);
        /* get the full width and height (the original size) of the image */
        var fullWidth = $clickedImage.getNaturalWidth();
        var fullHeight = $clickedImage.getNaturalHeight();
        /* the max-width value of the image */
        var maxWidth;
        /* compute the proportion between the width and the height of the image */
        var proportion = fullWidth / fullHeight;

        /* if we are changing the size preset */
        if (this.is($imgSize)) {
            /* get the preset size object */
            var presetSize = getPresetSizeFor($imgSize.val());
            newWidth = presetSize.width;
            newHeight = presetSize.height;

            /* if the responsiveness checkbox is checked */
            if ($imgMaxW.is(':checked')) {
                maxWidth = 'none';
            } else {
                maxWidth = '';
                /* resize to max-width */
                if ('number' === typeof themeMaxWidth && newWidth > themeMaxWidth) {
                    newWidth = themeMaxWidth;
                    newHeight = parseInt(newWidth / proportion, 10);
                }
            }
        }

        /* if we are toggling the responsiveness checkbox */
        if (this.is($imgMaxW)) {
            if ($imgMaxW.is(':checked')) {
                maxWidth = 'none';
                /* get the width from the manual size input */
                /* if it is full size or other size (except custom), take it from the dropdown */
                if ('__custom' !== $imgSize.val()) {
                    /* get the preset size object */
                    var presetSize = getPresetSizeFor($imgSize.val());
                    newWidth = presetSize.width;
                    newHeight = presetSize.height;
                } else {
                    newWidth = $imgW.val();
                    newHeight = parseInt(newWidth / proportion, 10);
                }
            } else {
                maxWidth = '';
                /* resize to max-width */
                if ('number' === typeof themeMaxWidth && newWidth > themeMaxWidth) {
                    newWidth = themeMaxWidth;
                    newHeight = parseInt(newWidth / proportion, 10);
                }
            }
        }

        /* if we are changing the size manually */
        if (this.is($imgW) || this.is($imgH)) {
            if (this.is($imgW)) {
                newWidth = parseInt(this.val(), 10);
                if (!isNaN(newWidth)) {
                    newHeight = parseInt(newWidth / proportion);
                }
            } else if (this.is($imgH)) {
                newHeight = parseInt(this.val(), 10);
                if (!isNaN(newHeight)) {
                    newWidth = parseInt(newHeight * proportion);
                }
            }

            /* any action on the custom fields should change the size dropdown to custom */
            if ('__custom' !== $imgSize.val()) {
                $imgSize.val('__custom');
            }
        }

        /* set image dimensions */
        if (newWidth && newHeight) {

            /* if it is too small, just add an error class */
            if (newWidth < MIN_W || newHeight < MIN_H) {
                $imgW.add($imgH).addClass('impro-editor-wh-error');
                return;
            } else if ('number' === typeof themeMaxWidth && themeMaxWidth < newWidth && !$imgMaxW.is(':checked')) {
                $imgW.add($imgH).addClass('impro-editor-wh-error');
                return;
            } else {
                $imgW.add($imgH).removeClass('impro-editor-wh-error');
            }

            /* change image size */
            setImageSize(newWidth, newHeight);

            /* update the width/height inputs */
            $imgW.val(newWidth);
            $imgH.val(newHeight);
        }
        /* set the max-width */
        $clickedImage.setMaxWidth(maxWidth);
    };

    var initEvents = function() {

        /* make the responsiveness label toggleable */
        $('#impro-editor-maxwidth-help').on('click', function() {
            $('#impro-editor-maxwidth-info').toggle(400);
        });

        $imgCaption.on('change keyup', function(ev) {
            $clickedImage.setCaption($(this).val());
        });

        $imgFrame.on('click', function(ev) {
            var val = $(this).attr('data-value');

            $imgFrame.removeClass('impro-frame-selected');
            $(this).addClass('impro-frame-selected');

            $clickedImage.setFrame(val);
        });

        $imgAlign.on('click', function(ev) {
            $imgAlign.removeClass('impro-align-selected');
            $(this).addClass('impro-align-selected');
            changeProps(ev);
        });

        $imgSize.bind('change', function(ev) {
            updateImageSettings.call($(this));
        });

        $imgMaxW.bind('change', function(ev) {
            updateImageSettings.call($(this));
        });

        $imgW.add($imgH).bind('keyup change', function(ev) {
            updateImageSettings.call($(this));
            ev.stopImmediatePropagation(); /* keyup and change are bound. we only need one to get it */
        });

        $('.impro_alt, .impro_title').bind('change keyup', changeProps);

        $('.impro_link').click(function() {
            if ($(this).is(':checked')) {
                $clickedImage.setLink($clickedImage.getSrc());
            } else {
                $clickedImage.setLink(null);
            }
        });

        /* there is no consistent and 100% correct way to be notified on the image's resize. that's why we use polling */
        var tInterval = 0;
        tInterval = setInterval(function() {
            if ($clickedImage && $clickedImage instanceof impro.image) {
                /* do not refresh manual size inputs while user is making changes (is in focus there) */
                if ($imgW.is(':focus') || $imgH.is(':focus')) {
                    return;
                }

                /* if the image is not attached any more to the body */
                if (!$clickedImage.isAttachedToBody()) {
                    closeEditor();
                }

                /* get previous size data */
                var prevW = $clickedImage.getPreviousWidth();
                var prevH = $clickedImage.getPreviousHeight();
                var currentW = $clickedImage.getWidth();
                var currentH = $clickedImage.getHeight();

                /* DeMorgan Law. if no size previously or different sizes, update UI and image data size cache */
                if (((prevW !== undefined && prevH !== undefined) && (prevW !== currentW || prevH !== currentH)) || (!(prevW !== undefined && prevH !== undefined))) {
                    /* >0 is used to not intercept the images that are just being added, until they get loaded */
                    /* prevent resizing to very small images - disabled for the moment because of a bug
                    if ((currentW < MIN_W || currentH < MIN_H) && (currentW > 0 || currentH > 0)) {
                        var fullWidth = $clickedImage[0].naturalWidth;
                        var fullHeight = $clickedImage[0].naturalHeight;
                        var proportion = fullWidth / fullHeight;

                        if (currentW < currentH) {
                            currentW = MIN_W + 20;
                            currentH = currentW / proportion;
                        } else {
                            currentH = MIN_H + 20;
                            currentW = currentH * proportion;
                        }

                        setImageSize(currentW, currentH);

                        alert('You cannot resize an image to a size smaller than ' + MIN_W + 'x' + MIN_H + ' pixels!');
                    }
                    //*/

                    /* round values */
                    currentW = Math.round(currentW);
                    currentH = Math.round(currentH);

                    /* set custom sizes */
                    $imgW.val(currentW);
                    $imgH.val(currentH);
                    $clickedImage.setPreviousWidth(currentW);
                    $clickedImage.setPreviousHeight(currentH);

                    /* if image has caption */
                    $clickedImage.updateComplexImageSize();

                    /* set the size preset */
                    selectCorrectPreset(currentW, currentH);
                }
            }
        }, 200);

        var changeProps = function(ev) {
            /* preview */
            $clickedImage.setAlt($('.impro_alt').val());
            $clickedImage.setTitle($('.impro_title').val());

            var align = $imgAlign.filter('li.impro-align-selected').attr('data-align');
            $clickedImage.setAlignment(align);

            ev.stopImmediatePropagation();
        };

    };

    var onSwitchEditor = function(id, mode) {

    };

    /* public methods */
    $.extend(this, {
        init: init,
        getTinyMCE: getTinyMCE
    });
}).call(impro.editor = {}, jQuery);

jQuery(function() {
	impro.editor.init();
});