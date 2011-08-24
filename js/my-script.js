jQuery(document).ready(function() {

jQuery('.upload_image_button').click(function() {
 formfield = jQuery(this).attr('name');
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});

window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 //jQuery('#upload_image').val(imgurl);
 //alert(formfield);
 tb_remove();
 
 $.post(ajaxurl,{action: 'change_imgset',imgurl:imgurl, where: formfield },function(info){
		//alert(info);
		//$('#imglist_'+dest).html(''+info);
	});	
}

});
