<?php
require_once 'data.php';
require_once 'administration.php';

function moduleConfigurationView($module = "")
{
	echo "<!DOCTYPE html><html><head>";
	include 'include.php';
	echo '</head><body><div class="container">';
	if ($module == "")
	{
		// Module Configuration - Main Screen
		
		// Check to see if data is set correctly...
		if (userRoleIncludes(USER_PERMISSION_MODULES))
		{
			include 'menu.php';
			$controlscript = '
			$( "#checkall" ).click(function() {
				$( ".modulecheck" ).prop("checked", $( "#checkall" ).prop("checked"));
			});
			';
			?>
			<div class="row">
				<?php displayAdminPanel();?>
				<div class = "col-md-10">
					<div class="panel panel-default">
						<div class="panel-heading">
  <nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/index.php">Modules</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Add Module</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
        <ul class="dropdown-menu">
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tr><th><input type="checkbox" id="checkall"></th><th>Module</th><th>Version</th><th>Description</th><th>Author</th><th>Site</th><th>Activity/Uninstall</th></tr>
								<?php
								// Get a list of all modules
								$dirs = scandir('modules/');
								foreach ($dirs as $dir)
								{
									if ($dir != '.' && $dir != '..' && $dir != '...')
									{
										$dir = 'modules/'.$dir;
										{
											if (is_dir($dir))
											{
												// Check for *.mdx
												$dirs2 = glob($dir.'/*.{mdx}', GLOB_BRACE);
												if ($mdx = $dirs2[0])
												{
													
												}
											}
										}
									}
								}
//								echo '<tr><td>'.$info['username'].'</td><td>'.$info['first'].'</td><td>'.$info['last'].'</td><td>'.$info['email'].'</td><td>'.$info['user_role'].'</td></tr>';
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<script><?php echo $controlscript?></script>
			<?php
		} else
		{
			// Access denied
			echo "Access Denied";
		}
	} else
	{
		// Individual User Configuration
		if (userRoleIncludes(USER_PERMISSION_MODULES) || shopUserRoleIncludes($shop, S_USER_PERMISSION_MODULES))
		{
			
		} else
		{
			// Access denied
			echo "Shop Access Denied";
		}
	}
	echo '</div></body></html>';
}
moduleConfigurationView();
?>