<?php
require_once 'data/shop.php';
require_once 'data.php';

function displayAdminPanel()
{
	?>
	<div class="col-md-2">
		<ul class="nav nav-list bs-docs-sidenav affix">
			<li class="sidebar-brand">Administration</li>
			<li class="active"><a href="user_management.php">Users</a></li>
			<li class="active"><a href="shop_management.php">Shops</a></li>
			<li class="active"><a href="module_management.php">Modules</a></li>
		</ul>
	</div>
	<?php
}
function displayShopAdminPanel()
{
	$shop = $_GET['shop'];
	if ($shop == "")
	{
		$shop = $_POST['shop'];
	}
	if (!$shop == "")
	{
		$shop = Shop::getShopFromName(toURLSafe($shop));
	}
	?>
	<div class="col-md-2">
		<ul class="nav nav-list bs-docs-sidenav affix">
			<li class="sidebar-brand">Administration</li>
			<?php
			if ($shop == null)
			{
				echo '<li class="active"><a href="item_management.php">Items</a></li>';
			} else
			{
				echo '<li class="active"><a href="item_management.php?shop='.($shop->name).'">Items</a></li>';
			}
			?>
		</ul>
	</div>
	<?php
}
?>