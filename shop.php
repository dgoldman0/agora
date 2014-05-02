<?

require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
			if ($layout == "admin" && isAdmin($_shop->id))
				$view = "shop/admin/edit";
			break;
		case "save":
			if (isAdmin($_shop->id))
			{
				$_shop->stylized = $_REQUEST['shopname'];
				$_shop->name = urlencode($_shop->stylized);
				$_shop->short_desc = $_REQUEST['short_desc'];
				$_shop->url = $_REQUEST['url'];
				$id = $_shop->write();
				if (isset($id))
					header("location: shop.php?layout=admin&sid=$id");
				else;
			}
			die();
			break;
		default: 
	}
} else
{
	if ($layout == "admin" && isAdmin($_shop->id))
	{
		$view = "shop/admin/list";
	}
	else
	{
		if (isset($_REQUEST['sid']))
			$view = "shop/home";
		else
			$view = "shop/list";	
	}
}

if ($format == "modal")
{
	$include = "view/$view.php";
} else
{
	$include = "view/_base.php";
}
include $include;
