<?
require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($action = $_REQUEST['action'])
{
} else
{
	if ($layout == "admin" && isAdmin($_shop->id))
		$view = "user_role/admin/list";
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