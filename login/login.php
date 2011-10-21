<img src="<?php echo get_bloginfo('wpurl');?>/wp-content/plugins/native-apps-builder/img/logo.png" />
<style type="text/css">
<?php
	require_once("login.css");
?>
</style>

<script type="text/javascript">

	jQuery(document).ready(function(){
		jQuery("#registerform").bind("submit",function(e){
			//e.preventDefault();
			//e.stopPropagation();
			if(!jQuery("#terms").prop("checked")){
				return false;
			}
			return true;
		});
	});
</script>

<?php
	if(isset($msg)){
		echo "<div style='border:1px dashed red; padding:15px;color:red;font-size:16px;margin:6px;'><span><strong>".$msg."</strong></span></div>";
	}
?>

<div class="metabox-holder">
	<div class="postbox">
		<h3>Login your AppsBuilder account</h3>
		<form method="POST" action="" id="loginform">
			<table class="form-table">
				<tr><th scope="row"><strong>Username :</strong></th><td> <input name="username" type="text" value="" size="45"/></td></tr>
				<tr><th scope="row"><strong>Password :</strong></th><td> <input name="password" type="password" size="45"/></td></tr>
				<tr><th scope="row"></th><td><input name="page" type="hidden" value="login" /><input class="button-primary" type="submit" value="login"/></td></tr>
			</table>
		</form>
	</div>
</div>

<h3>.. OR ..</h3>

<div class="metabox-holder">
	<div class="postbox">
		<h3>Not registered yet? Fill the fields below and sign in now!</h3>
		<form method="POST" action="" id="registerform">
			<table class="form-table" >
				<tr><th scope="row"><strong>Username :</strong></th><td> <input name="username" type="text" value="" size="45"/></td></tr>
				<tr><th scope="row"><strong>Password :</strong></th><td> <input name="password" type="password" size="45"/></td></tr>
				<tr><th scope="row"><strong>Email :</strong></th><td> <input name="email" type="text" value="" size="45"/></td></tr>
				<tr><th scope="row"></th><td><input id="terms" type="checkbox" name="terms"><a href="http://www.apps-builder.com/pag/terms"> I have read and agreed the following terms and conditions</a></td></tr>
				<input name="page" type="hidden" value="register"/>
				<tr><th scope="row"></th><td><input type="submit" value="REGISTER NOW" class="button-primary"/></td></tr>
			</table>
		</form>
	</div>
</div>
<?php include_once('footer.php'); ?>
