<?php
require_once 'data.php';

function getUserInfo()
{
}
function getUserList()
{
}

function userConfigurationView($user = "")
{
	echo "<!DOCTYPE html><html><head>";
	include 'include.php';
	echo '</head><body><div class="container">';
	if ($user == "")
	{
		// User Configuration - Main Screen
		
		// Check to see if data is set correctly...
		if (userRoleIncludes(USER_PERMISSION_VIEW_USER))
		{
			include 'menu.php';
			?>
			<div class="row">
				displayAdminPane();
				<div class = "col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							User Management
						</div>
						<div class="panel-body">
							
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
		// Individual User Configuration
		if (userRoleIncludes(USER_PERMISSION_VIEW_USER) || userShopRoleIncludes(S_USER_PERMISSION_VIEW_USER))
		{
			
		}
	}
	echo '</div></body></html>';}
?>