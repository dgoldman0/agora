<?

require_once 'data.php';

$format = $_REQUEST['format'];
// Change all the format (admin) to layout (admin)
$layout = $_REQUEST['layout'];

if ($iid = $_REQUEST['iid'])
{
	$_item = Item::get($iid);
}

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
			if (isset($_item))
			{
				if ($isAdmin($_item->shop_id))
					$view = "item/edit";
			}
			if (!isset($view))
				$view = "item/list";
			break;
		case "csveditor":
			$view = "item/csvEditor";
			break;
		case "save":
			break;
		case "csvsave":
			break;
		default: 
	}
} else
{
	if ($format == "admin" && isAdmin($_shop->id))
		$view = "item/admin/list";
	else
		$view = "item/list";	
}

if ($format == "modal")
{
	$include = "view/$view.php";
} else
{
	$include = "view/{$root}_base.php";
}
include $include;
