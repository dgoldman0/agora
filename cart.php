<?
require_once 'data.php';
require_once 'data/shop.php';

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
	$total = 0;
	?>
	<div class="row">
		<div class="col-xs-10">
			<div class="row">
			<?
			foreach ($bags as $bag_id)
			{
				$bag = $market->getBag($bag_id);
				$total = $total + $bag->item_count;
				$items = $bag->getBagItems();
			?>
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?=Shop::getShopFromID($bag->shop_id)->stylized?>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tr><th><input id="checkall_master" type="checkbox" class="form-control input-md"></th><th>Item</th><th>Quantity</th><th>Unit Price</th></tr>
								<?php
								// Change this to Market->getUserList(true)
								foreach ($items as $bagitem)
								{
									$item = $market->getItemByID($bagitem->item_id);
									?>
									<tr>
										<td>
											<input id="check_<?=$item->id?>" type="checkbox" class="form-control input-md checkall_slave">
										</td>
										<td>
											<?=$item->name?>
										</td>
										<td>
											<input class="item_cnt" id="cnt_<?=$item->id?>" type="text" size="1" placeholder="<?=$bagitem->getItemCount($item->id)?>" class="form-control input-md">
										</td>
										<td>
											
										</td>
									</tr>
									<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
			<?
			}
			?>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					Cart Summary
				</div>
				<div class="panel-body">
					Item Total: <?=$total?>
				</div>
			</div>
		</div>
	</div>
	<?
	include 'include/footer.php';
}
			
?>