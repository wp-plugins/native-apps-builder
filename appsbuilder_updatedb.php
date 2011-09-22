<?php

	$check = get_option('appsbuilder_firstime');  	
	$alert="<strong>Problems Fields Empty:</strong><br />";
	$checkAlert=0;

        if($check == 0){ //is firt time?
	 	$dbusername = $_POST['username'];
		$dbemail = $_POST['email'];
		$dbpassword = $_POST['password']; 
		if($dbusername == ""){
			$alert.="Username is Required.<br />";
			$checkAlert=1;
		}
		if($dbemail == "" || !strpos($dbemail,"@")){
			$alert.="Email is Required.<br />";
			$checkAlert=1;
		}
		if($dbpassword == ""){
			$alert.="Password is Required.<br />";
			$checkAlert=1;
		}
		      		   
       		update_option('appsbuilder_username', $dbusername);      	   
        	update_option('appsbuilder_email', $dbemail);    	  
      		update_option('appsbuilder_password', $dbpassword);

        }else{
                $username = get_option('appsbuilder_username');  
                $password = get_option('appsbuilder_password'); 
        }
                
        $dbterms = $_POST['terms'];
        $dbtitle = $_POST['title'];  
        
        if($dbtitle == ""){
		$alert.="Name the Application is Required.<br />";
		$checkAlert=1;
	}
        if($dbterms != "yes"){
		$alert.="Plugin Status: Enable the plugin.<br />";
		$checkAlert=1;
	}
	
		  
        update_option('appsbuilder_terms', $dbterms);
        update_option('appsbuilder_title', $dbtitle);
        
        $dbcategories = $_POST['categories'];  
        update_option('appsbuilder_categories', implode(",",$dbcategories));  
        $dbcat_desc = $_POST['cat_desc'];  
        update_option('appsbuilder_cat_desc', $dbcat_desc);     
        $dbpages = $_POST['pages'];  
        update_option('appsbuilder_pages', implode(",",$dbpages));   
        $dbyoutube_label = $_POST['youtube_label'];  
        update_option('appsbuilder_youtube_label', $dbyoutube_label);
        $dbyoutube_url = $_POST['youtube_url'];  
        update_option('appsbuilder_youtube_url', $dbyoutube_url);
        $dbphotos_label = $_POST['photos_label'];  
        update_option('appsbuilder_photos_label', $dbphotos_label);
        $dbphotos_url = $_POST['photos_url'];  
        update_option('appsbuilder_photos_url', $dbphotos_url);
        $dbtwitter_label = $_POST['twitter_label'];  
        update_option('appsbuilder_twitter_label', $dbtwitter_label);
        $dbtwitter_url = $_POST['twitter_url'];  
        update_option('appsbuilder_twitter_url', $dbtwitter_url);
        $dbfacebook_label = $_POST['facebook_label'];  
        update_option('appsbuilder_facebook_label', $dbfacebook_label);
        $dbfacebook_url = $_POST['facebook_url'];  
        update_option('appsbuilder_facebook_url', $dbfacebook_url);
        $dbcontact_label = $_POST['contact_label'];  
        update_option('appsbuilder_contact_label', $dbcontact_label); 
        $dbcontact_url = $_POST['contact_url'];  
        update_option('appsbuilder_contact_url', $dbcontact_url);      

	if($_FILES['app_icon']['error'] === 0){
		$icon = $_FILES['app_icon']['tmp_name'];
	}else{
		$icon = false;
	}

	if($_FILES['splash_image']['error'] === 0){
		$splash = $_FILES['splash_image']['tmp_name'];
	}else{
		$splash = false;
	}


        $password = get_option('appsbuilder_password');  
        $base_url=get_bloginfo('wpurl');
	$id_app = get_option('appsbuilder_idapp');
	
	if($checkAlert != 0){
			echo '<br /><div id="message" class="updated fade"><p style="color:#FF0000">'.$alert.'</p></div><br />';
			return 0;
	}	
	
	require("appsbuilderapi.php");

	$appsbuilder = new AppsBuilderApi();

	$others = array(
		"facebook" => array(
			"title" => $dbfacebook_label,
			"value" => $dbfacebook_url
		),
		"twitter" => array(
			"title" => $dbtwitter_label,
			"value" => $dbtwitter_url
		),
		"youtube" => array(
			"title" => $dbyoutube_label,
			"value" => $dbyoutube_url
		),
		"image" => array(
			"title" => $dbphotos_label,
			"value" => $dbphotos_url
		)
	);

	$contacts  = array(
		"title" => $dbcontact_label,
		"value" => $dbcontact_url
	);

	$apptree=$appsbuilder->createWordPressAppTree($base_url,$dbcategories,$dbpages,$contacts,$others);

	if($check != 0){
		//aggiorno app
		if($username != "" && $password != ""){
			$res=$appsbuilder->connect($username,$password);
			if($res != "true"){
				echo '<br /><div id="message" class="updated fade"><p><strong>Login Problem:</strong><br />'.$res.'</p></div>';
				return 0;
			}

			if(!$id_app){
				$id_app=$appsbuilder->createApp();
				if(!is_numeric($id_app)){
					echo "<br /><div id='message' class='updated fade'><p><strong>Error No App Id Found {$id_app}</strong></p></div>";
					return 0; 
				}else{
					update_option('appsbuilder_idapp', $id_app);
				}
			}

			$res=$appsbuilder->setGeneralInfos($id_app,$icon,$splash,$dbtitle);
			if($res != "true"){
				echo '<br /><div id=\"message\" class="updated fade"><p><strong>Error Updating app infos '.$id_app.' => '.$res.' </strong></p></div>';
				return 0; 
			}
			$res=$appsbuilder->updateAppTree($id_app,$apptree);
			if($res != "true"){
				echo '<div id=\"message\" class="updated fade"><p><strong>Update tree failed.</strong></p></div><br />'; 
				return 0; 
			}
			echo '<div id=\"message\" class="updated fade"><p><strong>Settings saved.</strong></p></div><br />';  

		}else{
			echo "Problem with username or password.";
		}
	}else{

		//creo app - prima volta
		if($dbusername != "" && $dbpassword != "" && $dbemail != ""){
			$res=$appsbuilder->user_register($dbusername,$dbpassword,$dbemail);
			if($res != "true"){
				echo '<br /><div id=\"message\" class="updated fade"><p><strong>Registration Problem:</strong><br />'.$res.'</p></div>';
				return 0;
			}
			//set first time
			update_option('appsbuilder_firstime', 1);
		 	$res=$appsbuilder->connect($dbusername,$dbpassword);
		 	if($res != "true"){
				echo '<br /><div id=\"message\" class="updated fade"><p><strong>Login Problem:</strong><br />'.$res.'</p></div>';
				return 0;
			}
						  
			$id_app=$appsbuilder->createApp();
			if($id_app == "" || !is_numeric($id_app)){
				echo '<br /><div id=\"message\" class="updated fade"><p><strong>Error Retrive ID APP '.$id_app.'</strong></p></div>';
				return 0; 
			}
			$appsbuilder->setGeneralInfos($id_app,$icon,$splash,$dbtitle);
			update_option('appsbuilder_idapp', $id_app);      
			echo '<br /><div id=\"message\" class="updated fade"><p><strong>New Configuration Salved (id:'.$id_app.')</strong></p></div>'; 
			$res=$appsbuilder->updateAppTree($id_app,$apptree);
			if($res != "true"){
				echo '<div id=\"message\" class="updated fade"><p><strong>Update tree failed.</strong></p></div><br />'; 
				return 0; 
			}
			echo '<div id=\"message\" class="updated fade"><p><strong>Settings saved.</strong></p></div><br />';  
			 
		}else{
			echo '<br /><div id=\"message\" class="updated fade"><p><strong>Username Or Email Are Empty.</strong></p></div>';
 		}
	}
 
?>
