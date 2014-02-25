<?php
require_once 'data.php';
require_once 'view/json.php';

function printUserA($user)
{
	?>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="user.php?user=<?=$user->username?>">
					<?=$user->username?>
				</a>
			</div>
			<div class="panel-body">
				<p><?=$user->first?> <?=$user->last?></p>
			</div>
		</div>
	</div>
	<?
}
function printUserB($user)
{
	global $market;
	?>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="user.php?user=<?=$user->username?>"><?=$user->username?></a>
				</div>
				<div class="panel-body">
					<p><?=$user->first?> <?=$user->last?></p>
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
					$activity = $market->getActivity(array("from_id" => $user->id, "order" => "desc"));
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
									<?=$user->username?> liked <a href="item.php?shop=<?=$shop->name?>&item=<?=$item->sku?>"><?=$item->name?></a>.
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
	<?
}
if ($action = $_GET['action'])
{
	if ($action == "gtusrname")
	{
		echo jsonResponse(json_encode(User::getUserByID($_GET['id'])->username));
	}
} else
{
	include 'include/header.php';
	include 'menu.php';
	$market->active="members";
	$username = $_GET['user'];
	if ($username == "")
	{
		// Get user list	
		$users = $market->getUserList(true);
		echo '<div class="row">';
		foreach ($users as $user)
		{
			printUserA($user);
		}
		echo '</div>';
	} else
	{
		// Get single user display
		$user = User::getUserByUsername($username);
		printUserB($user);
	}
	include 'include/footer.php';
}