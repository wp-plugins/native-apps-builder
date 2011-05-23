<?php
function subTree($cats,&$cat){
	foreach($cat as $key => &$value){
		foreach($cats as $category){
			$id=$category->cat_ID;
			if($category->parent == $key){
				$value[$id]=array();
				subTree($cats,$value);
			}
		}
	}
}


	$args=array(
        	'orderby' => 'name',
                'order' => 'ASC'
        );
        $categories = get_categories( $args );

	//print_r($categories[0]);

	$cats = array();
	$catsfeed=array();
	$tree=array();

	foreach($categories as $category){
		$id = $category->cat_ID;
		$cats[$id]=$category;
		$catsfeed[$id]=get_category_feed_link($id);
		if($category->parent == 0){
			$tree[$id]=array();
		}
	}

	subTree($categories,$tree);


	$arg = array(
                'sort_column' => 'menu_order',
                'sort_order' => 'desc'
        );

        $mypages = get_pages($arg);

	$images=$appsbuilder->getImages("default","category","default");
	if(!$images){
		$images=array();
	}
	$catschecked=get_option("appsbuilder_catschecked".$id_app);
	$catsimg=get_option("appsbuilder_catsimg".$id_app);

	$pageschecked=get_option("appsbuilder_pageschecked".$id_app);
	$pagesimg=get_option("appsbuilder_pagesimg".$id_app);
	//print_r($cats);
	$extrasimg = array();
	foreach($extras as $k => $v){
                $im = get_option("appsbuilder_{$k}_image".$id_app,false);
		if($im)
			$extrasimg[$k]=$im;
	}
?>

<style type="text/css">
<?php
	require_once("dd.css");
	require_once("config.css");
?>
</style>

<script type="text/javascript">
	window.catsimg=<?= json_encode($catsimg); ?>;
	window.catschecked=<?= json_encode($catschecked); ?>;
	window.cats=<?= json_encode($cats); ?>;
	window.catsfeed=<?= json_encode($catsfeed); ?>;
	window.catstree=<?= json_encode($tree); ?>;
	window.images=<?= $images ?>;
	window.pages=<?= json_encode($mypages); ?>;
	window.pagesimg=<?= json_encode($pagesimg); ?>;
	window.pageschecked=<?= json_encode($pageschecked); ?>;
	window.extrasimg=<?= json_encode($extrasimg); ?>;
<?php
	require_once("config.js");
?>
</script>
<div id="box_left">
<BR />
<div>
       	<form method="POST" action="">
                <input type="submit" value="Back to dashboad" class="button-primary"/>
       	</form>
</div>
<form id="appform" action="" method="POST" enctype="multipart/form-data">
	<div class="metabox-holder">
	<div class="postbox">
			<h3 class="hndle"><span>General Settings</span></h3>
		<table class="form-table">
			<tr><th scope="row">Title : </th><td><input size="44" type="text" name="titolo" value="<?= get_option('appsbuilder_titolo'.$id_app); ?>"/></td></tr>
			<tr><th scope="row">Description : </th><td><textarea cols="28" rows="5" name="descrizione"><?= get_option('appsbuilder_descrizione'.$id_app); ?></textarea></td></tr>
		</table>
	</div></div>

	<div class="metabox-holder">
	<div class="postbox">
		<h3><span>Upload Images</span></h3>
		<table class="form-table">
			<tr><th scope="row">Icon : </th><td><input type="file" name="app_icon" /></td></tr>
			<tr><th scope="row">Splash : </th><td><input type="file" name="splash_image" /></td></tr>
		</table>
	</div></div>

	<div class="metabox-holder">
	<div class="postbox">
		<h3><span>Select Categories</span></h3>
		<div id="_cats">
			<ul id="apptree">
			</ul>
		</div>
		<div style="width:600px;height:30px;text-align:right;"><input class="button" type="button" onclick="jQuery('.catCheck').prop('checked',false);" value="Deselect All"/><input class="button" type="button" onclick="jQuery('.catCheck').prop('checked',true);" value="Select All"/></div>
	</div></div>

	<div class="metabox-holder">
	<div class="postbox">
		<h3><span>Select Page</span></h3>
		<div id="_pages">
			<ul id="apppage">
			</ul>
		</div>
		<div style="width:600px;height:30px;text-align:right;"><input class="button" type="button" onclick="jQuery('.pagCheck').prop('checked',false);" value="Deselect All"/><input class="button" type="button" onclick="jQuery('.pagCheck').prop('checked',true);" value="Select All"/></div>
	</div>
	</div>

	<div class="metabox-holder">
	<div class="postbox">
		<h3><span>Select Extras</span></h3>
		<div id="extras">
		<table class="form-table">
			<?php
				foreach($extras as $k => $v){
					$optl = get_option("appsbuilder_{$k}_label".$id_app);
					$optu = get_option("appsbuilder_{$k}_url".$id_app);
			?>
				<tr>
					<th scope="row"><?= $v ?></th>
					<td class="extraimg" data-name="<?= $k ?>"></td>
					<td><input placeholder="Insert Label" style="width:140px;" type="text" name="<?= $k ?>_label" value="<?= $optl; ?>"></td>
					<td><input placeholder="Insert Url" style="width:210px;" type="text" name="<?= $k ?>_url" value="<?= $optu; ?>"></td>
				</tr>
			<?php
				}
			?>
		</table>
		</div>
	</div></div>

	<input type="hidden" name="id_app" value="<?= $id_app ?>"/>
	<input type="hidden" name="tree" />
	<input type="hidden" name="page" value="saveapp"/>
	<input type="button" class="button-primary" value="Save and Download Apps" id="save" />
</form>
<BR />
<BR />
</div>
<div id="box_right">
	<div class="metabox-holder">
		<div class="postbox">
			<h3>Help</h3>
			<div class="boxin">
				<h4>1) insert App name</h4>
				<p>Give a name of your app, for example the name of your brand or private use.</p>
				<h4>2) insert App description</h4>
				<p>This is optional.</p>
				<h4>3) upload Icon (PNG, 60x60 px)</h4> 
				<span>Example<BR /></span>
				<img src="/wp-content/plugins/native-apps-builder/img/icon.png" width="60">
				<h4>4) upload Splash (PNG, 640x960 px)</h4>
				<span>Example<BR /></span>
				<img src="/wp-content/plugins/native-apps-builder/img/splash.png" width="320">
				<h4>5) select Categories</h4>
				<p>Please select the categories that  you want to display in your mobile application. Order is by name-</p>
				<h4>6) select Pages</h4>
				<p>Please select the pages that  you want to display in your mobile application. The order is by menu_order.</p>
				<h4>7) insert other sources from youtube/facebook/twitter etc.</h4>
				<p>If you have social account, you can insert here the name of the page and the feed url.</p>
				<h4>Dowload Apps</h4>
				<p>Click 'Save' button for save configuration settings and download your app</p>
				<BR />
				<h4>Do you want more?</h4>
				<p>If you want more customizable layout, please login to <a href="http:/www.apps-builder.com/">apps-builder.com</a> </p>
			</div>
		</div>
	</div>
</div>
<div style="clear:both"></div>
<?php include_once('footer.php'); ?>
