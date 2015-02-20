jQuery(document).ready(function($){
    $('.color-field').wpColorPicker();
	$('.date-field').datetimepicker({timeFormat: 'HH:mm:ss',dateFormat: 'yy-mm-dd'});
	
	$('#upload_image_button').click(function() {
		
		formfield = $('#upload_image').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	
	});
	
	window.send_to_editor = function(html) {
		
		imgurl = $('img',html).attr('src');
		$('#upload_image').val(imgurl);
		tb_remove();
		
	}

	

});