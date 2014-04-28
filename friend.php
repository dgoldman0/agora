<?
require_once 'data.php';

$format = $_REQUEST['format'];

if ($action = $_REQUEST['action'])
{
	// Search for possible friends
	if ($action == "search")
	{
		$view = "friend/search";
	}
} else
{
	$view = "friend/list";
}

switch ($format)
{
	case "modal":
	case "csv":
	case "json":
		$include = "view/$view.php";
		break;
	default:
		$include = "view/_base.php";
}

if (isset($include))
	include $include;
