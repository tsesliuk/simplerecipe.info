impro.image = function($el, tinymce) {

    var $ = jQuery;

    /* remove the inline styles */
    $el.css({
        width: '',
        height: ''
    });
    $el.removeAttr('data-mce-style');

    /* remember the old source */
    $el.data('oldSrc', $el.attr('src'));

    /* alternative text */
    var getAlt = function() {
        return $el.attr('alt');
    };
    var setAlt = function(newAlt) {
        $el.attr('alt', newAlt);
        $el.attr('_mce_alt', newAlt);
    };

    /* title */
    var getTitle = function() {
        return $el.attr('title');
    };
    var setTitle = function(newTitle) {
        $el.attr('title', newTitle);
        $el.attr('_mce_title', newTitle);
    };

    /* alignment */
    var getAlignment = function() {
        var checkOn = $el;
        if (!isSimpleImage()) {
            checkOn = $el.closest('.wp-caption');
        }
        var align = "alignnone";
        if (checkOn.hasClass('alignleft')) {
            align = "alignleft";
        } else if (checkOn.hasClass('aligncenter')) {
            align = "aligncenter";
        } else if (checkOn.hasClass('alignright')) {
            align = "alignright";
        }
        return align;
    };
    var setAlignment = function(newAlign) {
        $el.removeClass('alignnone alignleft aligncenter alignright');
        $el.addClass(newAlign);

        if (!isSimpleImage()) {
            $el.closest('.wp-caption').removeClass('alignnone alignleft aligncenter alignright');
            $el.closest('.mceTemp').removeClass('alignnone alignleft aligncenter alignright');
            $el.closest('.wp-caption').addClass(newAlign);
            $el.closest('.mceTemp').addClass(newAlign);

            updateComplexImageSize();
        }

        $el.attr('_mce_class', $el.attr('class'));

        refreshEditor();
    };
    var hasLink = function() {
        return $el.parent().is('a[href]');
    };
    var getLink = function() {
        if (hasLink()) {
            return $el.parent().attr('href');
        } else {
            return null;
        }
    };
    var setLink = function(newLink, newTarget) {
        /* if already has a link, remove it */
        if (hasLink()) {
            $el.unwrap();
        }
        /* and if will set a link, add it */
        if (newLink) {
            $el.wrap('<a href="' + newLink + '" target="' + (newTarget ? newTarget : '_blank') + '"></a>');
        }

        refreshEditor();
    };

    /* dimensions */
    var getWidth = function() {
        return $el.width();
    };
    var getHeight = function() {
        return $el.height();
    };
    var getNaturalWidth = function() {
        return $el[0].naturalWidth;
    };
    var getNaturalHeight = function() {
        return $el[0].naturalHeight;
    };
    var setWidth = function(newWidth) {
        $el.attr('width', newWidth).attr('data-mce-width', newWidth).attr('_mce_width', newWidth);
    };
    var setHeight = function(newHeight) {
        $el.attr('height', newHeight).attr('data-mce-height', newHeight).attr('_mce_height', newHeight);
    };
    var getPreviousWidth = function() {
        return $el.data('prevW');
    };
    var getPreviousHeight = function() {
        return $el.data('prevH');
    };
    var setPreviousWidth = function(previousWidth) {
        $el.data('prevW', previousWidth);
    };
    var setPreviousHeight = function(previousHeight) {
        $el.data('prevH', previousHeight);
    };
    var updateComplexImageSize = function(){
        if (!isSimpleImage()) {
            $el.closest('.wp-caption').width($el.outerWidth(true));
            $el.closest('.mceTemp').width($el.outerWidth(true));
        }
    };

    /* caption */
    /*
    wordpress refuses to save empty captions. because of this,
    we have to workaround and simulate an empty caption by using
    an empty tag, which we hide with CSS.
    in this way, the caption is being saved like the tag and we can
    actually save images with appearently empty captions
     */
    var getCaption = function() {
        if (isSimpleImage()) {
            return '';
        }

        /* try to get it from the image element */
        var caption = $el.data('improCaption');

        /* it it couldn't be obtained (for example it was not yet changed), get it from the caption tag */
        if (!caption) {
            caption = $el.closest('.wp-caption').find('.wp-caption-dd').html();
        }

        /* if could not be obtained, just set it to empty */
        if (!caption) {
            caption = '';
        }

        /* <small> is our convention of empty caption, so it means it's empty */
        if (/<small\s*\/>|<small><\/small>/.test(caption)) {
            caption = '';
        }

        return caption;
    };
    var setCaption = function(newCaption) {
        if (newCaption.length > 0) {
            setComplexImage();
            $el.data('improCaption', newCaption);
            $el.closest('.wp-caption').find('.wp-caption-dd').html(newCaption);
        } else {
            $el.removeData('improCaption');
            $el.closest('.wp-caption').find('.wp-caption-dd').html('<small />');
            setSimpleImage();
        }
    };

    var extendedBeyondResponsiveness = function() {
        return /max-width\s*:\s*none/.test($el[0].style.cssText);
    };
    var getSrc = function() {
        return $el.attr('src');
    };

    /* frame */
    var getFrame = function() {
        if (isSimpleImage()) {
            return 'none';
        } else {
            return $el.attr('data-imagepro-frames') || "none";
        }
    };
    var setFrame = function(newFrame) {
        $el.removeAttr('data-imagepro-frames');
        $el.closest('.wp-caption').removeClass("imagepro-polaroid imagepro-round imagepro-radius");

        if (newFrame !== 'none') {
            setComplexImage();
            $el.attr('data-imagepro-frames', newFrame);
            $el.closest('.wp-caption').addClass(newFrame);
            updateComplexImageSize();
        } else {
            setSimpleImage();
        }

        refreshEditor();
    };

    var clearInlineStyles = function() {
        $el.css('width', '');
        $el.css('height', '');
    };
    var setMaxWidth = function(maxWidth) {
        if ('none' === maxWidth || '' === maxWidth) {
            $el.css('max-width', maxWidth);
            /* also remove it from data-mce-style, as it transmits it further and we do not need it */
            if ('' === maxWidth) {
                var dataMCEStyle = $el.attr('data-mce-style');
                if ('string' === typeof dataMCEStyle) {
                    dataMCEStyle = dataMCEStyle.replace(/max-width\s*:\s*none\s*;?/g, '');
                    $el.attr('data-mce-style', dataMCEStyle);
                }
            }
        }
    };
    var isSimpleImage = function() {
        return $el.closest('.wp-caption').length === 0;
    };
    var setComplexImage = function() {
        if (!isSimpleImage()) {
            return;
        }

        /* get current align, so we can set it after creating the complex as well */
        var align = getAlignment();

        /* get current link, so we can set it after creating the complex as well */
        var link = getLink();
        /* we temporarily remove the link so it won't be kept outside the markup and shortcode */
        setLink(null);

        // TODO can the shortcode API be used in any way?
        $el.wrap('<dt class="wp-caption-dt" />');
        $el.closest('.wp-caption-dt').after('<dd class="wp-caption-dd"><small></small></dd>');
        var dt = $el.closest('.wp-caption-dt');
        var dd = dt.next('.wp-caption-dd');
        dt.add(dd).wrapAll('<dl class="wp-caption" />');
        var dl = $el.closest('.wp-caption');
        dl.css('width', $el.attr('width') + 'px');
        dl.wrap('<div class="mceTemp mceIEcenter" />');
        dl.closest('.wp-caption').find('.wp-caption-dd').get(0).contentEditable = false;
        //dl.closest('.mceTemp').get(0).contentEditable = false;
        // tinymce.get('content').selection.select(e)

        /* set the align after creating the complex image */
        setAlignment(align);

        /* set the link after creating the complex image */
        setLink(link);
    };
    var canBecomeSimpleImage = function() {
        return getCaption().length === 0 && getFrame() === 'none';
    };

    var setSimpleImage = function() {
        if (isSimpleImage()) {
            return;
        }

        if (!canBecomeSimpleImage()) {
            return;
        }

        /* get current link, so we can set it after creating the simple as well */
        var link = getLink();
        /* we temporarily remove the link so it won't be kept outside the markup and shortcode */
        setLink(null);

        $el.unwrap();
        $el.next('.wp-caption-dd').remove();
        $el.unwrap().unwrap();

        /* set the link after creating the simple image */
        setLink(link);
    };

    var isAttachedToBody = function() {
        return $el.closest('body').length > 0;
    };

    var refreshEditor = function() {
        try {
            tinymce.save();
        } catch(e) {}
    };


    /*
    in the future: update the editor:
    - tinymce.get('content').save()
    - tinymce.get('content').fire('AddUndo')
    - tinymce.get('content').undoManager.add({})
     */

    return $.extend(this, {
        getWidth: getWidth,
        getHeight: getHeight,
        setWidth: setWidth,
        setHeight: setHeight,
        getNaturalWidth: getNaturalWidth,
        getNaturalHeight: getNaturalHeight,
        getPreviousWidth: getPreviousWidth,
        getPreviousHeight: getPreviousHeight,
        setPreviousWidth: setPreviousWidth,
        setPreviousHeight: setPreviousHeight,

        getAlt: getAlt,
        setAlt: setAlt,

        getTitle: getTitle,
        setTitle: setTitle,

        getAlignment: getAlignment,
        setAlignment: setAlignment,

        getCaption: getCaption,
        setCaption: setCaption,

        getFrame: getFrame,
        setFrame: setFrame,

        extendedBeyondResponsiveness: extendedBeyondResponsiveness,
        hasLink: hasLink,
        getLink: getLink,
        setLink: setLink,
        getSrc: getSrc,
        clearInlineStyles: clearInlineStyles,
        setMaxWidth: setMaxWidth,
        updateComplexImageSize: updateComplexImageSize,
        isAttachedToBody: isAttachedToBody
    });
};
