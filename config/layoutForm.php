<?

include_once('graphics_function.php');

$style = $appsbuilder->getStyle($id_app, 'all_styles');
if(isset($style))   
	$style = json_decode($style);
?>

<script type="text/javascript">

$(function() {
	$("#graphics").tabs();
});

$(function() {
	$( "#header_alpha" ).slider({ value: 100 });
	<? if(isset($style->header_alpha)) { echo '$( "#header_alpha" ).slider("value", "'.$style->header_alpha .'" ); '; }?>
	
	$( "#header2_alpha" ).slider({ value: 100 });
	<? if(isset($style->header2_alpha)) { echo '$( "#header2_alpha" ).slider("value", "'.$style->header2_alpha .'" ); '; }?>
	
	$( "#header_title_alpha" ).slider({ value: 100 });
	<? if(isset($style->header_title_alpha)){ echo '$( "#header_title_alpha" ).slider("value","'.$style->header_title_alpha .'");'; }?>
	
	$( "#bg_alpha" ).slider({ value: 100 });
	<? if(isset($style->bg_alpha)) { echo '$( "#bg_alpha" ).slider("value", "'.$style->bg_alpha .'" ); '; }?>
	$( "#bg2_alpha" ).slider({ value: 100 });
	<? if(isset($style->bg2_alpha)) { echo '$( "#bg2_alpha" ).slider("value", "'.$style->bg2_alpha .'" ); '; }?>
	$( "#cat_title_alpha" ).slider({ value: 100 });
	<? if(isset($style->cat_title_alpha)) { echo '$( "#cat_title_alpha" ).slider("value", "'.$style->cat_title_alpha .'" ); '; }?>
	$( "#cat_desc_alpha" ).slider({ value: 100 });
	<? if(isset($style->cat_desc_alpha)){ echo '$( "#cat_desc_alpha" ).slider("value", "'.$style->cat_desc_alpha .'" ); '; }?>
	$( "#feed_title_alpha" ).slider({ value: 100 });
	<? if(isset($style->feed_title_alpha)){ echo '$( "#feed_title_alpha" ).slider("value", "'.$style->feed_title_alpha .'" ); '; }?>
	$( "#feed_desc_alpha" ).slider({ value: 100 });
	<? if(isset($style->feed_desc_alpha)) { echo '$( "#feed_desc_alpha" ).slider("value", "'.$style->feed_desc_alpha .'" ); '; }?>
		
});

function chooseImg(id, img, name)
{
	$('#img_'+name+'_'+id).parent().find('img').css('opacity', '0.7');
	
	$('#img_'+name+'_'+id).parent().find('img').css('border', '');

	$('#img_'+name+'_'+id).css('opacity', '1');	
	$('#img_'+name+'_'+id).css('border', '1px solid gray');	
	$('#img_'+name+'_'+id).attr('onmouseout', '');	
	
	$('#img_'+name+'_'+id).parent().find('input').val(''+img);
}

</script>

<div id="graphics">
	<ul>

		<li><a href="#imp_header">Header</a></li>
		<li><a href="#background">Background</a></li>
		<li><a href="#imp_footer">Footer</a></li>
		<li><a href="#pagine">Pages</a></li>
		<li><a href="#testi">Text</a></li>

	</ul>

<div id="imp_header">

	<div class="postbox" >
	    <h3>Homepage</h3> 
	<div style="padding-left: 5px; "> 
		
	<h5>Homepage Color: </h5>
	<input type="text" placeholder="#000000" id="header_bgcolor" name="header_bgcolor" value="<? if(isset($style)) echo $style->header_bgcolor ?>" />
	
	<h5>Custom homepage image</h5>
	<?
	$data_1['type'] = 'header';
	$data_1['where'] = 'header';
	$data_1['input_id'] = 'header_bgimg';
	$data_1['value'] = (isset($style))? $style->header_bgimg : "";
	
	echo upload_img($data_1, $appsbuilder);
//	echo $this->load->view('apps/uploadimg',$data_1, true);
	?>
	
<!--	<a onclick="return false;" title="Upload image" class="thickbox" id="add_image" href="media-upload.php?type=image&amp;TB_iframe=true&amp;width=640&amp;height=105">Upload Image</a>
	<br>
	
	<input type="hidden" id="upload_image" type="text" size="36" name="header_bg_file" value="" />
	<input id="upload_image_button" type="button" value="Upload Image" />
-->
	
	<h5>Homepage opacity <small>(0 to 100%)</small>: </h5>
	<div id="header_alpha" style="width: 400px;"></div>
		
	<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>	</div>
	</div>
	<br>
	
	<div class="postbox" >
	
	    <h3>Pages</h3> 
	<div style="padding-left: 5px; padding-left: 10px; "> 
	
	<h5>Pages color: </h5>
	<input type="text" placeholder="#000000" id="header2_bgcolor" name="header2_bgcolor" value="<? if(isset($style)) echo $style->header2_bgcolor ?>" />
	
	<h5>Custom pages image:</h5>
	<?
	$data_2['type'] = 'header';
	$data_2['where'] = 'header2';
	$data_2['input_id'] = 'header2_bgimg';
	$data_2['value'] = (isset($style))? $style->header2_bgimg : "";
	
	echo upload_img($data_2, $appsbuilder);

//	echo $this->load->view('apps/uploadimg',$data_2, true);
	?>
	<h5>Pages opacity <small>(0 to 100%)</small>: </h5>
	<div id="header2_alpha" style="width: 400px;"></div>

	<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>
	</div>
	</div>
	<br>
	
	<div class="postbox" >
	
	    <h3>Text</h3> 
	<div style="padding-left: 5px; padding-left: 10px; "> 
	
	<? 
	if(isset($style))
	{ 
		list($header_style, $header_weight, $header_size, $header_family) = explode(' ', $style->header_title_font, 4);
		$sel = 'selected = "selected"';
	}
	?>
	
	<h5>Style: </h5>
	<select name="header_style">
		<option value="normal" <? if(isset($style) && 'normal' == $header_style) echo $sel; ?> >normal</option>
		<option value="italic" <? if(isset($style) && 'italic' == $header_style) echo $sel; ?> >italic</option>
		<option value="oblique" <? if(isset($style) && 'oblique' == $header_style) echo $sel; ?>>oblique</option>
	</select>
	<h5>Weight: </h5>
	<select name="header_weight">
		<option value="normal" <? if(isset($style) && 'normal' == $header_weight) echo $sel; ?> >normal</option>
		<option value="500" <? if(isset($style) && '500' == $header_weight) echo $sel; ?> >500</option>
		<option value="550" <? if(isset($style) && '550' == $header_weight) echo $sel; ?> >550</option>
		<option value="600" <? if(isset($style) && '600' == $header_weight) echo $sel; ?> >600</option>
		<option value="650" <? if(isset($style) && '650' == $header_weight) echo $sel; ?> >650</option>
		<option value="bold" <? if(isset($style) && 'bold' == $header_weight) echo $sel; ?> >bold</option>
		<option value="bolder" <? if(isset($style) && 'bolder' == $header_weight) echo $sel; ?> >bolder</option>
		<option value="lighter" <? if(isset($style) && 'lighter' == $header_weight) echo $sel; ?> >lighter</option>
	</select>
	
	<h5>Size: </h5>
	<select name="header_size">
	<?
		for($i = 9; $i <= 49; $i = $i+2)
		{
			$sel1 = '';
			if(isset($style) && $i.'px' == $header_size)
				$sel1 = 'selected = "selected"';
			echo '<option value="'.$i.'px" '.$sel1.'>'.$i.'px</option>';
		}
	
	?>
	</select>
	
	<h5>Family: </h5>
	<select name="header_family">
		<option value="Arial,Helvetica" <? if(isset($style) && 'Arial,Helvetica' == $header_family) echo $sel; ?> >Arial,Helvetica</option>
		<option value="Verdana, sans-serif" <? if(isset($style) && 'Verdana, sans-serif' == $header_family) echo $sel; ?>>Verdana, sans-serif</option>
		<option value="Times New Roman, serif" <? if(isset($style) && 'Times New Roman, serif' == $header_family) echo $sel; ?> >Times New Roman, serif</option>
		<option value="Impact, serif" <? if(isset($style) && 'Impact, serif' == $header_family) echo $sel; ?> >Impact, serif</option>
		<option value="Comic Sans, Monospace" <? if(isset($style) && 'Comic Sans, Monospace' == $header_family) echo $sel; ?> >Comic Sans, Monospace</option>
		<option value="Georgia, Fantasy" <? if(isset($style) && 'Georgia, Fantasy' == $header_family) echo $sel; ?> >Georgia, Fantasy</option>
	</select>
	
	<h5>Color: </h5>
	<input type="text" placeholder="#000000" id="header_title_color" name="header_title_color" value="<? if(isset($style)) echo $style->header_title_color ?>" />
	
	<h5>opacity <small>(0 to 100%)</small>: </h5>
	<div id="header_title_alpha" style="width: 400px;"></div>

	<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>	</div>
	</div>
	<br>
	
</div>




<div id="background">

	
	<div class="postbox" >
	
	    <h3>Homepage</h3> 
	<div style="padding-left: 5px; "> 
	<h5>Homepage Color: </h5>
	<input type="text" placeholder="#000000" id="bg_color" name="bg_color" value="<? if(isset($style)) echo $style->bg_color ?>" />
	
	<h5>Custom homepage image:</h5>
	<?
	$data_3['type'] = 'background';
	$data_3['where'] = 'background';
	$data_3['input_id'] = 'bg_img';
	$data_3['value'] = (isset($style))? $style->bg_bgimg : "";
	
	echo upload_img($data_3, $appsbuilder);

//	echo $this->load->view('apps/uploadimg',$data_3, true);
	?>
	
	<h5>Homepage opacity <small>(0 to 100%)</small>: </h5>
	<div id="bg_alpha" style="width: 400px;"></div>
	
	<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>	</div>
	</div>
	<br>
	
	<div class="postbox" >
	
	    <h3>Pages</h3> 
	<div style="padding-left: 5px; "> 
	
	<h5>Pages Color: </h5>
	<input type="text" placeholder="#000000" id="bg2_color" name="bg2_color" value="<? if(isset($style)) echo $style->bg2_color ?>" />
	
	<h5>Custom pages image:</h5>
	<?
	$data_4['type'] = 'background';
	$data_4['where'] = 'background2';
	$data_4['input_id'] = 'bg2_img';
	$data_4['value'] = (isset($style))? $style->bg2_bgimg : "";

	echo upload_img($data_4, $appsbuilder);

//	echo $this->load->view('apps/uploadimg',$data_4, true);
	?>
	
	<h5>Pages opacity <small>(0 to 100%)</small>: </h5>
	<div id="bg2_alpha" style="width: 400px;"></div>
	
	<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>	</div>
	</div>
	<br>
	
</div>

<div id="imp_footer">


	
	<div class="postbox" >
	
	    <h3>Back</h3> 
	<div style="padding-left: 5px; "> 
	<h5>Choose "Back" button:</h5>
	<?
	$data_f1['type'] = 'button';
	$data_f1['where'] = 'button_prev';
	$data_f1['input_id'] = 'footer_prev_img';
	$data_f1['value'] = (isset($style))? $style->footer_prev_img : "";

	echo upload_img($data_f1, $appsbuilder);

//	echo $this->load->view('apps/uploadimg',$data_f1, true);
	?>
	<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>	</div>
	</div>
	<br>
	
	<div class="postbox" >
	
	    <h3>Next</h3> 
	<div style="padding-left: 5px; "> 
	
	<h5>Choose "Next" button:</h5>
	<?
	$data_f2['type'] = 'button';
	$data_f2['where'] = 'button_next';
	$data_f2['input_id'] = 'footer_next_img';
	$data_f2['value'] = (isset($style))? $style->footer_next_img : "";

	echo upload_img($data_f2, $appsbuilder);

//	echo $this->load->view('apps/uploadimg',$data_f2, true);
	?>
	
	<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>	</div>
	</div>
	<br>
	
	<div class="postbox" >
	
	    <h3>Share</h3> 
	<div style="padding-left: 5px; "> 
	
	<h5>Choose "Share" button:</h5>
	<?
	$data_f3['type'] = 'button';
	$data_f3['where'] = 'button_share';
	$data_f3['input_id'] = 'footer_share_img';
	$data_f3['value'] = (isset($style))? $style->footer_share_img : "";
	
	echo upload_img($data_f3, $appsbuilder);

//	echo $this->load->view('apps/uploadimg',$data_f3, true);
	?>
	
	<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>	</div>
	</div>
	<br>
	

</div>

<div id="pagine">
	<div style="width: 260px;float: left;">
	<? 
	if(isset($style))
	{ 
		list($cat_title_style, $cat_title_weight, $cat_title_size, $cat_title_family) = explode(' ', $style->cat_title_font, 4);
		$sel = 'selected = "selected"';
	}
	?>
	
	<h5>Title Style: </h5>
	<select name="cat_title_style">
		<option value="normal" <? if(isset($style) && 'normal' == $cat_title_style) echo $sel; ?> >normal</option>
		<option value="italic" <? if(isset($style) && 'italic' == $cat_title_style) echo $sel; ?> >italic</option>
		<option value="oblique" <? if(isset($style) && 'oblique' == $cat_title_style) echo $sel; ?>>oblique</option>
	</select>
	<h5>Title Weight: </h5>
	<select name="cat_title_weight">
		<option value="normal" <? if(isset($style) && 'normal' == $cat_title_weight) echo $sel; ?> >normal</option>
		<option value="500" <? if(isset($style) && '500' == $cat_title_weight) echo $sel; ?> >500</option>
		<option value="550" <? if(isset($style) && '550' == $cat_title_weight) echo $sel; ?> >550</option>
		<option value="600" <? if(isset($style) && '600' == $cat_title_weight) echo $sel; ?> >600</option>
		<option value="650" <? if(isset($style) && '650' == $cat_title_weight) echo $sel; ?> >650</option>
		<option value="bold" <? if(isset($style) && 'bold' == $cat_title_weight) echo $sel; ?> >bold</option>
		<option value="bolder" <? if(isset($style) && 'bolder' == $cat_title_weight) echo $sel; ?> >bolder</option>
		<option value="lighter" <? if(isset($style) && 'lighter' == $cat_title_weight) echo $sel; ?> >lighter</option>
	</select>
	
	<h5>Title Size: </h5>
	<select name="cat_title_size">
	<?
		for($i = 9; $i <= 49; $i = $i+2)
		{
			$sel1 = '';
			if(isset($style) && $i.'px' == $cat_title_size)
				$sel1 = 'selected = "selected"';
			echo '<option value="'.$i.'px" '.$sel1.'>'.$i.'px</option>';
		}
	
	?>
	</select>
	
	<h5>Title Family: </h5>
	<select name="cat_title_family">
		<option value="Arial,Helvetica" <? if(isset($style) && 'Arial,Helvetica' == $cat_title_family) echo $sel; ?> >Arial,Helvetica</option>
		<option value="Verdana, sans-serif" <? if(isset($style) && 'Verdana, sans-serif' == $cat_title_family) echo $sel; ?>>Verdana, sans-serif</option>
		<option value="Times New Roman, serif" <? if(isset($style) && 'Times New Roman, serif' == $cat_title_family) echo $sel; ?> >Times New Roman, serif</option>
		<option value="Impact, serif" <? if(isset($style) && 'Impact, serif' == $cat_title_family) echo $sel; ?> >Impact, serif</option>
		<option value="Comic Sans, Monospace" <? if(isset($style) && 'Comic Sans, Monospace' == $cat_title_family) echo $sel; ?> >Comic Sans, Monospace</option>
		<option value="Georgia, Fantasy" <? if(isset($style) && 'Georgia, Fantasy' == $cat_title_family) echo $sel; ?> >Georgia, Fantasy</option>
	</select>
	
	<h5>Title Color: </h5>
	<input type="text" placeholder="#000000" id="cat_title_color" name="cat_title_color" value="<? if(isset($style)) echo $style->cat_title_color ?>" />
	
	<h5>Title opacity <small>(0 to 100%)</small>: </h5>
	<div id="cat_title_alpha" style="width: 220px;"></div>

	
	</div>
	<div>
	
	
	<? 
	if(isset($style))
	{ 
		list($cat_desc_style, $cat_desc_weight, $cat_desc_size, $cat_desc_family) = explode(' ', $style->cat_desc_font, 4);
		$sel = 'selected = "selected"';
	}
	?>
	
	<h5>Description Style: </h5>
	<select name="cat_desc_style">
		<option value="normal" <? if(isset($style) && 'normal' == $cat_desc_style) echo $sel; ?> >normal</option>
		<option value="italic" <? if(isset($style) && 'italic' == $cat_desc_style) echo $sel; ?> >italic</option>
		<option value="oblique" <? if(isset($style) && 'oblique' == $cat_desc_style) echo $sel; ?>>oblique</option>
	</select>
	<h5>Description Weight: </h5>
	<select name="cat_desc_weight">
		<option value="normal" <? if(isset($style) && 'normal' == $cat_desc_weight) echo $sel; ?> >normal</option>
		<option value="500" <? if(isset($style) && '500' == $cat_desc_weight) echo $sel; ?> >500</option>
		<option value="550" <? if(isset($style) && '550' == $cat_desc_weight) echo $sel; ?> >550</option>
		<option value="600" <? if(isset($style) && '600' == $cat_desc_weight) echo $sel; ?> >600</option>
		<option value="650" <? if(isset($style) && '650' == $cat_desc_weight) echo $sel; ?> >650</option>
		<option value="bold" <? if(isset($style) && 'bold' == $cat_desc_weight) echo $sel; ?> >bold</option>
		<option value="bolder" <? if(isset($style) && 'bolder' == $cat_desc_weight) echo $sel; ?> >bolder</option>
		<option value="lighter" <? if(isset($style) && 'lighter' == $cat_desc_weight) echo $sel; ?> >lighter</option>
	</select>
	
	<h5>Description Size: </h5>
	<select name="cat_desc_size">
	<?
		for($i = 9; $i <= 49; $i = $i+2)
		{
			$sel1 = '';
			if(isset($style) && $i.'px' == $cat_desc_size)
				$sel1 = 'selected = "selected"';
			echo '<option value="'.$i.'px" '.$sel1.'>'.$i.'px</option>';
		}
	
	?>
	</select>
	
	<h5>Description Family: </h5>
	<select name="cat_desc_family">
		<option value="Arial,Helvetica" <? if(isset($style) && 'Arial,Helvetica' == $cat_desc_family) echo $sel; ?> >Arial,Helvetica</option>
		<option value="Verdana, sans-serif" <? if(isset($style) && 'Verdana, sans-serif' == $cat_desc_family) echo $sel; ?>>Verdana, sans-serif</option>
		<option value="Times New Roman, serif" <? if(isset($style) && 'Times New Roman, serif' == $cat_desc_family) echo $sel; ?> >Times New Roman, serif</option>
		<option value="Impact, serif" <? if(isset($style) && 'Impact, serif' == $cat_desc_family) echo $sel; ?> >Impact, serif</option>
		<option value="Comic Sans, Monospace" <? if(isset($style) && 'Comic Sans, Monospace' == $cat_desc_family) echo $sel; ?> >Comic Sans, Monospace</option>
		<option value="Georgia, Fantasy" <? if(isset($style) && 'Georgia, Fantasy' == $cat_desc_family) echo $sel; ?> >Georgia, Fantasy</option>
	</select>
	
	
	<h5>Description Color: </h5>
	<input type="text" placeholder="#000000" id="cat_desc_color" name="cat_desc_color" value="<? if(isset($style)) echo $style->cat_desc_color ?>" />
	
	<h5>Description opacity <small>(0 to 100%)</small>: </h5>
		<div id="cat_desc_alpha" style="width: 220px; float: right; margin-top: -13px;"></div>
	
	</div>
	
		<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>
</div>

<div id="testi">
	<div style="width: 260px;float: left;">
	
	<? 
	if(isset($style))
	{ 
		list($feed_title_style, $feed_title_weight, $feed_title_size, $feed_title_family) = explode(' ', $style->feed_title_font, 4);
		$sel = 'selected = "selected"';
	}
	?>
	
	<h5>Title Style: </h5>
	<select name="feed_title_style">
		<option value="normal" <? if(isset($style) && 'normal' == $feed_title_style) echo $sel; ?> >normal</option>
		<option value="italic" <? if(isset($style) && 'italic' == $feed_title_style) echo $sel; ?> >italic</option>
		<option value="oblique" <? if(isset($style) && 'oblique' == $feed_title_style) echo $sel; ?>>oblique</option>
	</select>
	<h5>Title Weight: </h5>
	<select name="feed_title_weight">
		<option value="normal" <? if(isset($style) && 'normal' == $feed_title_weight) echo $sel; ?> >normal</option>
		<option value="500" <? if(isset($style) && '500' == $feed_title_weight) echo $sel; ?> >500</option>
		<option value="550" <? if(isset($style) && '550' == $feed_title_weight) echo $sel; ?> >550</option>
		<option value="600" <? if(isset($style) && '600' == $feed_title_weight) echo $sel; ?> >600</option>
		<option value="650" <? if(isset($style) && '650' == $feed_title_weight) echo $sel; ?> >650</option>
		<option value="bold" <? if(isset($style) && 'bold' == $feed_title_weight) echo $sel; ?> >bold</option>
		<option value="bolder" <? if(isset($style) && 'bolder' == $feed_title_weight) echo $sel; ?> >bolder</option>
		<option value="lighter" <? if(isset($style) && 'lighter' == $feed_title_weight) echo $sel; ?> >lighter</option>
	</select>
	
	<h5>Title Size: </h5>
	<select name="feed_title_size">
	<?
		for($i = 9; $i <= 49; $i = $i+2)
		{
			$sel1 = '';
			if(isset($style) && $i.'px' == $feed_title_size)
				$sel1 = 'selected = "selected"';
			echo '<option value="'.$i.'px" '.$sel1.'>'.$i.'px</option>';
		}
	
	?>
	</select>
	
	<h5>Title Family: </h5>
	<select name="feed_title_family">
		<option value="Arial,Helvetica" <? if(isset($style) && 'Arial,Helvetica' == $feed_title_family) echo $sel; ?> >Arial,Helvetica</option>
		<option value="Verdana, sans-serif" <? if(isset($style) && 'Verdana, sans-serif' == $feed_title_family) echo $sel; ?>>Verdana, sans-serif</option>
		<option value="Times New Roman, serif" <? if(isset($style) && 'Times New Roman, serif' == $feed_title_family) echo $sel; ?> >Times New Roman, serif</option>
		<option value="Impact, serif" <? if(isset($style) && 'Impact, serif' == $feed_title_family) echo $sel; ?> >Impact, serif</option>
		<option value="Comic Sans, Monospace" <? if(isset($style) && 'Comic Sans, Monospace' == $feed_title_family) echo $sel; ?> >Comic Sans, Monospace</option>
		<option value="Georgia, Fantasy" <? if(isset($style) && 'Georgia, Fantasy' == $feed_title_family) echo $sel; ?> >Georgia, Fantasy</option>
	</select>
	
	<h5>Title Color: </h5>
	<input type="text" placeholder="#000000" id="feed_title_color" name="feed_title_color" value="<? if(isset($style)) echo $style->feed_title_color ?>" />
	
	<h5>Title opacity <small>(0 to 100%)</small>: </h5>
		<div id="feed_title_alpha" style="width: 220px;"></div>
	
	</div>
	
	<? 
	if(isset($style))
	{ 
		list($feed_desc_style, $feed_desc_weight, $feed_desc_size, $feed_desc_family) = explode(' ', $style->feed_desc_font, 4);
		$sel = 'selected = "selected"';
	}
	?>
	
	<h5>Description Style: </h5>
	<select name="feed_desc_style">
		<option value="normal" <? if(isset($style) && 'normal' == $feed_desc_style) echo $sel; ?> >normal</option>
		<option value="italic" <? if(isset($style) && 'italic' == $feed_desc_style) echo $sel; ?> >italic</option>
		<option value="oblique" <? if(isset($style) && 'oblique' == $feed_desc_style) echo $sel; ?>>oblique</option>
	</select>
	<h5>Description Weight: </h5>
	<select name="feed_desc_weight">
		<option value="normal" <? if(isset($style) && 'normal' == $feed_desc_weight) echo $sel; ?> >normal</option>
		<option value="500" <? if(isset($style) && '500' == $feed_desc_weight) echo $sel; ?> >500</option>
		<option value="550" <? if(isset($style) && '550' == $feed_desc_weight) echo $sel; ?> >550</option>
		<option value="600" <? if(isset($style) && '600' == $feed_desc_weight) echo $sel; ?> >600</option>
		<option value="650" <? if(isset($style) && '650' == $feed_desc_weight) echo $sel; ?> >650</option>
		<option value="bold" <? if(isset($style) && 'bold' == $feed_desc_weight) echo $sel; ?> >bold</option>
		<option value="bolder" <? if(isset($style) && 'bolder' == $feed_desc_weight) echo $sel; ?> >bolder</option>
		<option value="lighter" <? if(isset($style) && 'lighter' == $feed_desc_weight) echo $sel; ?> >lighter</option>
	</select>
	
	<h5>Description Size: </h5>
	<select name="feed_desc_size">
	<?
		for($i = 9; $i <= 49; $i = $i+2)
		{
			$sel1 = '';
			if(isset($style) && $i.'px' == $feed_desc_size)
				$sel1 = 'selected = "selected"';
			echo '<option value="'.$i.'px" '.$sel1.'>'.$i.'px</option>';
		}
	
	?>
	</select>
	
	<h5>Description Family: </h5>
	<select name="feed_desc_family">
		<option value="Arial,Helvetica" <? if(isset($style) && 'Arial,Helvetica' == $feed_desc_family) echo $sel; ?> >Arial,Helvetica</option>
		<option value="Verdana, sans-serif" <? if(isset($style) && 'Verdana, sans-serif' == $feed_desc_family) echo $sel; ?>>Verdana, sans-serif</option>
		<option value="Times New Roman, serif" <? if(isset($style) && 'Times New Roman, serif' == $feed_desc_family) echo $sel; ?> >Times New Roman, serif</option>
		<option value="Impact, serif" <? if(isset($style) && 'Impact, serif' == $feed_desc_family) echo $sel; ?> >Impact, serif</option>
		<option value="Comic Sans, Monospace" <? if(isset($style) && 'Comic Sans, Monospace' == $feed_desc_family) echo $sel; ?> >Comic Sans, Monospace</option>
		<option value="Georgia, Fantasy" <? if(isset($style) && 'Georgia, Fantasy' == $feed_desc_family) echo $sel; ?> >Georgia, Fantasy</option>
	</select>
	
	
	
	
	<h5>Description Color: </h5>
	<input type="text" placeholder="#000000" id="feed_desc_color" name="feed_desc_color" value="<? if(isset($style)) echo $style->feed_desc_color ?>" />
	
	<h5>Description opacity <small>(0 to 100%)</small>: </h5>
		<div id="feed_desc_alpha" style="width: 220px; float: right; margin-top: -13px;"></div>
		<br>
	<br>
	
	<div style="text-align:center">
	<button class="button" onclick="creaApplicazione('<?=$id_app?>', 'template', '');" >Save</button>
	</div>
	<br>
	</div>

</div>
