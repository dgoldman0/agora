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
			// Access denied
			echo "Access Denied";
		}
	} else
	{
		// Individual User Configuration
		if (userRoleIncludes(USER_PERMISSION_VIEW_USER) || shopUserRoleIncludes($shop, S_USER_PERMISSION_VIEW_USER))
		{
			
		} else
		{
			// Access denied
			echo "Shop Access Denied";
		}
	}
	echo '</div></body></html>';
}
userConfigurationView();
?>