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
				$_shop = Shop::get($_item->shop_id);
				if ($isAdmin($_shop->id))
					$view = "item/admin/edit";
			}
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
	if (!isset($_item))
	{
		if ($layout == "admin" && isAdmin($_shop->id) && !isset($format))
			$view = "item/admin/list";
		else
			$view = "item/list";
	} else
	{
		$view = "item/detailed";
		if ($cid = $_REQUEST['cid'])
		{
			$_cart = Cart::get($cid);
		} else
		{
			$_cart = Cart::getActiveCart($_current_user->id);
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
