<?
	require_once 'data.php';
	$invite_code = $_REQUEST['invite_code'];
	if ($format == "modal")
	{
		$lcs = "col-md-3";
		$ics = "col-md-8";
	}
	else
	{
		$lcs = "col-md-2";
		$ics = "col-md-4";
	}
?>

<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '1432894966961399',
			xfbml      : true,
			version    : 'v2.0'
		});
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<form class="form-horizontal" action="user.php?action=login" method="post">
	<fieldset>
		<legend>Agora Login</legend>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="username">Username</label>
			<div class="<?=$ics?>">
				<input id="username" name="username" type="text" placeholder="Username" class="form-control input-md">
			</div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="password">Password</label>
			<div class="<?=$ics?>"><input id="password" name="password" type="password" placeholder="Password" class="form-control input-md"></div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="singlebutton">Login</label>
			<div class="<?=$lcs?>">
				<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
			</div>
			<div class="<?=$lcs?>">
				<a href="user.php?action=edit">Register</a>
			</div>
		</div>
		<?=($ref = $_REQUEST['ref']) ? "<input type = \"hidden\" name = \"ref\" value = \"$ref\"/>" : ""?>
	</fiedset>
</form>