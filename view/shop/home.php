<?
require_once 'data.php';

function printShop($shop)
{
?>
	<div class="col-md-4">
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
