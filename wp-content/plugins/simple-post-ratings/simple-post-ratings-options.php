<?php if(isset($_POST['ds_ratings_submit'])){

	if(strlen($_FILES['rating_img']['name'])){
		$allowed_ext = array('jpg','jpeg','png','gif');
		$ds_image = $_FILES['rating_img'];
		if($ds_image != $this->files['custom_img_slug']){
			if(file_exists($this->upload_dir . $this->options['custom_img_slug']) && $this->options['custom_img_slug'] != 'ds_star.png'){
				unlink($this->upload_dir . $this->options['custom_img_slug']);
			}
		}
		if(!in_array($this->get_extension($ds_image['name']),$allowed_ext)){
			echo "Only jpg, jpeg, png and gif images are allowed";
		}

		if(!move_uploaded_file($ds_image['tmp_name'], $this->upload_dir . $ds_image['name'])){
			echo "Could not upload the image";
		}
		$custom_img_slug = $ds_image['name'];
	}

	if(isset($_POST['reset_img'])){
		if(file_exists($this->upload_dir . $this->options['custom_img_slug']) && $this->options['custom_img_slug'] != 'ds_star.png'){
			unlink($this->upload_dir . $this->options['custom_img_slug']);
		}
		$custom_img_slug = 'ds_star.png';
	}
	if(!is_string($custom_img_slug)){
		$custom_img_slug = $this->options['custom_img_slug'];
	}

	update_option('ds_rating_options', array(
			'max_score' => $this->ds_clean_string($_POST['max_score']),
			'before_rating' => $this->ds_clean_string($_POST['ds_text_before']),
			'after_rating' => $this->ds_clean_string($_POST['ds_text_after']),
			'custom_img_slug' => $custom_img_slug,
			'align' => $_POST['rating_align'],
			'rating_numbers' => $_POST['rating_numbers'],
			'position' => $_POST['rating_position']
			));
	$this->options = get_option('ds_rating_options');
	//print_r($this->options);
} ?>
<style>
	.ds_col_right input, select {
		margin-bottom: 10px
	}
	.ds_col_right #ds_ratings_submit {
		margin-left: 210px;
	}
	.ds_col_left{
		float: left;
		margin-right: 25px;
		padding-top: 5px;
	}
	.ds_col_left label {
		display: block;
		margin-bottom: 3px;
		text-align: right;
	}
	.ds_col_right .ds_text_field {
		width: 245px;
	}
	.ds_col_right p {
		margin-top: -1px;
		margin-bottom: 6px;
	}
	.ds_col_right #rating_numbers {
		margin-top: 9px;
	}
	.ds_col_right #max_score {
		margin-top: 4px;
	}
	.ds_col_left p {
		margin-top: -9px;
	}
	.ds_rating_wrap {
        margin-bottom: 10px;
    }
    .rating_numbers {
      <?php if($this->options['rating_numbers'] == 'on'){
        echo "display: inline;";
        }else{
          echo "display: none;";
          } ?>
    }
            .ds_rating_img img {
              vertical-align: middle;
              margin-top: -8px;
            }
</style>
<div class="wrap">
   	<form action="" method="post" enctype="multipart/form-data">
        <h2>Simple Post Ratings Options</h2><br />
       	<div class="ds_col_left">
       		<label for="ds_text_before">Text before rating</label><br />
       		<label for="ds_text_after">Text after rating</label><br />
       		<label for="rating_numbers">Display rating in numbers</label><br />
       		<label for="max_score">Max. Score</label><br />
       		<label for="rating_align">Alignment</label><br />
       		<label for="rating_position">Position</label><br />
       		<label for="rating_img">Upload Custom Rating Image</label><br />
       		<p>&nbsp</p>
       		<label for="reset_img">Reset to default image</label><br />
       	</div>
       	<div class="ds_col_right">
       		<input type="text" class="ds_text_field" name="ds_text_before" value="<?php echo $this->options['before_rating']; ?>" /><br />
       		<input type="text" class="ds_text_field" name="ds_text_after" value="<?php echo $this->options['after_rating']; ?>" /><br />
       		<input type="checkbox" name="rating_numbers" id="rating_numbers" <?php if($this->options['rating_numbers'] == 'on') { echo "checked"; }?> /><br />
       		<select id="max_score" name="max_score" id="max_score">
       		<option value="5" <?php if($this->options['max_score'] == 5){echo "selected";} ?>>5</option>
        	<option value="10" <?php if($this->options['max_score'] == 10){echo "selected";} ?>>10</option>
        </select><br />
        <select name="rating_align">
        	<option value="left" <?php if($this->options['align'] == 'left'){echo "selected";} ?> >Left</option>
        	<option value="center" <?php if($this->options['align'] == 'center'){echo "selected";} ?> >Center</option>
        	<option value="right" <?php if($this->options['align'] == 'right'){echo "selected";} ?> >Right</option>
        </select><br />
        <select name="rating_position">
        	<option value="top" <?php if($this->options['position'] == 'top'){echo "selected";} ?> >Top</option>
        	<option value="bottom" <?php if($this->options['position'] == 'bottom'){echo "selected";} ?> >Bottom</option>
        </select><br />
        <input type="file" name="rating_img" /><br />
        <p><i>For the best results upload image no bigger than 64px by 64px</i></p>
        <input type="checkbox" name="reset_img" /><br />
        <input type="submit" id="ds_ratings_submit" name="ds_ratings_submit" value="Save" />
       	</div>
        </form>
        	<h3><b>My rating preview</b></h3>
        	 <div class="ds_rating_wrap">
	            <span><?php echo $this->options['before_rating']; ?></span>
	            <span class="ds_rating_img">
	              <?php for ($i=0; $i < 5; $i++) {
	                echo '<img src="' . plugins_url() . '/simple-post-ratings/' . $this->options['custom_img_slug'] . '" width="24" height="24" />';
	              } ?>
	            </span>
	            <span class="rating_numbers" ><?php echo '5/' . $this->options['max_score']; ?></span>
	            <span><?php echo $this->options['after_rating']; ?></span>
	          </div>
    	<br />
    	<h3><b>If you enjoy Simple Post Ratings plugin, please support it</b></h3>
    	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="eriks.briedis@gmail.com">
			<input type="hidden" name="lc" value="US">
			<input type="hidden" name="item_name" value="Eriks Briedis">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>


   </div>