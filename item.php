<?

require_once 'data.php';

$format = $_REQUEST['format'];
// Change all the format (admin) to layout (admin)
$layout = $_REQUEST['layout'];

if ($iid = $_REQUEST['iid'])
{
	$_item = Item::get($iid);
	$_shop = Shop::get($_item->shop_id);
}

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
			if (isAdmin($_shop->id))
				$view = "item/admin/edit";
			break;
		case "csveditor":
			if (isAdmin($_shop->id))
				$view = "item/admin/csv_editor";
			break;
		case "save":
			if (!isset($_item))
			{
				$_item = new Item();
			}
			$_item->shop_id = $_shop->id;
			$_item->name = $_REQUEST['name'];
			$_item->sku = $_REQUEST['sku'];
			$_item->short_desc = $_REQUEST['short_desc'];
			$_item->long_desc = $_REQUEST['desc'];
			if ($id = $_item->write())
				header("location: item.php?iid=$id");
			else
				echo BaseObject::$con->error;
			die();
			break;
		case "csvsave":
			break;
		default: 
	}
} else
{
	if (!isset($_item))
	{
		if ($layout == "admin" && isAdmin($_shop->id) && !isset($format))
			$view = "item/admin/list";
		else
			$view = "item/list";
	} else
	{
		$view = "item/detailed";
		if (isset($_current_user))
		{
			if ($cid = $_REQUEST['cid'])
			{
				$_cart = Cart::get($cid);
			} else
			{
				$_cart = Cart::getActiveCart($_current_user->id);
			}			
		}
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
