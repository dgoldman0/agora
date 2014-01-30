<?php
require_once 'settings.php';
require_once 'data.php';
require_once 'shop_management.php';

$shopname = $_POST['shopname'];

if ($shopname == '')
{
?>
<!DOCTYPE html>
<html><head><title>Register a Shop with Agora</title><?php include 'include.php'?></head><body>
<div class="container">
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
				<label class="col-md-4 control-label" for="singlebutton">Register</label>
				<div class="col-md-2">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</fieldset>
	</form>
</div></body></html>
<?php
} else
{
	$name = $_POST['name'];
	$url = $_POST['url'];	
	
	$shop = new Shop($name, $url, -1);
	Shop::addShop($shop);
	header('Location: shop.php?shop="'.$name.'"');
}
?>