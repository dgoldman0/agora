<?php
// Turn this into a global include file
require_once 'settings.php';
require_once 'data/baseobject.php';
require_once 'data/item.php';
require_once 'data/shop.php';
require_once 'data/activity.php';
require_once 'data/bag.php';
require_once 'data/cart.php';
require_once 'data/page.php';
require_once 'data/user.php';
require_once 'data/invite.php';
require_once 'data/friend.php';

DEFINE("USER_PERMISSION_VIEW_SHOP", 4);
DEFINE("USER_PERMISSION_EDIT_SHOP", 8);
DEFINE("USER_PERMISSION_VIEW_USER", 16);
DEFINE("USER_PERMISSION_EDIT_USER", 32);
DEFINE("USER_PERMISSION_EDIT_SHOP", 64);
DEFINE("USER_PERMISSION_MODULE", 128);
DEFINE("USER_PERMISSION_EDIT_ITEMS", 256);
DEFINE("USER_PERMISSION_EDIT_PAGES", 512);

// Should I cache values that will never change like user id?

$con = mysqli_connect(DB_LOCATION, DB_USERNAME, DB_PASSWORD, DB_NAME);
$session = 0;
// Need to add a code snippet which will delete expired cookies now and then
if ($_COOKIE["session"] != "")
{
	$session = $_COOKIE["session"];
	// Reset expiration timer
	$expires = time()+3600;
	setcookie("session", $session, $expires);
	$con->query("UPDATE sessions SET expires='".$expires."' WHERE id='$session';");
	$response = $con->query("SELECT user FROM sessions WHERE id='$session'");
	if ($row = $response->fetch_array())
	{
		$current_user = User::get($row['user']);
	}
}

BaseObject::$con = $con;

// If a shop is specified, use that shop, if not, use the root shop
$shop = $_REQUEST['shop'];
if (!isset($shop))
{
	$shop = 0;
}
$_shop = Shop::get($shop);

// Will be set in database later
function getDefaultUserRole()
{
	return 1;
}

$user = $_REQUEST['user'];
if (isset($user))
	$_user = User::get($user);

function getServiceURL()
{
	global $con;
	$response = mysqli_query($con, "SELECT url FROM shops WHERE id=0;");
	if ($row = mysqli_fetch_array($response))
	{
		return $row['url'];
	}
}
function isLoggedIn()
{
	return isset($_user);
}

function isAdmin($shop = 0)
{
	return false;
}
/*
function isAdmin($shop = 0)
{
	$con = BaseObject::$con;

	$id = getUserID();
	if ($id != -1)
	{
		if ($shop == 0)
		{
			// Is the user an administrator
			$sql = "SELECT user_role FROM users WHERE id=$id AND user_role=0;";
			$response = mysqli_query($con, $sql);
			return $row = mysqli_fetch_array($response);
		} else
		{
			// Will fix later
			return false;
		}
	}
}
*/
/* Move these into User or Market class
 * A copy is now in the Market class. Wherever you see use of this function,
 * change the call to $market->userRoleIncludes 
 */
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

// User::getUserByUsername & Username::getUserByID can replace this
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
// Duplicated in Market
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
// Will fill in the details later
function validateEmail($email)
{
	return $email != "";
}
function toURLSafe($str)
{
	return preg_replace('/[^\w]+/', '_', strtolower($str));
}