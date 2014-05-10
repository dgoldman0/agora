<?

require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($ipid = $_REQUEST['ipid'])
{
	$item_price = ItemPrice::get($icid);
}

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
			$view = "item_price/admin/edit";
			break;
		case "save":
			if (!isset($ipid))
				$item_price = new ItemPrice();
			
			$item_price->item_id = $_REQUEST['item_id'];
			if (!($item_price->price_category = $_REQUEST['price_category']))
				$item_price->price_category = 0;
			if (!($item_price->currency = $_REQUEST['currency']))
				$item_price->currency = 0;
			$item_price->value = $_REQUEST['value'];
			if ($ipid = $item_price->write())
				header("location: item_price.php?layout=admin&sid=$_shop->id");
			break;
		default: 
	}
} else
{
	if ($iid = $_REQUEST['iid'])
	{
		if ($_item = Item::get($iid))
		{
			if ($layout == "admin" && isAdmin($_shop->id))
				$view = "item_price/admin/list";
			else
				$view = "item_price/list";
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