<?

require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

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
