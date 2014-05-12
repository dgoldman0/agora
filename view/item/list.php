<?

require_once 'data.php';

$items = Item::get(null, $_shop->id);

switch ($format)
{
	case "json":
		echo jsonResponse($items);
		break;
	case "csv":
		echo str_putcsv($items);
		break;
	default:
	?>
	<?
}