<?

require_once 'data.php';

$items = Item::get(null, $_shop->id);

switch ($format)
{
	case "json":
		$response = array();
		$response['data'] = $items;
		echo json_encode($response);
		break;
	case "csv":
		echo str_putcsv($items);
		break;
	default:
	?>
	<?
}