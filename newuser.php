<?php
require_once 'data.php';
require_once 'administration.php';

if ($user = $_POST['user'])
{
	echo "<!DOCTYPE html><html><head>";
	include 'include.php';
	echo '</head><body><div class="container">';
	include 'menu.php';
	?>
	<div class="row">
		<?php displayAdminPanel();?>
		<div class = "col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					Add User
				</div>
				<div class="panel-body">
				
				</div>
			</div>
		</div>
	</div>
	<?php
	echo '</div></body></html>';
}
?>