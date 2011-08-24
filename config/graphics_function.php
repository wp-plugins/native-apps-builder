<?
//upload img
function upload_img($data, $appsbuilder)
{
	$html = "";
	$html .= "<p>Choose the style: </p>";
	$html .= '<select id="select_'.$data['where'].'" 
				onchange="change_imgset(\'default\', \''.$data['type'].'\', \''.$data['input_id'].'\', \''.$data['where'].'\')" >';
	

	$data_img = $appsbuilder->getImages("default",$data['type'], "sets");
	foreach(json_decode($data_img) as $set)
	{
		$html .= "<option value=\"$set\">$set</option>";	
	}
	$html .= "<option value=\"user\">uploads</option>";
	
	
	$html .= '</select>';	 

	$datahead = array();
	$datahead['imgs'] = $appsbuilder->getImages("default", $data['type'], "blue");
	$datahead['name'] = $data['input_id'];	
	$datahead['value'] = $data['value'];
	
	
	
	$html .= '<div id="imglist_'.$data['where'].'"';
	
	if(strstr($data['input_id'], 'header')) 
		$html .= ' style=" overflow:auto;margin-top 15px; height: 136px; width: 225px;"';
	
	$html .= ' >';
	
	
	$html .= image_slideshow($datahead);
		
	$html .= '</div>';

	
	/*$html .= "
	<p>Oppure carica un'immagine: <small>(le immagini sono salvate in \"uploads\")</small></p>
	 <form id=\"".$data['where']."_bg_form\" >
	    <input type=\"file\" name=\"".$data['where']."_bg_file\" style=\"float: left;\" />
	    <div id=\"upload_".$data['where']."1\" class=\"recebe\" style=\"width: 130px; float: left;\" >&nbsp;</div>
	    <button class=\"button\" onClick=\"micoxUpload('".$data['where']."_bg_form',
	    							'upload.php?file=".$data['where']."_bg_file',
	    							'upload_".$data['where']."1',
	    							'Uploading...','Error in upload', 
	    							'".$data['type']."', '".$data['input_id']."', '".$data['where']."'); 
	    							return false;\" type=\"button\">Upload</button>
	 </form>";
	 */

	$html .= "<p>Or upload an image: <small>(images saved in \"uploads\")</small></p>";
	$html .= '<input class="upload_image_button" name="'.$data['where'].'" type="button" value="Upload Image" />';
	
	return $html;
}	



//slideshow
function image_slideshow($d){
	$i =0;
	$width=52;
	$data = "";
	
	if(strstr($d['name'], 'header'))
		$width=200;
	elseif(strstr($d['name'], 'footer'))
		$width=20;
	
	foreach(json_decode($d['imgs']) as $img) 
	{
		$src="http://www.apps-builder.com".$img;
		$jsfunc = "chooseImg('".$i."', '".$img."', '".$d['name']."')";
	
		if($d['name'] == 'template')
		{
			$src = 	"http://www.apps-builder.com/templates".$img."/preview.jpg";
		}
			
		$data .= '	
			<img id="img_'.$d['name'].'_'.$i.'" style="width:'.$width.'px; padding: 1px; opacity: 0.7; cursor: pointer;"
			 onmouseover="this.style.opacity = 1;" onmouseout="this.style.opacity = 0.7;" 
			 onclick="'.$jsfunc.'"
			 src="'.$src.'" /> ';
			
		if(strstr($d['name'], 'header'))
				$data .= '<br>';
			
		$i++;
	}
	$value = ""; 
	if(isset($d['value']))
		$value = $d['value'];
	
	$data .= '<input type="hidden" name="'.$d['name'].'" id="'.$d['name'].'" value="'.$value.'">';
	return $data;
}