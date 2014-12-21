(function($) {
    /* the nonce security token */
    var nonce = {};

    /* whether the browser is minimum IE10 (IE10, IE11, etc) */
    var minIE10 = navigator.userAgent.indexOf('MSIE 10') > 0 || (navigator.userAgent.indexOf('Trident') > 0 && /rv:[0-9][0-9]/.test(navigator.userAgent));

    /* error message */
    var err = function(str) {
        alert(str);
    };

    /* info message */
    var info = function(str) {
        alert(str);
    };

    var fakeImageResize = function () {
        var editor = tinyMCE.editors[0];
        var dom = editor.dom;
        var selection = editor.selection;
        var VK = tinyMCE.VK;
        var settings = editor.settings;

        var selectedElmX, selectedElmY, selectedElm, selectedElmGhost, selectedHandle, startX, startY, startW, startH, ratio,
            resizeHandles, width, height, rootDocument = document, editableDoc = editor.getDoc();

        if (settings.webkit_fake_resize === true) {
            alert('It seems that you are on a WebKit Browser (Chrome / Safari) '+
                'and your configuration has webkit_fake_resize = true.' +
                "\n\n" +
                "Please turn it off for the Image Pro Plugin to function correctly under WebKit browsers.\n\n" +
                "Contact us for more information!");
            return;
        }

        /*if (!settings.object_resizing || settings.webkit_fake_resize === false) {
         return;
         }*/

        // Try disabling object resizing if WebKit implements resizing in the future
        try {
            editor.getDoc().execCommand("enableObjectResizing", false, false);
        } catch (ex) {
            // Ignore
        }

        // Details about each resize handle how to scale etc
        resizeHandles = {
            // Name: x multiplier, y multiplier, delta size x, delta size y
            n: [.5, 0, 0, -1],
            e: [1, .5, 1, 0],
            s: [.5, 1, 0, 1],
            w: [0, .5, -1, 0],
            nw: [0, 0, -1, -1],
            ne: [1, 0, 1, -1],
            se: [1, 1, 1, 1],
            sw : [0, 1, -1, 1]
        };

        function resizeElement(e) {
            var deltaX, deltaY;

            // Calc new width/height
            deltaX = e.screenX - startX;
            deltaY = e.screenY - startY;

            // Calc new size
            width = deltaX * selectedHandle[2] + startW;
            height = deltaY * selectedHandle[3] + startH;

            // Never scale down lower than 5 pixels
            width = width < 5 ? 5 : width;
            height = height < 5 ? 5 : height;

            // Constrain proportions when modifier key is pressed or if the nw, ne, sw, se corners are moved on an image
            if (VK.modifierPressed(e) || (selectedElm.nodeName == "IMG" && selectedHandle[2] * selectedHandle[3] !== 0)) {
                width = Math.round(height / ratio);
                height = Math.round(width * ratio);
            }

            // Update ghost size
            dom.setStyles(selectedElmGhost, {
                width: width,
                height: height
            });

            // Update ghost X position if needed
            if (selectedHandle[2] < 0 && selectedElmGhost.clientWidth <= width) {
                dom.setStyle(selectedElmGhost, 'left', selectedElmX + (startW - width));
            }

            // Update ghost Y position if needed
            if (selectedHandle[3] < 0 && selectedElmGhost.clientHeight <= height) {
                dom.setStyle(selectedElmGhost, 'top', selectedElmY + (startH - height));
            }
        }

        function endResize() {
            /* IMAGEPRO - it is unknown why sometimes width and height come with zero values here. however, we skip this case */
            if (width === 0 || height === 0) {
                return;
            }

            // Set width/height properties
            dom.setAttrib(selectedElm, 'data-mce-width', width);
            dom.setAttrib(selectedElm, 'data-mce-height', height);
            dom.setAttrib(selectedElm, 'width', width);
            dom.setAttrib(selectedElm, 'height', height);

            dom.unbind(editableDoc, 'mousemove', resizeElement);
            dom.unbind(editableDoc, 'mouseup', endResize);

            if (rootDocument != editableDoc) {
                dom.unbind(rootDocument, 'mousemove', resizeElement);
                dom.unbind(rootDocument, 'mouseup', endResize);
            }

            // Remove ghost and update resize handle positions
            dom.remove(selectedElmGhost);
            showResizeRect(selectedElm);
        }

        function showResizeRect(targetElm) {
            var position, targetWidth, targetHeight;

            hideResizeRect();

            // Get position and size of target
            position = dom.getPos(targetElm);
            selectedElmX = position.x;
            selectedElmY = position.y;
            targetWidth = targetElm.offsetWidth;
            targetHeight = targetElm.offsetHeight;

            // Reset width/height if user selects a new image/table
            if (selectedElm != targetElm) {
                selectedElm = targetElm;
                width = height = 0;
            }

            tinymce.each(resizeHandles, function(handle, name) {
                var handleElm;

                // Get existing or render resize handle
                handleElm = dom.get('mceResizeHandle' + name);
                if (!handleElm) {
                    handleElm = dom.add(editableDoc.documentElement, 'div', {
                        id: 'mceResizeHandle' + name,
                        'class': 'mceResizeHandle',
                        style: 'cursor:' + name + '-resize; margin:0; padding:0'
                    });

                    dom.bind(handleElm, 'mousedown', function(e) {
                        e.preventDefault();

                        endResize();

                        startX = e.screenX;
                        startY = e.screenY;
                        startW = selectedElm.clientWidth;
                        startH = selectedElm.clientHeight;
                        ratio = startH / startW;
                        selectedHandle = handle;

                        selectedElmGhost = selectedElm.cloneNode(true);
                        dom.addClass(selectedElmGhost, 'mceClonedResizable');
                        dom.setStyles(selectedElmGhost, {
                            left: selectedElmX,
                            top: selectedElmY,
                            margin: 0
                        });

                        editableDoc.documentElement.appendChild(selectedElmGhost);

                        dom.bind(editableDoc, 'mousemove', resizeElement);
                        dom.bind(editableDoc, 'mouseup', endResize);

                        if (rootDocument != editableDoc) {
                            dom.bind(rootDocument, 'mousemove', resizeElement);
                            dom.bind(rootDocument, 'mouseup', endResize);
                        }
                    });
                } else {
                    dom.show(handleElm);
                }

                // Position element
                dom.setStyles(handleElm, {
                    left: (targetWidth * handle[0] + selectedElmX) - (handleElm.offsetWidth / 2),
                    top: (targetHeight * handle[1] + selectedElmY) - (handleElm.offsetHeight / 2)
                });
            });

            // Only add resize rectangle on WebKit and only on images
            if (!tinymce.isOpera && selectedElm.nodeName == "IMG") {
                selectedElm.setAttribute('data-mce-selected', '1');
            }
        }

        function hideResizeRect() {
            if (selectedElm) {
                selectedElm.removeAttribute('data-mce-selected');
            }

            for (var name in resizeHandles) {
                dom.hide('mceResizeHandle' + name);
            }
        }

        // Add CSS for resize handles, cloned element and selected
        var css = '.mceResizeHandle {' +
            'position: absolute;' +
            'border: 1px solid black;' +
            'background: #FFF;' +
            'width: 5px;' +
            'height: 5px;' +
            'z-index: 10000' +
            '}' +
            '.mceResizeHandle:hover {' +
            'background: #000' +
            '}' +
            'img[data-mce-selected] {' +
            'outline: 1px solid black' +
            '}' +
            'img.mceClonedResizable, table.mceClonedResizable {' +
            'position: absolute;' +
            'outline: 1px dashed black;' +
            'opacity: .5;' +
            'z-index: 10000' +
            '}';

        var el = editor.getDoc().createElement('style');
        el.innerHTML = css;
        editor.getDoc().getElementsByTagName('head')[0].appendChild(el);

        function updateResizeRect() {
            var controlElm = dom.getParent(selection.getNode(), 'table,img');

            // Remove data-mce-selected from all elements since they might have been copied using Ctrl+c/v
            tinymce.each(dom.select('img[data-mce-selected]'), function(img) {
                img.removeAttribute('data-mce-selected');
            });

            if (controlElm) {
                showResizeRect(controlElm);
            } else {
                hideResizeRect();
            }
        }

        // Show/hide resize rect when image is selected
        editor.onNodeChange.add(updateResizeRect);

        // Fixes WebKit quirk where it returns IMG on getNode if caret is after last image in container
        dom.bind(editableDoc, 'selectionchange', updateResizeRect);

        // Remove the internal attribute when serializing the DOM
        editor.serializer.addAttributeFilter('data-mce-selected', function(nodes, name) {
            var i = nodes.length;

            while (i--) {
                nodes[i].attr(name, null);
            }
        });

        /* IMAGEPRO - extracted a private method to public to be able to refresh the handles */
        impro.updateResizeRect = updateResizeRect;
    };

    var createThumbUrl = function(params) {
        var path = impro.url + '/src/thumb/phpThumb.php?';
        var tmp = [];
        for (var p in params) {
            if (['w','h','src','zc','q'].indexOf(p) === -1) {
                continue;
            }
            if (params.hasOwnProperty(p)) {
                tmp.push(p+'='+params[p]);
            }
        }
        return path + tmp.join('&');
    };

    var parseUrl = function(url) {
        var path = {};

        /* if begins with http(s?):// protocol */
        var is_http = /^https?:\/\/$/i.test(url);
        /* if contains phpThumb.php */
        var is_thumb = url.indexOf('/src/thumb/phpThumb.php') !== -1;

        if (is_thumb) {
            path['thumb'] = true;

            url.split('?')[1].split('&').forEach(function(v){
                var tmp = v.split('=');

                /* we have the width, height, quality and zoom-crop */
                if (tmp[0] === 'w' || tmp[0] === 'h' || tmp[0] === 'q' || tmp[0] === 'zc') {
                    tmp[1] = parseInt(tmp[1], 10);
                    /* not a numeric value, don't consider */
                    if (isNaN(tmp[1])) {
                        return;
                    }
                }

                path[tmp[0]] = tmp[1];
            });

            path['url'] = url;
        } else {
            path['thumb'] = false;
            path['url'] = url;
            path['src'] = path['url'];
        }

        return path;
    };

    /* public methods */
    $.extend(this, {
        nonce: nonce,
        err: err,
        info: info,
        minIE10: minIE10,
        fakeImageResize: fakeImageResize
    });
}).call(window.impro = {}, jQuery);