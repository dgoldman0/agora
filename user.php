<?php
require_once 'data.php';

$uid = $_REQUEST['uid'];
$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($uid)
{
	$user = User::get($uid);
}

if ($action = $_REQUEST['action'])
{
	if ($action == "gtusrname")
	{
//		echo jsonResponse(json_encode(User::getUserByID($_GET['id'])->username));
	} else if ($action == "edit")
	{
		$view = "user/edit";
	} else if ($action == "login")
	{
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		if ($username)
		{
			// Validate Form Data and Check for Security Problems
			$result = mysqli_query($con, "SELECT password=SHA2('{$password}', 512), id FROM users where username='{$username}';");
			$row = mysqli_fetch_array($result);
			$rkeys = array_keys($row);
			if (!$ref = $_REQUEST['ref'])
				$ref = "index.php";

			if ($row[$rkeys[0]] == 1)
			{
				// Login successful
				$first = true;
				$uuid = 0;
				$expires = 0;
				do
				{
						$uuid = uniqid();
						$expires = time()+3600;
						mysqli_query($con, "INSERT INTO sessions VALUES ('{$uuid}', '{$row['id']}', '{$expires}');");
						$first = false;
				} while (mysql_errno() == 1062 || $first);
				// Add cookie
				setcookie("session", $uuid, $expires);
				header("Location: $ref");
				die();
			} else
			{
				$view = "user/login";
				// Fill in error information
			}
		} else {
			$view = "user/login";
		}
	} else if ($action = "logout")
	{
		setcookie("session", "", time() - 3600);
		mysqli_query($con, "DELETE FROM sessions WHERE session='$session';");
		header("Location: index.php");
		die();
	} else if ($action = "save")
	{
		if ($uid = $_REQUEST['uid'])
		{
			$user = User::get($uid);
			$user->first = $_REQUEST['first'];
			$user->last = $_REQUEST['last'];
			$user->email = $_REQUEST['email'];
			// Check passwords match
			if ($_REQUEST['password1'] == $_REQUSET['password2'])
			{
				if ($_REQUEST['pasword1'] != "")
				{
					$user->password = $_REQUEST['password'];
				}
				$errors = User::validate($user);
				if (isset($errors))
				{
					
				} else
				{
					$user->write();
				}
			} else
			{
				$errors = array();
				$errors[] = new Error("Passwords do not match.");
			}
		}
	}
} else
{
	if ($uid)
	{
		$view = "user/profile";
	}
	else
	{
		if ($layout == "admin" && isAdmin($_shop->id))
			$view = "user/admin/list";
		else
			$view = "user/list";
	}
}
if ($format == "modal")
{
	$include = "view/$view.php";
} else
{
	$include = "view/{$root}_base.php";
}
include $include;
