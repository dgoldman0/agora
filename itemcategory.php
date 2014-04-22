<?

require_once 'data.php';

$uid = $_REQUEST['uid'];
$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
			$view = "itemcategory/edit";
			break;
		default: 
	}
} else
{
	if ($layout == "admin" && isAdmin($_shop->id))
		$view = "itemcategory/admin/list";
	else
		$view = "itemcategory/list";	
}

if ($format == "modal")
{
	$include = "view/$view.php";
} else
{
	$include = "view/{$root}_base.php";
}
include $include;
