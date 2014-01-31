<?php
require_once 'settings.php';
require_once 'data.php';
require_once 'data/shop.php';

function shopRegisterFormView()
{
?>
		<form class="form-horizontal" action="registershop.php" method="post">
		<fieldset>
			<legend>Register</legend>
			<div class="form-group">
				<label class="col-md-4 control-label" for="username">Shop Name</label>
				<div class="col-md-4">
					<input id="shopname" name="shopname" type="text" placeholder="Shop Name" class="form-control input-md">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="url">URL</label>
           	   	<div class="col-md-4">
					<input id="url" name="url" type="text" placeholder="URL" class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="email">Email</label>
           	   	<div class="col-md-4">
					<input id="email" name="email" type="text" placeholder="Email" class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="email">Owner</label>
           	   	<div class="col-md-4">
					<input id="owner" name="owner" type="owner" placeholder="Owner's Username" class="form-control input-md">
            	</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="singlebutton">Register</label>
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
	shopRegisterFormView();
	include 'include/footer.php';
} else
{
	$url = $_POST['url'];	
		
	$shop = new Shop($shopname, $url, -1);
	Shop::addShop($shop);
	$user = getUserByName($_POST['owner']);
	$shop->addUser($user);
	$shop->setUserRole($user, 0);
	header('Location: shop.php?shop="'.$shopname.'"');
}
?>