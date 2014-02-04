<?php
require_once 'data.php';
require_once 'administration.php';
require_once 'data/user.php';

// Move this to include/user.php
function userConfigurationView($user = "")
{
	global $market;
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
								<tr><th><input id="checkall_master" type="checkbox" class="form-control input-md"></th><th>Username</th><th>First</th><th>Last</th><th>Email</th><th>Role</th></tr>
								<?php
								// Change this to Market->getUserList(true)
								$users = $market->getUserList(true);
								foreach ($users as $user)
								{
									?>
									<tr>
										<td>
											<input id="check_<?=$user->id?>" type="checkbox" class="form-control input-md checkall_slave">
										</td>
										<td>
											<a href="user.php?user=<?=$user->username?>&edit=true"><?=$user->username?></a>
										</td>
										<td>
											<?=$user->first?>
										</td>
										<td>
											<?=$user->last?>
										</td>
										<td>
											<?=$user->email?>
										</td>
										<td>
											<?=$user->user_role?>
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