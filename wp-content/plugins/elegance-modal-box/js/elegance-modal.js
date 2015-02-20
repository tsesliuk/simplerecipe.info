jQuery(document).ready(function($){
	if(document.getElementById("elegance-modal")){
	
	
	console.log("elegance modal js");
	var centerEleganceModal = function(){
		var em=$("#elegance-modal");
		ch=em.data('height');
		cw=em.data('width');
		resp=em.data('enable_responsive');
		
		//check for responsive
		if(resp==1){
			bw=$("body").width();
			bh=$("body").height();
			if(cw>bw){
				cw=bw-40;
			}
			if(ch>bh){
				ch=bh-40;
			}
		}
		
		if(ch!=''){
			em.height(ch);
		}
		
		if(cw!=''){
			em.width(cw);
		}
		
		
		
		var h=$("#elegance-modal").height();
		var w=$("#elegance-modal").width();
		
		em.css("margin-left",(0-(w/2)));
		em.css("margin-top",(0-(h/2)));
		
		
		//set backgrounds
		$("#elegance-modal-box").css('background-color',em.data('box_background'));
		$("#elegance-modal-wrap").css('background-color',em.data('wrap_background'));
		$("#elegance-modal-box").css('border-radius',em.data('border_radius'));
	}
	
	
	$(window).resize(function(){
		centerEleganceModal();
	});
	
	var ShowEleganceModal = function(){
		
		centerEleganceModal();
		$("#elegance-modal-wrap").slideDown("fast");
		$("#elegance-modal").fadeIn("slow");
	}
	
	
	var CloseEleganceModal = function(){
		$("#elegance-modal-wrap").fadeOut();
		$("#elegance-modal").fadeOut();
		
		var enable_cookies=$('#elegance-modal').data('enable_cookies');
		if(enable_cookies==1){
			expire=$("#elegance-modal").data("cookie_lifetime")
			$.cookie("elegance-closed", "true", { expires: expire });
		}
	}
	
		
	
	$("#elegance-modal-close").click(function(){
		CloseEleganceModal();
	});
	
	$("#elegance-modal-wrap").click(function(){	
		if($("#elegance-modal").data("background_clicked")==1){	
			CloseEleganceModal();
		}
	});
		
	var eleganceClosed=$.cookie("elegance-closed");
	var enable_cookies=$('#elegance-modal').data('enable_cookies');
	
	if(eleganceClosed=='true' && enable_cookies==1){
		$('#elegance-modal-wrap').hide();
		$('#elegance-modal').hide();
	}else{
		show_after=$('#elegance-modal').data('appear_after');
		setTimeout(function(){ShowEleganceModal()},(show_after*1000));
	}
	
	
	
	}
});