<?
require_once 'data.php';

// Modify to take care of revision history. Right now it just posts a new page with the same perma, which causes errors
$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($rid = $_REQUEST['rid'])
{
	$_review = ItemReview::get($rid);
}
if ($action = $_REQUEST['action'])
{
	switch ($action)
	{
		case "edit":
		case "new":
			$view = "item_review/edit";
			break;
		case "save":
			if (!isset($_review))
			{
				$_review = new Review();
			}
			$_review->title = $_REQUEST['title'];
			$_review->content = $_REQUEST['content'];
			$_review->rating = $_REQUEST['rating'];
			break;
		default:
	}
} else
{
	if ($layout == "admin" && isAdmin($_current_user->id))
		$view = "item_review/admin/list";
	else
	{
		if (!isset($_review))
			$view = "item_review/list";
		else
			$view = "item_review/detailed";
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
