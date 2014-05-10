<?

require_once 'data.php';

$objects = ItemPrice::get(null, $_item->id);

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