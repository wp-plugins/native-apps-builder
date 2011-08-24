<?php  
    /* 
    Plugin Name: Native Apps Builder 
    Plugin URI: http://www.apps-builder.com/ 
    Description: With Native Apps Builder Plugin you can create 100% <strong>NATIVE app version</strong> of your wordpress'site. Available native apps for iPhone iPad Android and Tablets. In 6 easy steps you'll able to download native apps and submitting them in the <strong>Apple Store</strong> and <strong>Market Android</strong>. Native apps builder now support webapp and native apps.
    Author: Apps Builder srl 
    Version: 2.2 Beta 
    Author URI: http://www.apps-builder.com 
    */  
add_action('admin_menu', 'my_plugin_menu');
function my_plugin_menu() {
	add_options_page('Native-Apps-Builder', 'Native-Apps-Builder', 1, 'NativeAppsBuilder', 'appsbuilderoptions');
}
function appsbuilderoptions() {
	include('appsbuilder_page.php');
}



add_action('wp_ajax_change_imgset', 'change_imgset');
add_action('wp_ajax_save_app', 'save_app');


function change_imgset() {
	include_once("appsbuilderapi.php");

	$appsbuilder = new AppsBuilderApi();
	
	$user=get_option("appsbuilder_user");
	$pwd=get_option("appsbuilder_pwd");
	$res=$appsbuilder->connect($user,$pwd);
	
	if(isset($_POST['imgurl']))
	{
		if(strstr($_POST['where'], 'header'))
			$type = 'header';
		elseif(strstr($_POST['where'], 'background'))
			$type = 'background';
		elseif(strstr($_POST['where'], 'category'))
			$type = 'category';
		elseif(strstr($_POST['where'], 'button'))
			$type = 'button';
		
		$s = 'http://'.$_SERVER['SERVER_NAME'];
		$file = str_replace($s, '', $_POST['imgurl']);
		$file = getcwd()."/../..".$file;
		$appsbuilder->addImage($type, $file);	
	
		echo "sono qui con ".$file.' in '.$type;
	}
	
	else{
	
	$d['imgs'] = $appsbuilder->getImages($_POST['type'], $_POST['style'], $_POST['myset']);
	$d['name'] = $_POST['name'];	

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
			$jsfunc = "chooseTemplate('".$i."', '".$img."', '".$d['name']."')";
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
	echo $data;

	}
	
	die(); // this is required to return a proper result
}

function save_app()
{
	include_once("appsbuilderapi.php");

	$appsbuilder = new AppsBuilderApi();
	
	$user=get_option("appsbuilder_user");
	$pwd=get_option("appsbuilder_pwd");
	$res=$appsbuilder->connect($user,$pwd);
	
	

	$data = array(
				'header_bgcolor' => $_POST['header_bgcolor'],
				'header_alpha' => $_POST['header_alpha'],
				'header2_bgcolor' => $_POST['header2_bgcolor'],
				'header2_alpha' => $_POST['header2_alpha'],
				'header_title_font' => $_POST['header_style'].' '.$_POST['header_weight'].' '.
										$_POST['header_size'].' '.$_POST['header_family'],
				'header_title_color' => $_POST['header_title_color'],
				'header_title_alpha' => $_POST['header_title_alpha'],
				'bg_color' => $_POST['bg_color'],
				'bg_alpha' => $_POST['bg_alpha'],
				'bg2_color' => $_POST['bg2_color'],
				'bg2_alpha' => $_POST['bg2_alpha'],
				'footer_bgcolor' => $_POST['footer_bgcolor'],
				'footer_alpha' => $_POST['footer_alpha'],
				'cat_title_font' => $_POST['cat_title_style'].' '.$_POST['cat_title_weight'].' '.
										$_POST['cat_title_size'].' '.$_POST['cat_title_family'],
				'cat_title_color' => $_POST['cat_title_color'],
				'cat_title_alpha' => $_POST['cat_title_alpha'],
				'cat_desc_font' => $_POST['cat_desc_style'].' '.$_POST['cat_desc_weight'].' '.
										$_POST['cat_desc_size'].' '.$_POST['cat_desc_family'],
				'cat_desc_color' => $_POST['cat_desc_color'],
				'cat_desc_alpha' => $_POST['cat_desc_alpha'],
				'feed_title_font' => $_POST['feed_title_style'].' '.$_POST['feed_title_weight'].' '.
										$_POST['feed_title_size'].' '.$_POST['feed_title_family'],
				'feed_title_color' => $_POST['feed_title_color'],
				'feed_title_alpha' => $_POST['feed_title_alpha'],
				'feed_desc_font' => $_POST['feed_desc_style'].' '.$_POST['feed_desc_weight'].' '.
										$_POST['feed_desc_size'].' '.$_POST['feed_desc_family'],
				'feed_desc_color' => $_POST['feed_desc_color'],
				'feed_desc_alpha' => $_POST['feed_desc_alpha'],

				'header_bgimg' => $_POST['header_bgimg'],
				'header2_bgimg' => $_POST['header2_bgimg'],
				'bg_bgimg' => $_POST['bg_img'],
				'bg2_bgimg' => $_POST['bg2_img'],
				'footer_prev_img' => $_POST['footer_prev_img'],
				'footer_next_img' => $_POST['footer_next_img'],
				'footer_share_img' => $_POST['footer_share_img']				
				);

	
	$appsbuilder->setStyle($_POST['app_id'],$data);
		
	die(); // this is required to return a proper result

}

add_action('admin_head', 'change_imgset_javascript');

function change_imgset_javascript() {
?>
<script type="text/javascript" >
function change_imgset(type, style, name, dest)
{
	var myset = $('#select_'+dest).val();
	if(myset == 'user')
	{
		type = 'user';
		myset = '';
	}
	$('#imglist_'+dest).html('loading...');
	$.post(ajaxurl,{action: 'change_imgset', name:name, type : type, style:style, myset:myset },function(info){
			//alert(info);
			$('#imglist_'+dest).html(''+info);
		});	
}
</script>
<?php
}
 

?>



<?

function analyse_attachment($attachment_ID)
{          
    $attachment = get_attached_file($attachment_ID); // Gets path to attachment
}

//add_action("add_attachment", 'analyse_attachment');


wp_enqueue_script('jquery-slider', trailingslashit(CSPRITE_JS_URL_DIR).'ui.slider.js', array('jquery', 'jquery-ui-core'), '1.0');


function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', WP_PLUGIN_URL.'/native-apps-builder/js/my-script.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');
}

function my_admin_styles() {
wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');


?>
