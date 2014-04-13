<?
require_once 'data.php';

function printShop($shop)
{
?>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="shop.php?shop=<?=$shop->name?>"><?=$shop->stylized?></a>
			</div>
			<div class="panel-body">
				<p><?=$shop->short_desc?></p>
			</div>
		</div>
	</div>	
<?
}
function printShopItems($shop)
{
	?>
	<div class="col-md-9 container">
	<?
	$items = Item::get(null, $shop->id);
	foreach ($items as $item)
	{
	?>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?=$item->name?>
				</div>
				<div class="panel-body">
					<?=$item->short_desc?>
				</div>
			</div>
		</div>
	<?
	}
	?>	
	</div>
	<?
}

printShop($_shop);
printShopItems($_shop);