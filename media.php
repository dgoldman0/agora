<?
require_once 'data.php';

// Modify to take care of revision history. Right now it just posts a new page with the same perma, which causes errors
$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
			if ($layout == "admin" && isAdmin($_shop->id))
				$view = "media/admin/edit";
			break;
		case "save":
			if (!isset($_media))
			{
				$_media = new Media();
			}
			if (isset($_REQUEST['shop_id']))
				$_media->shop_id = $_REQUEST['shop_id'];
			else
				$_media->shop_id = $_shop->id;
			
			$_media->title = $_REQUEST['title'];
			$_media->alt_text = $_REQUEST['alt_text'];
			$_media->long_desc = $_REQUEST['long_desc'];
			$_media->url = $_REQUEST['url'];
			if ($id = $_media->write())
				header("location: media.php?mid=$id");
			else
				echo BaseObject::$con->error;
			break;
			die();
		default:
	}
} else {
	if ($layout == "admin" && isAdmin($_shop->id))
	{
		$view = "media/admin/list";
	} else {
		$view = "media/detailed";
	}
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
