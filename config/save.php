<?php

	$titolo = $_POST['titolo'];
        $desc = $_POST['descrizione'];

        update_option("appsbuilder_titolo".$id_app,$titolo);
        update_option("appsbuilder_descrizione".$id_app,$desc);

	$catschecked=$_POST['cats'];
	update_option("appsbuilder_catschecked".$id_app,$catschecked);

	$catsimg=array();
	foreach($_POST as $key => $value){
		if(preg_match('/^catimg/',$key)){
			$catsimg[$key]=$value;
		}
	}
	update_option("appsbuilder_catsimg".$id_app,$catsimg);

	$pageschecked=$_POST['pages'];
	update_option("appsbuilder_pageschecked".$id_app,$pageschecked);
	$pagesimg=array();
	foreach($_POST as $key => $value){
		if(preg_match('/^pageimg/',$key)){
			$pagesimg[$key]=$value;
		}
	}
	update_option("appsbuilder_pagesimg".$id_app,$pagesimg);


        foreach($extras as $k => $v){
        	update_option("appsbuilder_{$k}_label".$id_app,$_POST[$k."_label"]);
                update_option("appsbuilder_{$k}_url".$id_app,$_POST[$k."_url"]);
                update_option("appsbuilder_{$k}_image".$id_app,$_POST[$k."img"]);
        }


	$tree = json_decode(base64_decode($_POST['tree']));
	if(!is_array($tree)){
		$tree=json_decode($tree);
	}
	if(!is_array($tree)){
		echo "DATA ERROR";
		exit;
	}

	foreach($pageschecked AS $pageid){
		$page = get_page($pageid);
		//print_r($page);
		$p = array();
		$p["nome"]=$page->post_title;
		$p["descrizione"]="";
		$p["img"]=$pagesimg["pageimg".$pageid];
		$p["child"]=array();

		$content = $page->post_content;
                $content = apply_filters('the_content', $content);
                $option=array(
			"type" => "text",
                        "txt" => base64_encode($content)
                );
		$p["option"]=$option;
		array_push($tree,$p);
	}


        foreach($extras as $k => $v){
        	$nome=$_POST[$k."_label"];
                $url=$_POST[$k."_url"];
                $img=$_POST[$k."img"];
		$check = false;
		if($url != ""){
			$check=true;
		}
		if($check){
			$d=array(
				"nome" => $nome,
				"descrizione" => "",
				"img" => $img,
				"child" => array()
			);

			$d["option"]=array(
				"type" => "xml",
				"urltype" => $k,
				"url" => $url
			);

			array_push($tree,$d);
		}
        }


	$tree = json_encode($tree);
	$appsbuilder->updateAppTree($id_app,$tree);

	$icon = $_FILES['app_icon']['tmp_name'];
	$splash = $_FILES['splash_image']['tmp_name'];


	$inf = array(
		"titolo" => $titolo,
		"descrizione" => $desc
	);

	$appsbuilder->setAppInfos($id_app,$inf,$icon,$splash);
	$appsbuilder->setTemplate($id_app,$_POST['template']);


	$qrcode=$appsbuilder->createQRCode($id_app);
?>
<style type="text/css">
	<?php
		include_once("save.css");
	?>
</style>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#login").submit();

		jQuery("#frameapple").bind("load",function(){
		});

		jQuery("#frame").bind("load",function(){
			$.unblockUI();
			var el = $(this);
			var d = el.data("download");
			if(d){
			jQuery("#download").attr("action","http://www.apps-builder.com/builder/"+d+"/<?php echo $id_app; ?>");
				jQuery("#download").submit();
			}
		});


		jQuery("#advfree").bind("click",function(){
		jQuery("#download").attr("action","http://www.apps-builder.com/paypal/adv/<?php echo $id_app; ?>");
			jQuery("#frame").data("download",false);
			jQuery("#download").submit();
		});

		jQuery("#android").bind("click",function(){
			$.blockUI();
		jQuery("#download").attr("action","http://www.apps-builder.com/builder/createAndroid/<?php echo $id_app; ?>");
			jQuery("#frame").data("download","getAndroidApp");
			jQuery("#download").submit();
		});

		jQuery("#iphone").bind("click",function(){
			$.blockUI();
		jQuery("#download").attr("action","http://www.apps-builder.com/builder/createIphone/<?php echo $id_app; ?>");
			jQuery("#frame").data("download","getIphoneApp");
			jQuery("#download").submit();
		});
	});
</script>
<img src="<?php echo get_bloginfo('wpurl');?>/wp-content/plugins/native-apps-builder/img/logo.png" />

<BR />
<form method="POST" action="">
        <input type="hidden" name="page" value="configapp"/>
        <input type="hidden" name="id_app" value="<?php echo $id_app; ?>"/>
       	<input type="submit" value="Back to Modify Settings" class="button-secondary"/>
</form>
	
<div class="metabox-holder">
	<div class="postbox">
		<h3>Download APPS manager</h3>
		
		<div id="box_left">
			<h4>Graphics:</h4>
		<form method="POST" action="">	
			<input type="hidden" name="page" value="graphics"/>
    	    <input type="hidden" name="id_app" value="<?php echo $id_app; ?>"/>
			<input type="submit" class="button-primary" value="Customize Layout and Graphics" id="save" />
		</form>
		
			<h4>WebApp:</h4>
			<img src="<?php echo $qrcode; ?>" /><BR />
			<span>Direct Link: <input type="text" size="40" value="http://<?php echo $id_app; ?>.apps-builder.com/<?php echo $id_app; ?>" /></span><BR />
			<span>Download Link: <input type="text" size="40" value="http://apps-builder.com/apps/<?php echo $id_app; ?>_web.png" /></span>
			<h4>Android:</h4>
			<div id="android"><input type="button" class="button-primary" value="Download Android App" /></div>
			<h4>Iphone/iPad:</h4>
			<form action="http://www.apps-builder.com/builder/addAppleCertificates/<?php echo $id_app; ?>" method="POST" target="frameapple" enctype="multipart/form-data">
			<table class="form-table">
			<p>You can generate certificates into your Apple Developer Account.</p>
				<tr>
					<th scope="row">P12 file</th>
					<td><input type="file" name="p12"/></td>
				</tr>
				<tr>
					<th scope="row">P12 Pass</th>
					<td><input type="text" name="password" size="44"/></td>
				</tr>
				<tr>
					<th scope="row">Mobile Provisioning</th>
					<td><input type="file" name="mobileprovision"/></td>
				</tr>
				<tr>
					<th scope="row"></th>
					<td><input type="submit" value="Submit Files" class="button-secondary"/></td>
				</tr>
			</table>
			<p>You must uploads certificates before you can download your iphone/ipad app.</p>
			<h4>Have you uploaded the certificates?</h4>
			<div id="iphone"><input type="button" value="Download iOs App" class="button-primary"></div>
			</form>
			<iframe id="frameapple" name="frameapple" height="50" frameborder="0" marginheight="0"> </iframe>
			<form action="http://www.apps-builder.com/auth/connect" method="POST" target="frame" style="display:none" id="login">
				<input type="hidden" name="username" value="<?php echo $user; ?>" />
				<input type="hidden" name="password" value="<?php echo $pwd; ?>" />
			</form>
			<form action="" method="POST" target="frame" style="display:none" id="download"></form>
			<h4>Help</h4>
			<p>To submit and publish tour applications in the Android Market and Apple Store click the button "<a href="http://beta.apps-builder.com/wiki/en/doku.php?id=docs:publish">Check our Documents</a>". </p>
			<br />
		</div>
		<div id="box_right">
			<h4>ADV FREE:</h4>
			<p>If you want to remove adv banner on you app, you can purchase "adv free" for 190€/year.</p>
			<div id="advfree"><input type="button" class="button-primary" value="Buy ADV FREE (paypal)" /></div>
			<iframe id="frame" name="frame" style="display:none"> </iframe>
			<h4>Preview</h4>
			<div id="cel"><iframe style="top:93px;left:27px;position:relative;" width="283" height="440" src="http://www.apps-builder.com/app/beta/<?php echo $id_app; ?>"></iframe></div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>
<?php include_once('footer.php'); ?>
