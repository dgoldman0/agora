<?php
require_once 'settings.php';
require_once 'data.php';
require_once 'data/user.php';
require_once 'data/activity.php';
require_once 'administration.php';

// Varies depending on whether or not there is a user signed in and he/she has user create authorization
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
<?php
}

$username = $_REQUEST['username'];

include 'include/header.php';
// Probably should reverse the order of the if statements to reduce repeating code
if ($username == '')
{
	$id = getUserID();
	if (($id == -1 && ALLOW_REGISTRATION) || userRoleIncludes(USER_PERMISSION_EDIT_USER))
	{
		if ($id != -1)
		{
			include 'menu.php';
			?>
			<div class="row">
				<?php displayAdminPanel();?>
				<div class = "col-md-10">
					<div class="panel panel-default">
						<div class="panel-heading">
							Add User
						</div>
						<div class="panel-body">
			<?php
		}
		registerFormView();
		if ($id != -1)
		{
			echo '</div></div></div></div>';
		}
	} else
	{
		header("Location: index.php");
	}
} else
{
	if ($invite_code = $_REQUEST['invite_code'])
	{
		$invite = Invite::getFromCode($invite_code);
	}
	if (($id == -1 && ALLOW_REGISTRATION && (!REQUIRE_INVITE || $invite)) || userRoleIncludes(USER_PERMISSION_EDIT_USER))
	{
		if ($_REQUEST['autogenerate'] == "on")
		{
			// Get random password using random.org which uses atmospheric noise to create high quality "random" numbers
			$password1 = trim(file_get_contents("http://www.random.org/strings/?num=1&len=12&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new"));
			$password2 = $password1;
			$message = "A user account was created for ({$username}) on Agora! Your temporary password is {$password1}.";
		} else
		{
			$password1 = $_POST['password1'];
			$password2 = $_POST['password2'];
			$message = "Thanks for registering with Agora!";
		}
		
		if (validatePassword($password1, $password2))
		{
			$user = new User($username, $password1, getDefaultUserRole(), $_POST['email'], $_POST['first'], $_POST['last'], -1);
			$uid = User::addUser($user);
			$shop_id = 0;
			if ($market->shop)
				$shop_id = $market->shop->id;
			$market->addActivity(new Activity(mysqli_insert_id($con), 0, $shop_id, Activity::ACTIVITY_TYPE_JOIN, "{$username} joined Agora", Activity::PRIVACY_LEVEL_PUBLIC));
			$m_email = $market->getMarketEmail();
			mail($user->email, "Registration", $message, "From: {$m_email}");

			// Add to friends list
			$friend = new Friend($uid, $invite->invited_by);
			Friend::friend($friend);
			if ($market->getUserID() == -1)
				header('Location: login.php');
			else
				header('Location: index.php');
		}
	} else
	{
		header("Location: index.php");
		die();
	}
}
include 'include/footer.php';
?>