<?php
require_once 'data.php';
require_once 'administration.php';

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
				<?php displayAdminPanel();?>
				<div class = "col-md-10">
					<div class="panel panel-default">
						<div class="panel-heading">
							User Management
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tr><th>Username</th><th>First</th><th>Last</th>Email<td>Role</td></tr>
								<?php
								$users = getUserList();
								foreach ($users as $user)
								{
									$info = getUserInfo($user);
									echo '<tr><td>'.$info['username'].'</td><td>'.$info['first'].'</td><td>'.$info['last'].'</td><td>'.$info['email'].'</td><td>'.$info['user_role'].'</td></tr>';
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