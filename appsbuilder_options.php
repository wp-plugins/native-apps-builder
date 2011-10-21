<style>
.box_appsbuilder{
	padding-left:15px;
}
</style>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/base/jquery-ui.css" type="text/css" media="all">
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js" type="text/javascript"></script>
<?
       
if($_POST['appsbuilder_hidden'] == 'Y'){
	//insert in db data post
	include_once('appsbuilder_updatedb.php');
	//if(is_number($id_app)) 
		//echo '<iframe src="http://apps-builder.com/app/getApp/'.$id_app.'" width="600" height="300">';
}

	include_once('appsbuilder_getdatadb.php');
	// admin page   
	echo '<div class="wrap">';
	echo '<img src="'.get_bloginfo('wpurl').'/wp-content/plugins/native-apps-builder/img/logo.png" style="border:none;">';
	echo '<h1>Native Apps Builder - Trasform your site into a native app</h1>
	      <span>by <strong>AppsBuilder srl</strong> - See <a href="http://wordpress.apps-builder.com/">Ufficial Site</a> | <a href="http://www.apps-builder.com/wiki/en/doku.php">FaQs</a> | <a href="">Feature Request & Feedback</a> | <a href="http://www.apps-builder.com/wiki/en/doku.php?id=docs:publish">Publisher Docs</a> | <a href="http://www.apps-builder.com/pag/terms">Terms of Service</a> | <a href="mailto:info@apps-builder.com">Support</a> </span>';
	echo '<p>Welcome to native apps builder plugin, the easy way for transforms your WordPress blog into an app.<br />With this plugin you can create the <strong>native apps version</strong> of your wordpress\' site and publish it in the <strong>Apple Store</strong> and <strong>Market Android</strong>.<br />Native Apps Builder also gives you your <strong>Webapp</strong> available for all system operative web browser supported.</p>
	<p>At the end of the process you will be able to download an <strong>app iPhone</strong>, an <strong>app Android</strong> and a webapp.</p>
	<br />Try Now, it\'s very easy..<br /><br />
		<strong>Quick Navigation - Steps:</strong><br />
				  1 <a onclick="jQuery("#active").focus();" href="#active">Active Plugin</a> - 
		                  2 <a onclick="jQuery("#account").focus();" href="#account">Account Setting</a> - 
		                  3 <a onclick="jQuery("#title").focus();" href="#title">Set Apps Title</a> - 
		                  4 <a onclick="jQuery("#upload").focus();" href="#upload">Upload Icon and Splash</a> - 
		                  5 <a onclick="jQuery("#categories").focus();" href="#categories">Select Categories</a> - 
		                  6 <a onclick="jQuery("#pages").focus();" href="#pages">Select Pages</a> - 
		                  7 <a onclick="jQuery("#other").focus();" href="#other">Others Sources</a> - 
		                  <a onclick="jQuery("#download").focus();" href="#download">Download Apps</a>';
	// ------------ PREVIEW ---------------------
	if($check != 0){
		echo '<h3>Application Preview (webapp):</h3>
		      <p>Click on Preview button after save your config to see the structure of your app. <br />
		      Remeber, you can login in <a href="http://www.apps-builder.com/auth/">apps-builder.com</a> admin panel for modify graphical layout.</p>';
		echo '<input style="height:25px;" class="button-primary" type="button" onclick="jQuery(\'#mobile\').dialog();" value="Quick Preview (click)" >';
		echo '<div id="mobile" style="display:none;width:450px;height:750px;" title="Preview"><img src="'.get_bloginfo('wpurl').'/wp-content/plugins/native-apps-builder/img/cel.png" style="border:none;"></div>';
	}
	// ------------ OPEN FORM -------------------
	echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';
	echo '<input type="hidden" name="appsbuilder_hidden" value="Y">';
	// --------------- PLUGIN STATUS
	echo '<h3 id="active">Plugin Status:</h3>
		<div class="box_appsbuilder">
		<p>If you activate the plugin, you accept <a href="">terms of service</a> of apps-builder.com site</p>';
	echo ' <fieldset>';
		if($terms == "yes"){
 			echo 'Enable<input type="radio" name="terms" value="yes" checked/>';
 			echo 'Disable<input type="radio" name="terms" value="no" />';
 		}else{
 		 	echo 'Enable<input type="radio" name="terms" value="yes" />';
  			echo 'Disable<input type="radio" name="terms" value="no" checked/>';
  		}	
	echo'	</fieldset>
		</div>';
	// ------------- GET GENERAL INFO USER --------------
	echo '<h3 id="account">Account Settings:</h3>
		<div class="box_appsbuilder" >
		<p>Please setting your account login for <a href="http://www.apps-builder.com/auth/">www.apps-builder.com</a>. <br />
		You can use this login to manage your applications mobile, see statistics and modify apps layout. </p>';
	$admin_mail = get_bloginfo('admin_email');
	$username = get_bloginfo('name');
	echo '<table><tr><td><strong>Login:</strong></td><td> <a href="http://www.apps-builder.com/auth/" title="login">http://www.apps-builder.com/auth/ </a></td></tr>';

	if($check != 1){//first time 	
		echo '<tr><td><strong>Username:</strong></td><td> <input maxlength="45" type="text" value="'.$username.'" name="username" required>(Required)</td></tr>';
		echo '<tr><td><strong>Email:</strong></td><td><input type="text" value="'.$admin_mail.'" name="email" required>(Required)</td></tr>';
		echo '<tr><td><strong>Password:</strong></td><td><input type="password" name="password" required> (Required)</td></tr>';
	}else{
		echo '<tr><td><strong>Username:</strong></td><td> <input maxlength="45" type="text" value="'.$username.'" name="username" disabled="disabled"></td></tr>';
		echo '<tr><td><strong>Email:</strong></td><td><input type="text" value="'.$email.'" name="email" disabled="disabled"></td></tr>';
		echo '<tr><td><strong>Password:</strong></td><td> Your password - Only you know it</td></tr>';
	}	
	echo'</table>
		<p>Registration is required.</p>
		</div>';
	// ------------ INSERISCI TITOLO APP ----------------------------
	echo     '<h3 id="title">1 - Name the Application:</h3>
		 <div class="box_appsbuilder">';
	echo	 '<input maxlength="20" type="text" name="title" size="60" placeholder="Type your title here" value="'.$title.'" required>';
	echo	 '<i>(Max chars allowed 20 - <strong>Required</strong>)</i><br />
		 <strong>Example:</strong> '.$username.' <br />
		 </div>';
	// ----------------- UPLOAD ICON ---------------------------------
	echo     '<h3 id="upload">2 - Upload Application Icon:</h3>
		  <div class="box_appsbuilder">
		  <p>If you don\'t insert any image, default icon will be set.</p>';
	echo	 '<input type="file" name="app_icon" size="60" placeholder="No image selected">';
	echo	 '<i>(Icon size 70x70px - Optional)</i><br /><br />';
	echo     '<strong>Example:</strong> <br /><img src="'.get_bloginfo('wpurl').'/wp-content/plugins/native-apps-builder/img/icon.png" style="border:none;">
		 </div>';
	// ------------------ UPLOAD SPLASH SCREEN -------------------------
	echo     '<h3>3 - Upload Splash Screen:</h3>
		  <div class="box_appsbuilder">
		  <p>If you don\'t insert any image, default splash will be set.</p>';
	echo	 '<input type="file" name="splash_image" size="60" placeholder="No image selected">';
	echo	 '<i>(Image size 320x480px - Optional)</i><br /><br />';
	echo '   <strong>Example:</strong> <br/><img width="320" src="'.get_bloginfo('wpurl').'/wp-content/plugins/native-apps-builder/img/splash.png" style="border:none;"></div>';	
	// ------------ STAMPA LE CATEGORIE ----------------------------
	echo 	 '<h3 id="categories">4 - Select Category</h3>
		  <div class="box_appsbuilder">
	          <p>Please select the categories that  you want to display in your mobile application. ( see <a href="#" onclick="jQuery("#cat_list").focus();">Categories List Image</a>)</p>';
	    if($cat_desc != 1)
	          echo '<p><input type="checkbox" name="cat_desc" value="1"> Check if you want to export category description</p>';
	    else
	    	  echo '<p><input type="checkbox" name="cat_desc" value="1" checked="checked" > Check if you want to export category description</p>';
	    	  
	echo	 '<div style="overflow:auto;width:500px;height:300px;background-color: #FFFFFF;border-color: #DDD;border-style: solid;border-width: 1px;padding:0 5px;">';
	      $args=array(
 		 'orderby' => 'name',
 		 'order' => 'ASC',
 		);
	      $categories = get_categories( $args );
	      foreach($categories as $category) { 
	      
	      	 if($categoriesdb == ""){//first time 
   		 	echo '<p><input class="cat" type="checkbox" name="categories[]" checked="checked" value="'.$category->name.'"><a target="_blank" href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ('.$category->count.') </p> ';
   		 }else{
			$tmp=explode(",",$categoriesdb);
			if(in_array($category->name,$tmp))
				$catselected="checked=\"checked\"";
			else
				$catselected=""; 
			echo '<p><input class="cat" type="checkbox" name="categories[]" '.$catselected.' value="'.$category->name.'"><a target="_blank" href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ('.$category->count.') </p> ';  		 
   		 }
   	       } 

	echo '</div><br />';
	echo '<div style="width:500px;height:30px;text-align:right;"><input class="button" type="button" onclick="jQuery(\'.cat\').removeAttr(\'checked\');" value="Deselect All"/></div></div>';
	// ------------ STAMPA LE PAGINE ----------------------------
	echo '<h3 id="pages">5 - Select Pages</h3>
	     <div class="box_appsbuilder" >
	     <p>Please select the pages that you want to display in your mobile application.</p>
	     <div style="overflow:auto;width:500px;height:300px;background-color: #FFFFFF;border-color: #DDD;border-style: solid;border-width: 1px;padding:0 5px;">';
	$arg = array(
		'sort_column' => 'post_date',
		'sort_order' => 'desc'
	);
	$mypages = get_pages($arg);
	foreach($mypages as $page)
	{		
		$content = $page->post_content;
		if(!$content) // Check for empty page
			continue;

		$content = apply_filters('the_content', $content);

	if($pages == ""){//first time 
		echo	'<p><input class="pag" type="checkbox" value="'.$page->post_title.'" name="pages[]" checked="checked"><a href="'.get_page_link($page->ID).'">"'.$page->post_title.'"</a></p>';
		
	}else{
		$tmp=explode(",",$pages);
		if(in_array($page->post_title,$tmp))
			$pagselected="checked=\"checked\"";
		else
			$pagselected="";
		echo	'<p><input class="pag" type="checkbox" value="'.$page->post_title.'" name="pages[]" '.$pagselected.' ><a href="'.get_page_link($page->ID).'">"'.$page->post_title.'"</a></p>';
	}

	}
	echo  '</div><br />';
	echo '<div style="width:500px;height:30px;text-align:right;"><input class="button" type="button" onclick="jQuery(\'.pag\').removeAttr(\'checked\');" value="Deselect All"/></div></div>';
	//------------------ ALTRI SOURCE ----------------------------
	echo '<h3 id="other">6 - Others Sources</h3>
	     <div class="box_appsbuilder" >
	     <pIf you have social account, you can insert here the name of the category and the url.</p>
	     <table>
	     <tr>
	     	<td>Youtube Channel:</td>
	     	<td><input type="text" name="youtube_label" placeholder="Insert category name" value="'.$youtube_label.'"></td>
	     	<td><input type="text" name="youtube_url" size="60" placeholder="Insert URL" value="'.$youtube_url.'"></td>
	     </tr>
	      <tr>
	     	<td>Flickr Photos:</td>
	     	<td><input type="text" name="photos_label" placeholder="Insert category name" value="'.$photos_label.'"></td>
	     	<td><input type="text" name="photos_url" size="60" placeholder="Insert URL" value="'.$photos_url.'"></td>
	     </tr>
	     <tr>
	     	<td>Twitter Account:</td>
	     	<td><input type="text" name="twitter_label" placeholder="Insert category name" value="'.$twitter_label.'"></td>
	     	<td><input type="text" name="twitter_url" size="60" placeholder="Insert URL" value="'.$twitter_url.'"></td>
	     </tr>
	      <tr>
	     	<td>Facebook Page:</td>
	     	<td><input type="text" name="facebook_label" placeholder="Insert category name" value="'.$facebook_label.'"></td>
	     	<td><input type="text" name="facebook_url" size="60" placeholder="Insert URL" value="'.$facebook_url.'"></td>
	     </tr>
	     <tr>
	     	<td>Contact Form:</td>
	     	<td><input type="text" name="contact_label" placeholder="Insert category name" value="'.$contact_label.'"></td>
	     	<td><input type="text" name="contact_url" size="60" placeholder="Insert email address" value="'.$contact_url.'"></td>
	     </tr>
	     </table><br />
	     <strong>Example</strong><br>
	     <table>
	     <tr>
	     	<td>Facebook Page:</td>
	     	<td><input type="text" name="" value="My Fan Page"></td>
	     	<td><input type="text" name="" size="60" value="http://www.facebook.com/AppsBuilderCom"></td>
	     </tr>
	     <tr>
	     	<td>Youtube Channel:</td>
	     	<td><input type="text" name="" value="My Videos"></td>
	     	<td><input type="text" name="" size="60" value="http://www.youtube.com/user/appsbuildercom"></td>
	     </tr>
	     </table></div>';	
	//------------------ DOWNLOAD APPP ----------------------------
	echo '<h3 id="download">7 - Download App iPhone and Android</h3>
	      <div class="box_appsbuilder" >';
	echo '<p>Click on button below to download the applications mobile for Android and Iphone</p>';
	echo '<input style="height:25px;" class="button-primary" type="submit" value="Save and Download Now Apps iPhone and Android (Click)" name="submit"><br /><br />';
	echo '<i><strong>Important:</strong><br /> You will be redirected to apps-builder.com website and a new account will be create for manage the layout of the apps.</i></div>';
	echo '<br />';
	echo '</form>';	
	echo '<h4>Do You Want More?</h4>
	      <span><a href="http://www.apps-builder.com/auth/">Login</a> in your admin panel to Apps-Builder.com website with your <a href="#account" onclick="jQuery("#account").focus();">account setting data</a>.<strong> It\'s FREE.</strong></span><br /><br />';


?>
