<?

require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($icid = $_REQUEST['icid'])
{
	$item_category = ItemCategory::get($icid);
}

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
			$view = "item_category/admin/edit";
			break;
		case "save":
			if (!isset($icid))
				$item_category = new ItemCategory();
			
			$item_category->name = $_REQUEST['name'];
			$item_category->shop_id = $_shop->id;
			$item_category->parent = $_REQUEST['parent'];
			if ($icid = $item_category->write())
				header("location: item_category.php?layout=admin&sid=$_shop->id");
			break;
		default: 
	}
} else
{
	if ($layout == "admin" && isAdmin($_shop->id))
		$view = "item_category/admin/list";
	else
		$view = "item_category/list";	
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