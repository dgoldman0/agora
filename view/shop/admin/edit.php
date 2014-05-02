<?
require_once 'data.php';
?>
<form class="form-horizontal" action="shop.php" method="post">
	<fieldset>
		<legend>Register</legend>
		<div class="form-group">
			<label class="col-md-2 control-label" for="username">Shop Name</label>
			<div class="col-md-4">
				<input id="shopname" name="shopname" type="text" placeholder="Shop Name" value = "<?=(isset($_REQUEST['sid'])) ? $_shop->stylized : ""?>" class="form-control input-md">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="short_desc">Description</label>
			<div class="col-md-4">
				<textarea rows="4" id="short_desc" name="short_desc" value = "<?=(isset($_REQUEST['sid'])) ? $_shop->short_desc : ""?>" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="url">URL</label>
          	   	<div class="col-md-4">
				<input id="url" name="url" type="text" placeholder="URL" value = "<?=(isset($_REQUEST['sid'])) ? $_shop->url : ""?>" class="form-control input-md">
           	</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="email">Email</label>
          	   	<div class="col-md-4">
				<input id="email" name="email" type="text" placeholder="Email" value = "<?=(isset($_REQUEST['sid'])) ? $_shop->email : ""?>" class="form-control input-md">
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
		<input type = "hidden" name = "action" value = "save"/>
		<? if (isset($_REQUEST['sid'])):?>
			<input type = "hidden" name = "sid" value = "<?=$_shop->id?>"/>
		<? endif;?>
	</fieldset>
</form>
