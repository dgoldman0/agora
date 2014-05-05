<?
require_once 'data.php';
?>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="user.php?user=<?=$_user->username?>"><?=$_user->username?></a>
			</div>
			<div class="panel-body">
				<legend>Info</legend>
				<div class="col-md-6"><p><?=$_user->first?> <?=$_user->last?></p></div>
				<div class="col-md-6">
					<div class="btn-toolbar" role="toolbar">
						<div class="btn-group btn-group-xs">
							<button id="profile_friend_<?=$_user->id?>" class="btn btn-primary">Friend</button>
							<button id="profile_message_<?=$_user->id?>" class="btn btn-primary">Message</button>
						</div>
					</div>
				</div>
				<legend>Badges</legend>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				Public Feed
			</div>
			<div class="panel-body">
				<?
//				$activity = $market->getActivity(array("from_id" => $_user->id, "order" => "desc"));
				foreach ($activity as $act)
				{
					if ($act->type == Activity::ACTIVITY_TYPE_NOTICE)
					{
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<?=$act->created_on?>
							</div>
							<div class="panel-body">
								<?=$act->content?>
							</div>
						</div>
						<?
					} else if ($act->type == Activity::ACTIVITY_TYPE_LIKE)
					{
						$shop = Shop::getShopFromID($act->shop_id);
						$item = $shop->getItemFromSKU($act->content);
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<?=$act->created_on?>
							</div>
							<div class="panel-body">
								<?=$_user->username?> liked <a href="item.php?shop=<?=$shop->name?>&item=<?=$item->sku?>"><?=$item->name?></a>.
							</div>
						</div>
						<?
					}
				}
				?>
			</div>
		</div>
	</div>
</div>