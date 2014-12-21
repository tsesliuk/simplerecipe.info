<div id="vimg-progress-wrapper" style="display: none;">
	<div id="vimg-progress"></div>
</div>

<div id="vimg-toolset">
    <div>
        <a data-action="remove" id="vimg-toolset-delete">&ndash;</a>

        <a data-action="add" id="vimg-toolset-add"><?php _e('Add to post', 'imagepro') ?></a>
        <a data-action="library" id="vimg-toolset-edit"><?php _e('Edit', 'imagepro') ?></a>
        <a data-action="open" id="vimg-toolset-open"><?php _e('Open', 'imagepro') ?></a>
        <a data-action="link" id="vimg-toolset-link"><?php _e('Get link', 'imagepro') ?></a>
    </div>
</div>

<div id="vimg-toolbar-filter" style="display: none;">
	<label for="vimg-filetype"><?php _e('Show', 'imagepro')?>&nbsp;</label>
	<select id="vimg-filetype">
		<option value="" style="font-weight: bold;"><?php _e('All files', 'imagepro')?></option>
		<option value="image"><?php _e('Pictures', 'imagepro')?></option>
		<option value="video"><?php _e('Videos', 'imagepro')?></option>
		<option value="application/x-shockwave-flash"><?php _e('Flash SWF', 'imagepro')?></option>
		<option value="application/pdf"><?php _e('PDF Documents', 'imagepro')?></option>
	</select>
	
	<label for="vimg-search">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Search', 'imagepro')?></label>
	<input type="text" id="vimg-search" />

    <a id="vimg-dbg" href="#">DBG</a>
</div>

<div class="clear"></div>

<div id="vimg-dbg-content">
    <?php _e('Copy &amp; paste the contents of the textarea below when submitting a support request at <a target="_blank" href="http://www.mihaivalentin.com/about-me/#contact">http://www.mihaivalentin.com/about-me/#contact</a><br/>The information will be used only for troubleshooting purposes and may reveal some information about your WordPress setup.', 'imagepro') ?>
    <textarea style="width: 100%; height: 500px;">

    </textarea>
    <a href="#" onclick="jQuery('#vimg-dbg-content').hide();return false;">Close DBG</a>
    <br/><br/>
</div>

<div id="vimg-list">
	<ul>
	
	</ul>
</div>

<div style="clear:both;"></div>