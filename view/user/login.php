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
	</fiedset>
</form>