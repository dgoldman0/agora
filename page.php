<?
require_once 'data.php';

// Modify to take care of revision history. Right now it just posts a new page with the same perma, which causes errors
$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($pid = $_REQUEST['pid'])
{
	$_page = Page::get($pid);
}

if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
		case "new":
			$view = "page/admin/edit";
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
					$new = true;
					$page = new Page($_REQUEST['title'], $perma, $shop_id, $_REQUEST['content'], 1);
				} else
				{
					// Update page information
				}
				$errors = Page::validate($page);
				if (sizeof($errors) == 0)
				{
					$pid = $page->write();
					if ($new)
					{
						header("Location: page.php?pid=$pid&sub_action=added");
						die();
					} else
					{
						header("Location: page.php?pid=$pid&sub_action=updated");
						die();
					}
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
	if (isset($_page))
	{
		$view = "page/detailed";
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