<?php
require_once 'settings.php';
// Constants
DEFINE("USER_PERMISSION_VIEW_SHOP", 4);
DEFINE("USER_PERMISSION_EDIT_SHOP", 8);
DEFINE("USER_PERMISSION_VIEW_USER", 16);
DEFINE("USER_PERMISSION_EDIT_USER", 32);
DEFINE("USER_PERMISSION_MODULE", 64);
// Should I cache values that will never change like user id?

$con = mysqli_connect(DB_LOCATION, DB_USERNAME, DB_PASSWORD, DB_NAME);
$session = 0;
if ($_COOKIE["session"] != "")
{
	$session = $_COOKIE["session"];
}
// Will be set in database later
function getDefaultUserRole()
{
	return 1;
}
function getUserID()
{
	global $session;
	global $con;
	if ($session != 0)
	{
		$sql = "SELECT user, expires from sessions WHERE id='".$session."';";
		$response = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($response);
		if ($row["expires"] > time())
		{
			return $row["user"];
		}
	}
	return -1;
}
function getServiceURL()
{
	mysqli_query("SELECT url FROM agora;");
	if ($row = mysqli_fetch_array($response))
	{
		return $row['url'];
	}
}
function isLoggedIn()
{
	return getUserID() != -1;
}
function isAdmin($shop = '')
{	global $con;

	$id = getUserID();
	if ($id != -1)
	{
		if ($shop == '')
		{
			// Is the user an administrator
			$sql = "SELECT user_role FROM users WHERE id=".$id." AND user_role=0;";
			$response = mysqli_query($con, $sql);
			return $row = mysqli_fetch_array($response);
		} else
		{
			// Will fix later
			return false;
		}
	}
}
// Move tese into User class
function userRoleIncludes($capability)
{
	global $session;
	global $con;
	$id = getUserID();
	if ($id != -1)
	{
		// Is the user an administrator
		$sql = "SELECT user_role FROM users WHERE id=".$id." AND user_role=0;";
		$response = mysqli_query($con, $sql);
		if ($row = mysqli_fetch_array($response))
			return true;

		// If not, does the user's role include the requested permission
		$sql = "SELECT capability FROM user_role_capabilities WHERE capability=".$capability.";";
		$response = mysqli_query($con, $sql);
		return $row = mysqli_fetch_array($response);
	}
}
// Combine this with userRoleIncludes: If no shop is specified, assume root
function shopUserRoleIncludes($shop, $capability)
{
	global $session;
	global $con;
	$id = getUserID();
	if ($id != -1)
	{
		$sql = "SELECT capability, (SELECT user_role FROM users WHERE id=".$id.") as user_role FROM user_role_capabilities WHERE capability=".$capability." OR user_role = 0;";
		$response = mysqli_query($con, $sql);
		if (!($row = mysqli_fetch_array($result)))
			return $row['user_role' == 0];
		return false;
	}
}
function getUserInfo($user, $shop = 0)
{
	global $con;
	$response = null;
	if ($shop == 0)
	{
		$response = mysqli_query($con, "SELECT * from users WHERE id=".$user.";");
	} else
	{
		$response = mysqli_query($con, "SELECT * FROM shop_users WHERE id=".$user." AND shop_id=".$shop.";");
	}
	return mysqli_fetch_array($response);
}
function getUserList($shop = 0)
{
	global $con;
	$response = null;
	if ($shop == 0)
	{
		$response = mysqli_query($con, "SELECT id FROM users;");
	} else
	{
		$response = mysqli_query($con, "SELECT id FROM shop_users WHERE shop_id = ".$shop.";");
	}
	$users = array();
	while ($row = mysqli_fetch_array($response))
	{
		array_push($users, ($row['id']));
	}
	return $users;
}
function validatePassword($pass1, $pass2)
{
	// Will require more complex features such as, at least one number, etc, etc, etc
	return $pass1 == $pass2;
}
?>
