<?

require_once 'data.php';

$format = $_REQUEST['format'];

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
			$view = "shop/edit";
			break;
		default: 
	}
} else
{
	if ($_shop->id != 0)
	{
		 $view = "shop/home";
	} else {
		if ($format == "admin" && isAdmin($_shop->id))
			$view = "admin/shop/list";
		else
			$view = "shop/list";	
	}
}

if ($format == "modal")
{
	$include = "view/$view.php";
} else
{
	$include = "view/{$root}_base.php";
}
include $include;
