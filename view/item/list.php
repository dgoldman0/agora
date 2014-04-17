<?

require_once 'data.php';

if ($_shop->id != 0)
{
	// Get only items for the specific shop
} else
{
	$items = Item::get();
}

switch ($format)
{
	case "json":
		$data = array();
		$data['data'] = $items;
		echo json_encode($data);
		break;
	case "csv":
		echo str_putcsv($items);
		break;
	default:
	?>
	<script type="text/template" id="item-tmpl">
		<div class="row">
			{{#each}}
			{{/each}}
		</div>
	</script>
	<?
}