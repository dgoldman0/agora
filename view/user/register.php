<?
function registerFormView()
{
	global $market;
	$invite_code = $_REQUEST['invite_code']
?>
	<form class="form-horizontal" action="register.php" method="post" id="register-form">
		<fieldset>
			<legend>Register</legend>
			<div class="form-group">
				<label class="col-md-2 control-label" for="username">Username</label>
				<div class="col-md-4">
					<input id="username" name="username" type="text" placeholder="Username" class="form-control input-md">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="first">First Name</label>
           	   	<div class="col-md-4">
					<input id="first" name="first" type="text" placeholder="First" class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="last">Last Name</label>
           	   	<div class="col-md-4">
					<input id="last" name="last" type="text" placeholder="Last" class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="password1">Password</label>
				<div class="col-md-4"><input id="password1" name="password1" type="password" placeholder="Password" class="form-control input-md register-password-field"></div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="password2">Repeat Password</label>
				<div class="col-md-4"><input id="password2" name="password2" type="password" placeholder="Repeat Password" class="form-control input-md register-password-field"></div>
			</div>
			<? if ($market->getUserID() != -1){?>
			<div class="form-group">
				<label class="col-md-2 control-label" for="autogenerate">Autogenerate</label>
				<div class="col-md-1"><input id="autogenerate" name="autogenerate" type="checkbox" class="form-control input-md"></div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="email">Email</label>
           	   	<div class="col-md-4">
					<input id="email" name="email" type="text" placeholder="Email" class="form-control input-md">
            	</div>
			</div>
			<? if (REQUIRE_INVITE || $invite_code) {?>
				<div class="form-group">
					<label class="col-md-2 control-label" for="invite_code">Invite Code</label>
	           	   	<div class="col-md-4">
						<input id="invite_code" name="invite_code" type="text" placeholder="Invite Code" value="<?=$invite_code?>" class="form-control input-md">
	            	</div>
				</div>
			<?}?>
			<div class="form-group">
				<label class="col-md-2 control-label" for="singlebutton">Register</label>
				<div class="col-md-2">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
				</div>
				<? if ($market->getUserID() == -1){?>
				<div class="col-md-2">
					<a href="login.php">Already registered?</a>
				</div>
				<?}?>
			</div>
			<?}?>
		</fieldset>
	</form>
<?
}

if ($view == "view/register")
	registerFormView();
