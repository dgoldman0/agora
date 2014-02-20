<?
require_once 'data.php';
require_once 'data/shop.php';
require_once 'data/item.php';

function printItem($item)
{
	global $shop;
	?>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="item.php?shop=<?=$shop->name?>&item=<?=$item->sku?>"><?=$item->name?></a>
			</div>
			<div class="panel-body">
				<p><?=$item->short_desc?></p>
			</div>
		</div>
	</div>
	<?
}

function displayStore($shop)
{
	    echo '<div class="jumbotron">';
		echo $shop->short_desc;
	    echo '</div>';
		$items = $shop->getItemList(true);
		echo '<div class="row">';
		foreach ($items as $item)
		{
			printItem($item);
		}
		echo '</div>';
}