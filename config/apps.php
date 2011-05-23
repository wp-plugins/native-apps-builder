<style type="text/css">
<?php
	require_once("apps.css");
?>
</style>
<?php
	$ids = get_option("appsbuilder_idapp");
?>
<img src="/wp-content/plugins/Native_Apps_Builder/img/logo.png" />
<div class="metabox-holder">
	<div class="postbox">
	<h3>Dashboard</h3>
	<div id="boxin">
	<p>You can create multiple apps from your wordpress blog. 
	Click on 'Create New App' button for create new version.
	Click on 'Modify' button for modify the app settings, download native versions and qr code. 
	Click on 'Delete' button if you want to delete your app.<br />
	</p>
	<form method="POST" action="" id="new">
		<input type="hidden" name="page" value="createapp"/>
		<input type="submit" value="Create New App" class="button-primary"/>
	</form>
	<h4>My Apps:</h4>
<?php
	foreach($ids as $id){
		echo "<div class='app'><table class='form-table'>";
		echo "<tr><th scope='row'><span><strong>".get_option("appsbuilder_titolo".$id)."</strong></span></th>";
		echo "<td><form method='POST' action=''>";
		echo "<input type='hidden' name='page' value='configapp'/>";
		echo "<input type='hidden' name='id_app' value='$id'/>";
		echo "<input type='submit' value='MODIFY' class='button-secondary'/>";
		echo "</form></td>";

		echo "<td><form method='POST' action='' onsubmit=\"return confirm('are you sure ?')\">";
		echo "<input type='hidden' name='page' value='deleteapp'/>";
		echo "<input type='hidden' name='id_app' value='$id'/>";
		echo "<input type='submit' value='DELETE' class='button-secondary'/>";
		echo "</form></td>";
		echo "</tr></table></div>";
	}
?>
	</div>
	</div>
</div>
<?php include_once('footer.php'); ?>
