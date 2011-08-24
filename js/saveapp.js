function creaApplicazione(app_id, istemplate, img)
{
	var nome_app = $('[name=nome_app]').val();
	var descr_app = $('[name=descr_app]').val();
	var header_bgcolor = $('[name=header_bgcolor]').val();
	var header_alpha = $('#header_alpha').slider('value');
	var header2_bgcolor = $('[name=header2_bgcolor]').val();
	var header2_alpha = $('#header2_alpha').slider('value');
	var header_style = $('[name=header_style]').val();
	var header_weight = $('[name=header_weight]').val();
	var header_size = $('[name=header_size]').val();
	var header_family = $('[name=header_family]').val();
	var header_title_color = $('[name=header_title_color]').val();
	var header_title_alpha = $('#header_title_alpha').slider('value');
	var bg_color = $('[name=bg_color]').val();
	var bg_alpha = $('#bg_alpha').slider('value');
	var bg2_color = $('[name=bg2_color]').val();
	var bg2_alpha = $('#bg2_alpha').slider('value');
	//var footer_bgcolor = $('[name=footer_bgcolor]').val();
	//var footer_alpha = $('#footer_alpha').slider('value');
	var cat_title_style = $('[name=cat_title_style]').val();
	var cat_title_weight = $('[name=cat_title_weight]').val();
	var cat_title_size = $('[name=cat_title_size]').val();
	var cat_title_family = $('[name=cat_title_family]').val();
	var cat_title_color = $('[name=cat_title_color]').val();
	var cat_title_alpha = $('#cat_title_alpha').slider('value');
	var cat_desc_style = $('[name=cat_desc_style]').val();
	var cat_desc_weight = $('[name=cat_desc_weight]').val();
	var cat_desc_size = $('[name=cat_desc_size]').val();
	var cat_desc_family = $('[name=cat_desc_family]').val();
	var cat_desc_color = $('[name=cat_desc_color]').val();
	var cat_desc_alpha = $('#cat_desc_alpha').slider('value');
	var feed_title_style = $('[name=feed_title_style]').val();
	var feed_title_weight = $('[name=feed_title_weight]').val();
	var feed_title_size = $('[name=feed_title_size]').val();
	var feed_title_family = $('[name=feed_title_family]').val();
	var feed_title_color = $('[name=feed_title_color]').val();
	var feed_title_alpha = $('#feed_title_alpha').slider('value');
	var feed_desc_style = $('[name=feed_desc_style]').val();
	var feed_desc_weight = $('[name=feed_desc_weight]').val();
	var feed_desc_size = $('[name=feed_desc_size]').val();
	var feed_desc_family = $('[name=feed_desc_family]').val();
	var feed_desc_color = $('[name=feed_desc_color]').val();
	var feed_desc_alpha = $('#feed_desc_alpha').slider('value');
	var layout = $('[name=layout]').val();
	
	var header_bgimg = $('[name=header_bgimg]').val();
	var header2_bgimg = $('[name=header2_bgimg]').val();
	var bg_img = $('[name=bg_img]').val();
	var bg2_img = $('[name=bg2_img]').val();
	var footer_prev_img = $('[name=footer_prev_img]').val();
	var footer_next_img = $('[name=footer_next_img]').val();
	var footer_share_img = $('[name=footer_share_img]').val();
	var template = $('[name=template]').val();
	
	var keywords = $('[name=keywords]').val();
	var email_support = $('[name=email_support]').val();
	var url_support = $('[name=url_support]').val();
	

	if (nome_app == '')
		alert('Inserire un nome per l\'applicazione!');
	else
	

	
		$.post(ajaxurl,{ action: 'save_app', app_id: app_id,
																	nome_app: nome_app, 
																	descr_app: descr_app, 
																	header_bgcolor: header_bgcolor, 
																	header_alpha: header_alpha, 
																	header2_bgcolor: header2_bgcolor, 
																	header2_alpha: header2_alpha, 
																	header_style: header_style, 
																	header_weight: header_weight, 
																	header_size: header_size, 
																	header_family: header_family, 
																	header_title_color: header_title_color, 
																	header_title_alpha: header_title_alpha, 
																	bg_color: bg_color, 
																	bg_alpha: bg_alpha, 
																	bg2_color: bg2_color, 
																	bg2_alpha: bg2_alpha, 
																	//footer_bgcolor: footer_bgcolor, 
																	//footer_alpha: footer_alpha, 
																	cat_title_style: cat_title_style, 
																	cat_title_weight: cat_title_weight, 
																	cat_title_size: cat_title_size, 
																	cat_title_family: cat_title_family, 
																	cat_title_color: cat_title_color, 
																	cat_title_alpha: cat_title_alpha, 
																	cat_desc_style: cat_desc_style, 
																	cat_desc_weight: cat_desc_weight, 
																	cat_desc_size: cat_desc_size, 
																	cat_desc_family: cat_desc_family, 
																	cat_desc_color: cat_desc_color, 
																	cat_desc_alpha: cat_desc_alpha, 
																	feed_title_style: feed_title_style, 
																	feed_title_weight: feed_title_weight, 
																	feed_title_size: feed_title_size, 
																	feed_title_family: feed_title_family, 
																	feed_title_color: feed_title_color, 
																	feed_title_alpha: feed_title_alpha, 
																	feed_desc_style: feed_desc_style, 
																	feed_desc_weight: feed_desc_weight, 
																	feed_desc_size: feed_desc_size, 
																	feed_desc_family: feed_desc_family, 
																	feed_desc_color: feed_desc_color, 
																	feed_desc_alpha: feed_desc_alpha, 
																	layout: layout,
																	
																	header_bgimg: header_bgimg,
																	header2_bgimg: header2_bgimg,
																	bg_img: bg_img,
																	bg2_img: bg2_img,
																	footer_prev_img: footer_prev_img,
																	footer_next_img: footer_next_img,
																	footer_share_img: footer_share_img,
																	template: template,
																	
																	keywords: keywords,
																	email_support: email_support,
																	url_support: url_support
																	
																	},function(info){
			
			//alert(info);
			$('#appframe').attr("src",$("#appframe").attr("src"));

		/*
			if(istemplate != 'template')
			{
				alert('Applicazione creata con successo');
				window.location = '<?=site_url('apps')?>';
			}
			else
			{
				if(img != '')
				$.post('<?php echo site_url('apps/changeTemplate');?>/'+app_id,{ img: img},function(info){
					//alert(info);
					window.location = "<?php echo site_url('apps/nuovo');?>/"+app_id;
				});	
				else
 					$('#appframe').attr("src",$("#appframe").attr("src"));

			}
			*/
	});


}