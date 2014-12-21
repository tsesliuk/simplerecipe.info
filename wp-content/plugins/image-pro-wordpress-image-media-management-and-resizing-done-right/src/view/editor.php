<div id="impro-preview"></div>
<div id="impro_editor">

    <div class="impro-control-group">
        <label><?php _e('Image size preset', 'imagepro') ?></label>
        <select id="impro-editor-size">
            <optgroup label="Wordpress defined">
                <option value="__full"><?php _e('Full size', 'imagepro') ?></option>
                <?php
                $thumbnailSizes = @self::list_thumbnail_sizes();
                foreach($thumbnailSizes as $name => $attrs):
                    ?><option value="<?php echo addslashes($name) ?>" data-preset-width="<?php echo $attrs[0]?>" data-preset-height="<?php echo $attrs[1]?>"><?php echo ucfirst(htmlentities($name)) ?> (<?php echo $attrs[0]?>x<?php echo $attrs[1]?>)</option><?php
                endforeach;
                ?>
            </optgroup>
            <optgroup label="User defined">
                <option value="__custom" selected="selected"><?php _e('Custom size', 'imagepro') ?></option>
            </optgroup>
        </select>
    </div>

    <div class="impro-control-group">
        <label><?php _e('Manually change image size', 'imagepro') ?></label><br/>
        <input id="impro-editor-w" type="number" />
        <?php _e('width', 'imagepro') ?> x
        <input id="impro-editor-h" type="number" />
        <?php _e('height', 'imagepro') ?>
    </div>

    <div id="impro-editor-maxwidth-container">
        <label><input id="impro-editor-maxwidth" type="checkbox" /> <?php _e('Override size restriction', 'imagepro') ?></label><span id="impro-editor-maxwidth-help" class="impro-help">?</span>
        <br/>
        <div id="impro-editor-maxwidth-info">
<?php _e('The current WordPress theme allows images up to %maxwidth% pixels in width.<br/> Use the option above to disable this restriction for the current image. However, the image will not be responsive anymore.', 'imagepro') ?>
        </div>
    </div>

    <hr/>

    <div style="margin-top: 14px;">
        <span style="float: left;"><?php _e('Align:', 'imagepro')?></span>

        <ul id="impro-align">
            <li data-align="alignnone" class="impro-icon-align-none"><span><?php _e('None', 'imagepro')?></span></li>
            <li data-align="alignleft" class="impro-icon-align-left"></li>
            <li data-align="aligncenter" class="impro-icon-align-center"></li>
            <li data-align="alignright" class="impro-icon-align-right"></li>
        </ul>
    </div>

    <div style="clear: both;"></div>

    <hr/>

    <label><input type="checkbox" class="impro_link" />
        <?php _e('Open the full picture on click', 'imagepro')?>
    </label>

    <div style="clear: both;"></div>

    <label style="display: block; margin-top: 12px;"><?php _e('Caption', 'imagepro')?> <input type="text" id="impro-cpt" /></label>

    <ul id="impro-frm">
        <li data-value="none"><span><small></small></span></li>
        <li data-value="imagepro-radius"><span><small></small></span></li>
        <li data-value="imagepro-polaroid"><span><small></small></span></li>
        <li data-value="imagepro-round"><span><small></small></span></li>
    </ul>

    <div style="clear:both;"></div>

    <hr/>
    <a href="#" onclick="jQuery(this).hide(); jQuery('#impro-more-options').show(500); return false;"><?php _e('More options ...', 'imagepro')?></a>

    <div id="impro-more-options" style="margin-bottom: -8px; display: none;">
        <label><?php _e('Alternative text:', 'imagepro')?>
            <input type="text" class="impro_alt" />
        </label>

        <label><?php _e('Title text:', 'imagepro')?>
            <input type="text" class="impro_title" />
        </label>
    </div>

<div class="clear"></div>
</div>