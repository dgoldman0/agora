<?
require_once 'data.php';

// Modify to take care of revision history. Right now it just posts a new page with the same perma, which causes errors
$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($rid = $_REQUEST['rid'])
	$_review = ItemReview::get($rid);
if ($iid = $_REQUEST['iid'])
	$_item = Item::get($iid);

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
				$_review = new ItemReview();
			} else
			{
				if ($_current_user->id != $_review->id && !isAdmin($_shop->id))
				{
					// Throw error eventually
					$_review = new ItemReview();
				}
			}
			$_review->item_id = $_REQUEST['iid'];
			$_review->reviewer_id = $_current_user->id;
			$_review->title = $_REQUEST['title'];
			$_review->content = $_REQUEST['content'];
			$_review->score = $_REQUEST['score'];
			print_r($_review);
			if ($id = $_review->write())
				header("location: item_review.php?rid=$id");
			else
				echo BaseObject::$con->error;
			break;
			die();
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
