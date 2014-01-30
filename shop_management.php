<?php
require_once 'data.php';
require_once 'administration.php';
require_once 'shop.php';

// View
function shopConfigView($shop = "")
{
	echo "<!DOCTYPE html><html><head>";
	include 'include.php';
	echo '</head><body><div class="container">';
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
							Shop Management
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tr><th>Shop Name</th><th>Creator</th><th>URL</th><th colspan="2">Stuff</th></tr>
								<?php
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
	echo '</div></body></html>';
}
shopConfigView($_POST["store"]);
?>