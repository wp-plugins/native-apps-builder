jQuery(document).ready(function() {

	var isplugin = false;
	
	jQuery('.upload_image_button').click(function() {
	 formfield = jQuery(this).attr('name');
	 isplugin = true;
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 return false;
	});
	
	window.original_send_to_editor = window.send_to_editor;
	
	window.send_to_editor = function(html) {
		if (isplugin)
		{
		 imgurl = jQuery('img',html).attr('src');
		 //jQuery('#upload_image').val(imgurl);
		 //alert(formfield);
		 tb_remove();
		 
		 $.post(ajaxurl,{action: 'change_imgset',imgurl:imgurl, where: formfield },function(info){
				//alert(info);
				//$('#imglist_'+dest).html(''+info);
			});	
		}
		else
			window.original_send_to_editor(html);
	
	
	}

});
