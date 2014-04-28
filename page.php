<?
require_once 'data.php';

// Modify to take care of revision history. Right now it just posts a new page with the same perma, which causes errors
$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($pid = $_REQUEST['pid'])
{
	$page = Page::get($pid);
}

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
		case "new":
			$view = "page/edit";
			break;
		case "save":
			if (isAdmin($_current_user->id))
			{
				$shop_id = $_shop->id;
				if (!$perma = $_REQUEST['perma'])
					$perma = toURLSafe($_REQUEST['title']);
				else
					$perma = toURLSafe($perma);
				if (!isset($page))
				{
					$page = new Page($_REQUEST['title'], $perma, $shop_id, $_REQUEST['content'], 1);
				} else
				{
					// Update page information
				}
				$errors = Page::validate($page);
				if (sizeof($errors) == 0)
				{
					$pid = $page->write();
					$page = Page::get($pid);
					$view = "page/admin/list";
				} else
				{
					// Do error stuff
					print_r($errors);
				}
			}
			break;
		default:
	}
} else
{
	if (isset($page))
	{
		$view = "page/view";
	} else
	{
		if ($layout == "admin" && isAdmin($_current_user->id))
			$view = "page/admin/list";
		else
			$view = "page/list";
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