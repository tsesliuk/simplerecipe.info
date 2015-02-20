<?php 
	$update_fields=array("active","content","width","height","appear_after","cookie_lifetime","wrap_background","box_background","border_radius","close_button","background_clicked","enable_responsive","schedule","start","end","sitewide","enable_cookies","content_image","image_url","source_code","content_type");	
    if($_POST['em_hidden'] == 'Y') {
        //Form data sent
		for($i=0;$i<count($update_fields);$i++){
			update_option('em_'.$update_fields[$i], $_POST["em_".$update_fields[$i]]);
		}
		
        ?>
        <div class="updated"><p><strong><?php _e('Elegance Modal Box settings have been updated.' ); ?> <a href="?page=elegance-modal">Go Back</a></strong></p></div>
        <?php
    }else{
		for($i=0;$i<count($update_fields);$i++){
			$val=get_option("em_".$update_fields[$i]);
			$$update_fields[$i]=stripslashes($val);
			//echo $update_fields[$i]." - $val <br />";
		}
		
		$defaults=array(
			"content"=>"Elegance Content Goes here. Checkout our new portfolio at <a href='http://e-legance.net'>E-legance.net</a>",
			"content_type"=>"editor",
			"width"=>"500",
			"Height"=>"500",
			"appear_after"=>"0",
			"cookie_lifetime"=>"1",
			"wrap_background"=>"#000",
			"box_background"=>"#fff",
			"close_button"=>"1",
			"border_radius"=>"10",
			"enable_responsive"=>1,
			"background_clicked"=>"1",
			"sitewide"=>"1",
			"enable_cookies"=>"1"
		);
		
		if($width==''){
			for($i=0;$i<count($update_fields);$i++){
				$$update_fields[$i]=$defaults[$update_fields[$i]];
			}
		}
		
	
			
		
	?>
    
    
<div class="wrap">
    <?php    echo "<h1>" . __( 'Elegance Modal Settings', 'elegance_modal_text' ) . "</h1>"; ?>
    <p>Elegance Modal WordPress plugin version 1.0. In this version you can have only 1 plugin per site. Be looking forward to our next release with more features on <a href="http://e-legance.net/wordpress/">E-legance.net</a></p>
     <hr />
    
    <a href="http://e-legance.net/?ref=wpb&site=<?=$_SERVER['HTTP_HOST']?>" style="width:100%; display:block;">
    <img src="<?=plugins_url('assets/banner.png', __FILE__ )?>" style="max-width:100%;" alt="E-legance.net" border="0" />
    </a>
    
    <form name="em_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        
        <input type="hidden" name="em_hidden" value="Y">
        
        
        
		<?php    echo "<h2>" . __( 'Appearance settings', 'elegance_modal_text' ) . "</h2>"; ?>
        
        <table class="form-table">

		
		
        <tr>
            <th>
            <label>
            <?php _e("Activate Elegance Modal" ); ?>
            </label>
            </th>
            <td>
            <input type="checkbox" name="em_active" value="1" <?php checked( 1 == $active); ?>  />  The modal box starts showing when this checkbox is clicked. 
            </td>
        </tr>
        
        
        <tr>
            <th>
            <label>
            <?php _e("Appear site-wide" ); ?>
            </label>
            </th>
            <td>
            <input type="checkbox" name="em_sitewide" value="1" <?php checked( 1 == $sitewide); ?>  />  If not checked you should use shortcode <strong>[elegance-modal-box]</strong> on the pages that you want to have Elegance modal box.
            </td>
        </tr>
        
        <tr>
        <th>
        
        <label><?php _e("Appear after: " ); ?></label>
        </th>
        <td>
        <input type="text" name="em_appear_after" value="<?php echo $appear_after; ?>" /> seconds. <p>if 0 the box appears immediately.</p>
        </td>
        
        </tr>
        </table>
        
        <hr />
        
        
		<?php    echo "<h2>" . __( 'Scheduling settings', 'elegance_modal_text' ) . "</h2>"; ?>
       
       
        <table class="form-table">
        
		
        <tr>
            <th>
            <label>
            <?php _e("Schedule showing" ); ?>
            </label>
            </th>
            <td>
            <input type="checkbox" name="em_schedule" value="1" <?php checked( 1 == $schedule); ?>  />  When checked the modal box will appear only between the dates below
            </td>
        </tr>
            <tr>
                <th>
                <label>
                <?php _e("Start showing:" ); ?>
                </label>
                </th>
                <td>    
                <input type="text" class="date-field" name="em_start" value="<?=$start?>"/>
                </td>
            </tr>
            <tr>
                <th>
                <label>
                <?php _e("End showing:" ); ?>
                </label>
                </th>
                <td>    
                <input type="text" class="date-field" name="em_end" value="<?=$end?>"/>
                </td>
            </tr>
        </table>
        
        <hr />
        
		<?php    echo "<h2>" . __( 'Wrapper settings', 'elegance_modal_text' ) . "</h2>"; ?>
        
        <table class="form-table">
            <tr>
                <th>            
                <label><?php _e("Wrap background color: " ); ?></label>
                </th>
                <td>
                <input type="text" name="em_wrap_background" value="<?=$wrap_background?>" class="color-field" />
                </td>
            </tr>
        </table>
        
        
        <hr />
        
        
		<?php    echo "<h2>" . __( 'Closing settings', 'elegance_modal_text' ) . "</h2>"; ?>
        
        
        <table class="form-table">
            <tr>
                <th>
                <label>
				<?php _e("Enable close button" ); ?>
                </label>
                </th>
                <td>
                <input type="checkbox" name="em_close_button" value="1" <?php checked( 1 == $close_button ); ?> /> 
                </td>
            </tr>
		
		
            <tr>
                <th>
                <label>
                <?php _e("Close when background is clicked" ); ?>
                </label>
                </th>
                <td>
		        <input type="checkbox" name="em_background_clicked" value="1" <?php checked( 1 == $background_clicked ); ?>  />  
                </td>
            </tr>
		
        
            <tr>
                <th>
                <label>
				<?php _e("Enable cookies for closing" ); ?>
                </label>
                </th>
                <td>
                <input type="checkbox" name="em_enable_cookies" value="1" <?php checked( 1 == $enable_cookies ); ?>  />  
                </td>
            </tr>
		
        
            <tr>
                <th>
                <label>
				<?php _e("Cookie lifetime: " ); ?>
                </label>
                </th>
                <td>
      			  <input type="text" name="em_cookie_lifetime" value="<?php echo $cookie_lifetime; ?>" /> Days
                </td>
            </tr>
        
        </table>
        <hr />
		<?php    echo "<h2>" . __( 'Box settings', 'elegance_modal_text' ) . "</h2>"; ?>
        
        
        
        
        <table class="form-table">
        
            <tr>
                <th>            
                <label><?php _e("Box background color: " ); ?></label>
                </th>
                <td>
                <input type="text" name="em_box_background" value="<?=$box_background?>" class="color-field" />
                </td>
            </tr>
            <tr>
                <th>
                <label>
				<?php _e("Modal box border radius: " ); ?>
                </label>
                </th>
                <td>
 		       <input type="text" name="em_border_radius" value="<?php echo $border_radius; ?>" /> px.
        		</td>
           </tr>
            <tr>
                <th>
                <label>
				<?php _e("Modal box width: " ); ?>
        		</label>
                </th>
                <td>
       			 <input type="text" name="em_width" value="<?php echo $width; ?>" /> px.
        		</td>
            </tr>
            <tr>
                <th>
                <label>
				<?php _e("Modal box height: " ); ?>
                </label>
                </th>
                <td>
 		       <input type="text" name="em_height" value="<?php echo $height; ?>" /> px.
        		</td>
           </tr>
           
           
            <tr>
                <th>
                <label>
				<?php _e("Enable responsive version" ); ?>
                </label>
                </th>
                <td>
                <input type="checkbox" name="em_enable_responsive" value="1" <?php checked( 1 == $enable_responsive ); ?>  />  
                </td>
            </tr>
		
           
            <tr>
                <th>
                <input type="radio" name="em_content_type" value="editor" id="type_editor" <? if($content_type=="editor") echo 'checked="checked"'; ?> />
                <label for="type_editor">
				<?php _e("Modal box content: " ); ?><br />
                <p>You can insert and format text, media even shorcodes.</p>
                </label>
                </th>
                <td>
                 <?php wp_editor( $content, "em_content"); ?> 

        		</td>
           </tr>
           
           
           
           
        
            <tr valign="top">
                
                <th>
                <input type="radio" name="em_content_type" value="image" id="type_image"  <? if($content_type=="image") echo 'checked="checked"'; ?> />
				<label for="type_image">Image banner</label>
                </th>
                
                <td><label for="upload_image">
                    <input id="upload_image" type="text" size="36" name="em_content_image" value="<?php echo $content_image; ?>" />
                    <input id="upload_image_button" type="button" value="Upload Image" />
                    <br />Enter an URL or upload an image for the banner.
                    </label>
                    <br /><br />
                    <label>Banner link:</label><br />
 		       		<input type="text" placeholder="http://" name="em_image_url" value="<?php echo $image_url; ?>" />
                </td> 
            </tr>
            
            
            <tr>
                <th>
                <input type="radio" name="em_content_type" value="source" id="type_source"  <? if($content_type=="source") echo 'checked="checked"'; ?> />
                <label for="type_source">
				<?php _e("Source code: " ); ?><br />
                <p>You can insert html, css, js, youtube/vimeo embed code, facebook likebox end more.</p>
                </label>
                </th>
                <td>
                
                <textarea name="em_source_code" rows="5" cols="55"><?=stripslashes($source_code)?></textarea> 

        		</td>
           </tr>
           
           </table>
   
     
        <p class="submit">
        
        <input type="submit" class="button" name="Submit" value="<?php _e('Save Elegance Modal Settings', 'elegance_modal_text' ) ?>" />
        
        </p>
    </form>
    <hr />
    
    
    
    <a href="http://e-legance.net/?ref=wpb&site=<?=$_SERVER['HTTP_HOST']?>" style="width:100%; display:block;">
    <img src="<?=plugins_url('assets/banner.png', __FILE__ )?>" style="max-width:100%;" alt="E-legance.net" border="0" />
    </a>
    
    <p>
    
    <p>Elegance Modal Wordpress Plugin. Developed by <a href="http://e-legance.net">E-legance Team</a>. Any questions for support and future developments can be forwarded to wordpress@e-legance.net</p>
    </p>
</div>

<?
	}
?>