<?php 
    /*
    Plugin Name: Elegance Modal Box
    Plugin URI: http://e-legance.net/
    Description: This plugin allows you to create modal boxes that shows on certain event - click on link, load a page or whatever. Each box could contain prefedined content or can be shown just once.
    Author: Dragomir Ivanov
    Version: 1.2.0
    Author URI: http://e-legance.net/
    */
	
	/*
	ADMIN SETUPS
	*/
	function elegance_modal_admin() {
    	include('elegance-modal-admin.php');
	}
		
	function elegance_modal_admin_actions() {
		add_menu_page("Elegance Modal", "Elegance Modal", 1, "elegance-modal", "elegance_modal_admin",'');
	}
	 
	add_action('admin_menu', 'elegance_modal_admin_actions');
	
	
	function em_admin_scripts( $hook_suffix ) {
		//Modal Box Upload
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');

		//Datapicker
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script( 'timepicker', plugins_url('js/jquery.timepicker.js', __FILE__ ), array( 'jquery-ui-datepicker' ), false, true );
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		
		//Colorpicker
		wp_enqueue_style( 'wp-color-picker' );
		
		//Elegance Modal
		wp_enqueue_style( 'elegance-modal-admin', plugins_url( '/css/elegance-modal-admin.css', __FILE__ ));
		wp_enqueue_script( 'elegance-modal-script-handle', plugins_url('js/elegance-modal-admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
	}
	
	
	add_action( 'admin_enqueue_scripts', 'em_admin_scripts' );
	
	
	/*
	FRONT-END SETUPS
	*/
	
	add_action( 'get_footer', 'show_elegance_modal' );

	function make_elegance_modal($from_short_code=0) {
		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );	
		$elegance_fields=array("content","background_clicked","close_button","active","sitewide","schedule","start","end","content_type");	
		$data_fields=array("width","height","appear_after","cookie_lifetime","wrap_background","box_background","border_radius","background_clicked","appear_after","enable_cookies","enable_responsive");	
		
		for($i=0;$i<count($elegance_fields);$i++){
			$val=get_option("em_".$elegance_fields[$i]);
			$$elegance_fields[$i]=stripslashes($val);
		}
		
		
		if($active!=1 || ($sitewide!=1 && $from_short_code==0)){
			return;
		}
		
		$now=date("Y-m-d H:m:s",time());
		if($schedule==1 && ($start>$now || $end<$now)){
			return;
		}
		
		$data_str="";
		for($i=0;$i<count($data_fields);$i++){
			$val=get_option("em_".$data_fields[$i]);
			$data_str.=' data-'.$data_fields[$i].'="'.$val.'" ';
		}
		
		
		if($close_button==1){
			$close_button="<span id=\"elegance-modal-close\">X</span>";
		}else{
			$close_button="";
		}
		
		if($content_type=="editor"){;
			$box_content=do_shortcode(stripslashes($content));
		}elseif($content_type=="image"){
			$image=get_option("em_content_image");
			$link=get_option("em_image_url");
			$image="<img src=\"".$image."\" alt=\"\" />";
			
			if($link!=''){
				$box_content='<a href="'.$link.'">'.$image.'</a>';
			}else{
				$box_content=$image;
			}
			
		}elseif($content_type=="source"){;
			$box_content=get_option("em_source_code");
		}
		
		
		$content_html="
		<div id=\"elegance-modal-wrap\" style=\"display:none;\"></div>
		<div id=\"elegance-modal\" class=\"elegance-responsive\" style=\"display:none;\" ".$data_str.">
			<div id=\"elegance-modal-box\">
			$close_button
			<div class=\"elegance-modal-content\">
			".stripslashes($box_content)." 
			</div>
			</div>
		</div>
		";
		return $content_html;
	}


	
	function show_elegance_modal() {
		echo make_elegance_modal();
	}
	
	
	function show_elegance_modal_shortcode(){
		elegance_modal_scripts(1);
		return make_elegance_modal(1);
	}
	
	//[elegance-modal-box]
	add_shortcode( 'elegance-modal-box', 'show_elegance_modal_shortcode' );

	
	function elegance_modal_scripts($from_shrotcode=0) {
		if(get_option("em_active")!=1 || (get_option("em_sitewide")!=1 && $from_shrotcode==0)){
			return;
		}
		wp_enqueue_style( 'elegance-modal-style', plugins_url( '/css/elegance-modal.css', __FILE__ ));
		wp_enqueue_script( 'jquery-cookie', plugins_url( '/js/jquery-cookie.js', __FILE__ ) , array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'elegance-modal-script', plugins_url( '/js/elegance-modal.js', __FILE__ ) , array('jquery'), '1.0.0', true );
	}

	add_action( 'wp_enqueue_scripts', 'elegance_modal_scripts' );

?>