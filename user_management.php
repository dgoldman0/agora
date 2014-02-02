<?php
require_once 'data.php';
require_once 'administration.php';
require_once 'data/user.php';

// Move this to include/user.php
function userConfigurationView($user = "")
{
	include 'include/header.php';
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
  <nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <a class="navbar-brand" href="/index.php">User Management</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="user-navigation">
    <ul class="nav navbar-nav">
      <li><a href="register.php">Add User</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tr><th><input id="checkall_master" type="checkbox"></th><th>Username</th><th>First</th><th>Last</th><th>Email</th><th>Role</th></tr>
								<?php
								$users = getUserList();
								foreach ($users as $user)
								{
									$info = getUserInfo($user);
									echo '<tr><td><input id="check_'.$info['id'].'" type="checkbox" class="checkall_slave"></td><td>'.$info['username'].'</td><td>'.$info['first'].'</td><td>'.$info['last'].'</td><td>'.$info['email'].'</td><td>'.$info['user_role'].'</td></tr>';
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
	include 'include/footer.php';
}
userConfigurationView();
?>