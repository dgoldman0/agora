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
	<form class="form-horizontal" action="user.php" method="post" id="register-form">
		<fieldset>
			<legend>Register</legend>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="username">Username</label>
				<div class="<?=$ics?>">
					<input id="username" name="username" type="text" placeholder="Username"<?= (isset($user)) ? " value=\"$user->username\"" : ""?> class="form-control input-md">
				</div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="first">First Name</label>
           	   	<div class="<?=$ics?>">
					<input id="first" name="first" type="text" placeholder="First"<?= (isset($user)) ? " value=\"$user->first\"" : ""?> class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="last">Last Name</label>
           	   	<div class="<?=$ics?>">
					<input id="last" name="last" type="text" placeholder="Last"<?= (isset($user)) ? " value=\"$user->last\"" : ""?> class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="email">Email</label>
           	   	<div class="<?=$ics?>">
					<input id="email" name="email" type="text" placeholder="Email"<?= (isset($user)) ? " value=\"$user->email\"" : ""?> class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="password1">Password</label>
				<div class="<?=$ics?>"><input id="password1" name="password1" type="password" placeholder="Password" class="form-control input-md register-password-field"></div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="password2">Repeat Password</label>
				<div class="<?=$ics?>"><input id="password2" name="password2" type="password" placeholder="Repeat Password" class="form-control input-md register-password-field"></div>
			</div>
			<? if (!isset($_current_user) && (REQUIRE_INVITE || isset($invite_code))) {?>
				<div class="form-group">
					<label class="<?=$lcs?> control-label" for="invite_code">Invite Code</label>
	           	   	<div class="<?=$ics?>">
						<input id="invite_code" name="invite_code" type="text" placeholder="Invite Code" value="<?=$invite_code?>" class="form-control input-md">
	            	</div>
				</div>
			<?}?>
			<? if (isset($_current_user)){?>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="autogenerate">Autogenerate</label>
				<div class="col-md-1"><input id="autogenerate" name="autogenerate" type="checkbox" class="form-control input-md"></div>
			</div>
			<?}?>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="singlebutton">Register</label>
				<div class="<?=$lcs?>">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary"><?= (isset($user)) ? "Update" : "Register"?></button>
				</div>
				<div class="<?=$lcs?>">
					<a href="login.php">Already registered?</a>
				</div>
			</div>
			<input type = "hidden" name = "action" value = "save"/>
			<?= (isset($user)) ? "<input type = \"hidden\" name = \"uid\" value = \"$user->id\"/>" : ""?>
		</fieldset>
	</form>
<?