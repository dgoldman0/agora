<?

require_once 'data.php';

$objects = ItemCategory::get(null, $_shop->id);

switch ($format)
{
	case "json":
		$data = array();
		$data['data'] = $objects;
		echo json_encode($data);
		break;
	case "csv":
		echo str_putcsv($objects);
		break;
	default:
	?>
	<?
}