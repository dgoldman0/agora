<?php
require_once 'data.php';
require_once 'administration.php';
require_once 'data/shop.php';
require_once 'data/user.php';
require_once 'data/item.php';

if (userRoleIncludes(USER_PERMISSION_EDIT_ITEMS))
{
	include 'include/header.php';
	include 'menu.php';
	$shop = $_GET['shop'];
	if ($shop == "")
	{
		$shop = $_POST['shop'];
	}
	if ($shop == "")
	{
		// Display master item management
	} else
	{
		$shop = Shop::getShopFromName(toURLSafe($shop));
		$items = $shop->getItemList(true);
		echo '<div class="row">';
		displayShopAdminPanel();
		?>
		<div class = "col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<nav class="navbar navbar-default" role="navigation">
					  <!-- Brand and toggle get grouped for better mobile display -->
					  <div class="navbar-header">
					    <a class="navbar-brand" href="#">Item Management</a>
					  </div>
					
					  <!-- Collect the nav links, forms, and other content for toggling -->
					  <div class="collapse navbar-collapse" id="shop-navigation">
					    <ul class="nav navbar-nav">
					      <li><a href="additems.php?shop=<?php echo $shop->name;?>">Add Item</a></li>
					      <li><a href="additems.php?shop=<?php echo $shop->name;?>&multiple=yes">Add Multiple</a></li>
					    </ul>
					  </div><!-- /.navbar-collapse -->
					</nav>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
						<tr><th>Item</th><th>SKU</th><th>Description</th><th>Price</th></tr>
						<?php
						?>
					</table>
					</div>
				</div>
			</div>
		</div>
		<?php		
	}
	include 'footer.php';
} else
{
	header("Location: index.php");
}
?>