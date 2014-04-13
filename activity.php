<?
require_once 'data.php';

$action = $_REQUEST['action'];
$format = $_REQUST['format'];

switch ($action)
{
	case "post":
		// Post new update
		if (isset($_CURRENT_USER))
		{
			$act = new Activity($_CURRENT_USER, null, 0, ACTIVITY_TYPE_UPDATE, $_REQUSET['content'], PRIVACY_LEVEL_FRIEND);
			$act.write();
			if (BaseObject::$con->error == "")
			{
				echo "Success";
			} else
			{
				echo "Error";
			}
		} else
		{
			// Error
		}
		break;
	default:
		$view = "activity/recent";
}

$format = $_REQUEST['format'];
if (!isset($format))
{
	$include = "view/{$root}_base.php";
} else if ($format == "modal")
{
	$include = "view/$view.php";
}
include $include;