<?php  
    /* 
    Plugin Name: Native Apps Builder 
    Plugin URI: http://www.apps-builder.com/ 
    Description: With Native Apps Builder Plugin you can create 100% <strong>NATIVE app version</strong> of your wordpress'site. Available native apps for iPhone iPad Android and Tablets. In 6 easy steps you'll able to download native apps and submitting them in the <strong>Apple Store</strong> and <strong>Market Android</strong>. Native apps builder now support webapp and native apps.
    Author: Apps Builder srl 
    Version: 2.0 Beta 
    Author URI: http://www.apps-builder.com 
    */  
add_action('admin_menu', 'my_plugin_menu');
function my_plugin_menu() {
	add_options_page('Native-Apps-Builder', 'Native-Apps-Builder', 1, 'NativeAppsBuilder', 'appsbuilderoptions');
}
function appsbuilderoptions() {
	include('appsbuilder_page.php');
}
?>
