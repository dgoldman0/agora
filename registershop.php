<?php
require_once 'settings.php';
require_once 'data.php';
require_once 'administration.php';
require_once 'data/shop.php';
require_once 'data/user.php';

function shopRegisterFormView()
{
?>
		<form class="form-horizontal" action="registershop.php" method="post">
		<fieldset>
			<legend>Register</legend>
			<div class="form-group">
				<label class="col-md-2 control-label" for="username">Shop Name</label>
				<div class="col-md-4">
					<input id="shopname" name="shopname" type="text" placeholder="Shop Name" class="form-control input-md">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="short_desc">Description</label>
				<div class="col-md-4">
					<textarea rows="4" id="short_desc" name="short_desc" class="form-control"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="url">URL</label>
           	   	<div class="col-md-4">
					<input id="url" name="url" type="text" placeholder="URL" class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="email">Email</label>
           	   	<div class="col-md-4">
					<input id="email" name="email" type="text" placeholder="Email" class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="owner">Owner</label>
           	   	<div class="col-md-4">
					<input id="owner" name="owner" type="owner" placeholder="Owner's Username" class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="singlebutton">Register</label>
				<div class="col-md-2">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</fieldset>
	</form>
<?php
}

$shopname = $_POST['shopname'];

if ($shopname == '')
{
	include 'include/header.php';
	include 'menu.php';
	if (userRoleIncludes(USER_PERMISSION_ADD_SHOP))
	{
	?>
		<div class="row">
		<?php displayAdminPanel();?>
			<div class = "col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading">
						Register Shop
					</div>
					<div class="panel-body">
		<?php
		shopRegisterFormView();
		echo '</div></div></div></div>';
	}
	include 'include/footer.php';
} else
{
	if (!checkAllowsUserRegistration() && userRoleIncludes(USER_PERMISSION_ADD_SHOP))
	{
		header("Location: index.php");
		die();
	}
	$url = $_POST['url'];	
	$short_desc = $_POST['short_desc'];
	$stylized = $shopname;
	$shopname = toURLSafe($shopname);
	
	$shop = new Shop($shopname, $stylized, $short_desc, $url, -1);
	Shop::addShop($shop);
	$user = User::getUserByUsername(toURLSafe($_POST['owner']));
	$shop->addUser($user);
	$shop->setUserRole($user, 0);
	header('Location: shop.php?shop='.$shopname);
}
?>