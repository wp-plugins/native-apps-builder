
<style type="text/css">
	<?php
		include_once("save.css");
	?>
</style>

<img src="<?php echo get_bloginfo('wpurl');?>/wp-content/plugins/native-apps-builder/img/logo.png" />

<BR />
<form method="POST" action="">
        <input type="hidden" name="page" value="configapp"/>
        <input type="hidden" name="id_app" value="<?php echo $id_app; ?>"/>
       	<input type="submit" value="Back to Modify Settings" class="button-secondary"/>
</form>
	
<div class="metabox-holder">
	<div class="postbox">
		<h3>Graphics Settings</h3>
		<div id="box_left">
			<?php include_once('layoutForm.php'); ?>			
		
		<!--<form method="POST" action="">
	        <input type="hidden" name="page" value="saveapp"/>
	        <input type="hidden" name="id_app" value="<?php echo $id_app; ?>"/>
	       	<input type="submit" value="Save and Download Apps" class="button-primary"/>
		</form>
		-->
	    
	    <button style="margin-top: 8px;" onclick="javascript:history.go(-1)" class="button-primary">Go To Download Apps</button>


		</div>

		<div id="box_right">
			<h4>ADV FREE:</h4>
			<p>If you want to remove adv banner on you app, you can purchase "adv free" for 190&euro;/year.</p>
			<div id="advfree"><input type="button" class="button-primary" value="Buy ADV FREE (paypal)" /></div>
			<iframe id="frame" name="frame" style="display:none"> </iframe>
			<h4>Preview</h4>
			<div id="cel"><iframe id="appframe" style="top:93px;left:27px;position:relative;" width="283" height="440" src="http://<?php echo $id_app; ?>.apps-builder.com/<?php echo $id_app; ?>"></iframe></div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>
<?php include_once('footer.php'); ?>
