<?php
require_once 'data.php';
require_once 'data/shop.php';
require_once 'administration.php';

// View
function shopConfigView($shop = "")
{
	include 'include/header.php';
	if ($shop == "")
	{
		// Shop Configuration - Main Screen
		
		// Check to see if data is set correctly...
		if (userRoleIncludes(USER_PERMISSION_VIEW_SHOP))
		{
			include 'menu.php';
			?>
			<div class="row">
				<?php displayAdminPanel();?>
				<div class = "col-md-10">
					<div class="panel panel-default">
						<div class="panel-heading">
						  <nav class="navbar navbar-default" role="navigation">
						  <!-- Brand and toggle get grouped for better mobile display -->
						  <div class="navbar-header">
						    <a class="navbar-brand" href="/index.php">Shop Management</a>
						  </div>
						
						  <!-- Collect the nav links, forms, and other content for toggling -->
						  <div class="collapse navbar-collapse" id="shop-navigation">
						    <ul class="nav navbar-nav">
						      <li><a href="registershop.php">Add Shop</a></li>
						    </ul>
						  </div><!-- /.navbar-collapse -->
						</nav>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tr><th><input id="checkall_master" type="checkbox"></th><th>Shop Name</th><th>Description</th><th>URL</th></tr>
								<?php
								$shops = Shop::getShopList(true);
								foreach ($shops as $shop)
								{
									?>
									<tr>
										<td>
											<input id="check_'<?=$shop->id?>" type="checkbox" class="checkall_slave">
										</td>
										<td>
											<?=$shop->stylized?>
										</td>
										<td>
											<?=$shop->short_desc?>
										<td>
											<?=$shop->url?>
										</td>
									</tr>
									<?php
									
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php
		} else
		{
			// Error
		}
	} else
	{
		// Individual Shop Configuration
		if (userRoleIncludes(USER_PERMISSION_VIEW_SHOP) || shopUserRoleIncludes($shop, S_USER_PERMISSION_VIEW_SHOP))
		{
			
		}
	}
	include 'include/footer.php';
}
shopConfigView($_POST["store"]);
?>