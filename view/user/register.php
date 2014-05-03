<?
require_once 'data.php';
$invite_code = $_REQUEST['invite_code'];
if ($format == "modal")
{
	$lcs = "col-md-3";
	$ics = "col-md-9";
}
else
{
	$lcs = "col-md-2";
	$ics = "col-md-4";
}
?>

<div class = "container col-md-12">
	<form class="form-horizontal" action="user.php" method="post" id="register-form">
		<fieldset>
			<legend>Register</legend>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="username">Username</label>
				<div class="<?=$ics?>">
					<input id="username" name="username" type="text" placeholder="Username"<?= (isset($_user)) ? " value=\"$_user->username\"" : ""?> class="form-control input-md">
				</div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="first">First Name</label>
	       	   	<div class="<?=$ics?>">
					<input id="first" name="first" type="text" placeholder="First"<?= (isset($_user)) ? " value=\"$_user->first\"" : ""?> class="form-control input-md">
	        	</div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="last">Last Name</label>
	       	   	<div class="<?=$ics?>">
					<input id="last" name="last" type="text" placeholder="Last"<?= (isset($_user)) ? " value=\"$_user->last\"" : ""?> class="form-control input-md">
	        	</div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="email">Email</label>
	       	   	<div class="<?=$ics?>">
					<input id="email" name="email" type="text" placeholder="Email"<?= (isset($_user)) ? " value=\"$_user->email\"" : ""?> class="form-control input-md">
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
			<? if (isset($_current_user) && isAdmin($_shop->id)){?>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="autogenerate">Autogenerate</label>
				<div class="col-md-1"><input id="autogenerate" name="autogenerate" type="checkbox" class="form-control input-md"></div>
			</div>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="user_role">Role</label>
				<div class="<?=$ics?>">
					<select id="user_role" name="user_role" class="form-control input-md">						
						<?
						$roles = UserRole::get(null, $_shop->id);
						foreach ($roles as $role)
						{
							?>
							<option <?=(isset($_user) && $role->id == $_user->user_role) ? "selected" : ""?> value = "<?=$role->id?>"><?=$role->title?></option>
							<?
						}
						?>
					</select>
				</div>
			</div>
			<?}?>
			<div class="form-group">
				<label class="<?=$lcs?> control-label" for="singlebutton">Register</label>
				<div class="<?=$lcs?>">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary"><?= (isset($_user)) ? "Update" : "Register"?></button>
				</div>
				<div class="<?=$lcs?>">
					<a href="user.php?action=login" title="Log In">Already registered?</a>
				</div>
			</div>
			<input type = "hidden" name = "action" value = "save"/>
		</fieldset>
	</form>
	<script type="text/javascript">
		$(document).ready(function() {
			$('input').prop('autocomplete', 'off');
		});
	</script>
</div>