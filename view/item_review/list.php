<?

require_once 'data.php';

if (isset($_item))
	$reviews = ItemReview::get(null, $_item->id);
else if (isset($_current_user))
	$reviews = ItemReview::get(null, null, $_current_user->id);

switch ($format)
{
	case "json":
		$response = array();
		$response['data'] = $reviews;
		echo json_encode($response);
		break;
	case "csv":
		echo str_putcsv($reviews);
		break;
	default:
	?>
	<?
}