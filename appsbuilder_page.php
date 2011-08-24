<?php
	require("appsbuilderapi.php");
	$appsbuilder = new AppsBuilderApi();

	include_once("header.php");

	$logged = get_option("appsbuilder_logged",false);

	$extras = array(
		"youtube" => "Youtube",
		"twitter" => "Twitter",
		"image" => "Flickr",
		"facebook" => "Facebook",
		"news" => "Feed rss"
	);

	if($logged){
		$user=get_option("appsbuilder_user");
		$pwd=get_option("appsbuilder_pwd");
		$res=$appsbuilder->connect($user,$pwd);
		$id_app=$_POST['id_app'];
		$page = $_POST['page'];
		switch($page){
			case "configapp":
				include_once("config/config.php");
				break;
			case "deleteapp":
				$appsbuilder->deleteApp($id_app);

				$ids=get_option("appsbuilder_idapp");
				removeFromArray($ids,$id_app);
                                update_option("appsbuilder_idapp",$ids);

				delete_option("appsbuilder_titolo".$id_app);
				delete_option("appsbuilder_descrizione".$id_app);
				delete_option("appsbuilder_catschecked".$id_app);
				delete_option("appsbuilder_pageschecked".$id_app);
				delete_option("appsbuilder_catsimg".$id_app);
				delete_option("appsbuilder_pagesimg".$id_app);
			        foreach($extras as $k => $v){
                                	delete_option("appsbuilder_{$k}_label".$id_app);
                                        delete_option("appsbuilder_{$k}_url".$id_app);
				}
				include_once("config/apps.php");
				break;
			case "createapp":
				$id_app = $appsbuilder->createApp();

				if(!is_numeric($id_app)){
					echo "Error Creating App<br/>";
					include_once("config/apps.php");
					break;
				}

				$ids=get_option("appsbuilder_idapp");
				array_push($ids,$id_app);
				update_option("appsbuilder_idapp",$ids);
				add_option("appsbuilder_titolo".$id_app,get_option("blogname"));
				add_option("appsbuilder_descrizione".$id_app,get_option("blogdescription"));
				add_option("appsbuilder_catschecked".$id_app,array());
				add_option("appsbuilder_pageschecked".$id_app,array());
				add_option("appsbuilder_catsimg".$id_app,array());
				add_option("appsbuilder_pagesimg".$id_app,array());
			        foreach($extras as $k => $v){
                                	add_option("appsbuilder_{$k}_label".$id_app,$v);
                                        add_option("appsbuilder_{$k}_url".$id_app,"");
				}
				include_once("config/config.php");
				break;
			case "saveapp":
				include_once("config/save.php");
				break;
			case "graphics":
				include_once("config/graphics.php");
				break;
			default:
				include_once("config/apps.php");
				break;
		}
	}else{
		$page = $_POST['page'];
		switch($page){
			case "login":
				$user=$_POST['username'];
				$pwd=$_POST['password'];
				$res=$appsbuilder->connect($user,$pwd);
				if($res == "true"){
					add_option("appsbuilder_logged",true);
					add_option("appsbuilder_user",$user);
					add_option("appsbuilder_pwd",$pwd);
					add_option("appsbuilder_idapp",array());
					include_once("config/apps.php");
				}else{
					$msg="<div class='message'>".$res."</div>";
					include_once("login/login.php");
				}
				break;
			case "register":
				$user=$_POST['username'];
				$pwd=$_POST['password'];
				$email=$_POST['email'];
				$res=$appsbuilder->register($user,$pwd,$email);
				if(preg_match('/success/',$res)){
					$msg="<div class='message'>Now, check your mail and validate the account. It will be automatically deleted within 48 hours unless you validate it. Remember to activate your account to process.</div>";
				}else{
					$msg="<div class='message'>".$res."</div>";
				}
				include_once("login/login.php");
				break;
			default:
				include_once("login/login.php");
		}
	}




function removeFromArray(&$array, $key){
	foreach($array as $j=>$i){
		if($i == $key){
			unset($array[$j]);
			return;
		}
	}
}
?>


