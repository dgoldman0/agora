<?php
require_once 'data.php';

$role = $_REQUEST['role'];
if ($role == "admin")
{
	// Check if actually admin	
	$root = "admin/";
}

if ($action = $_REQUEST['action'])
{
	if ($action == "gtusrname")
	{
//		echo jsonResponse(json_encode(User::getUserByID($_GET['id'])->username));
	} else if ($action == "register")
	{
		$view="user/edit";
		// Not done!
		if ($username == '')
		{
			$id = getUserID();
			if (($id == -1 && ALLOW_REGISTRATION) || userRoleIncludes(USER_PERMISSION_EDIT_USER))
			{
				if ($id != -1)
				{
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
	} else if ($action == "login")
	{
		
	}
} else
{
	$username = $_REQUEST['user'];
	$id = $_REQUEST['id'];
	if ($username || $id)
	{
		if ($username)
		{
			$user = User::getUserByUsername($username);
		} else
		{
			$user = User::getUserByID($id);
		}
		$view = "user/profile";
	}
	else
	{
		$view = "user/list";
	}
}

$include = "view/{$root}_base.php";
include $include;