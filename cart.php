<?
require_once 'data.php';

// Most of this should be moved. It shouldn't be in the "view"
$action = $_GET['action'];
	
if ($action == "like")
{
} else
{
	include 'include/header.php';
	include 'menu.php';
	if (!$cart_id = $market->current_user->getActiveCart())
	{
		$cart_id = $market->createNewCart(new Cart($market->current_user->id, "", 0, TRUE, -1));
	}
	$cart = $market->getCart($cart_id);
	if (!$bags = $cart->getBags())
	{
		$bag_id = $cart->createNewBag(new Bag(-1, $shop->id, TRUE, -1));
		$bags[] = $bag_id;
	}
	?>
	<div class="row">
	<?
	foreach ($bags as $bag_id)
	{
		$bag = $market->getBag($bag_id);
	?>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?=Shop::getShopFromID($bag->shop_id)->stylized?>
				</div>
				<div class="panel-body">
					Items: <span id="item_count"><?=$bag->item_count?></span>
				</div>
			</div>
		</div>
	<?
	}
	?>
	</div>
	<hr/>
	<?
	include 'include/footer.php';
}
			
?>