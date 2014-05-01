<?php
require_once 'data.php';

$uid = $_REQUEST['uid'];
$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if (isset($uid))
{
	$_user = User::get($uid);
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
			/* I want to use this code instead, but it's not working...
			$stmt = $con->prepare("SELECT password=SHA2('?', 512), id FROM users where username='?';");
			$stmt->bind_param('ss', $password, $username);
			$stmt->execute();
			$row = $stmt->fetch();
			$stmt->close();
			 */
			$password = $con->real_escape_string($password); 
			$username = $con->real_escape_string($username); 
			$result = mysqli_query($con, "SELECT password=SHA2('$password', 512), id FROM users where username='{$username}';");
			$row = $result->fetch_array();
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
	} else if ($action == "logout")
	{
		setcookie("session", "", time() - 3600);
		mysqli_query($con, "DELETE FROM sessions WHERE session='$session';");
		header("Location: index.php");
		die();
	} else if ($action == "save")
	{
		$uid = ($_REQUEST['uid']);
		if (isset($uid))
		{
			$user = User::get($uid);
			if (!isset($user))
			{
				// Unknown user error
				die();
			}
		} else
		{
			$user = new User();
			$user->username = $_REQUEST['username'];
		}
		$user->first = $_REQUEST['first'];
		$user->last = $_REQUEST['last'];
		$user->email = $_REQUEST['email'];
		$user->user_role = $_REQUEST['user_role'];
		if (($auto = $_REQUEST['autogenerate']) && $auto == "on")
		{
			$pass = file_get_contents("https://www.random.org/strings/?num=1&len=10&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new");
			$user->password = $pass;
		} else
		{
			// Check passwords match
			$p1 = $_REQUEST['password1'];
			$p2 = $_REQUEST['password2'];
			if ($p1 == $p2)
			{
				if ($p1 != "")
				{
					$user->password = $p1;
				}
			} else {
				$user->password = null;
			}
		}
		$errors = User::validate($user);
		if (sizeof($errors) > 0)
		{
			print_r($errors);
			die();
		} else
		{
			$user->write();
			if ($auto == "on")
			{
				// Send email to user regarding registration...
			}
			header("Location: user.php?layout=admin&sub_action=updated&uid=$user->id");
		}
	}
} else
{
	if ($layout == "admin" && isAdmin($_shop->id))
		$view = "user/admin/list";
	else
		$view = "user/list";
}
if ($format == "modal")
{
	$include = "view/$view.php";
} else
{
	$include = "view/_base.php";
}
include $include;