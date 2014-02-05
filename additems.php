<?php
require_once 'data.php';
require_once 'administration.php';
require_once 'data/shop.php';
require_once 'data/user.php';
require_once 'data/item.php';

if (userRoleIncludes(USER_PERMISSION_EDIT_ITEMS))
{
	include 'include/header.php';
	include 'menu.php';
	$shop = $_GET['shop'];
	if ($shop == "")
	{
		$shop = $_POST['shop'];
	}
	if ($shop == "")
	{
		// Display master item management
	} else
	{
		$shop = Shop::getShopFromName(toURLSafe($shop));
		echo '<div class="row">';
		displayShopAdminPanel();
		?>
		<div class = "col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php
					if ($_GET['multiple'] == 'yes')
					{
						echo 'Select File';	
					} else
					{
						echo 'Add Item';
					}
					?>
				</div>
				<div class="panel-body">
					<?php
					if ($_GET['multiple'] == 'yes')
					{
						?>
						<form class="form-horizontal" action="additem.php?shop=<?php echo $shop->name;?>&multiple=yes" method="post">
							<fieldset>
								<div class="form-group">
    	    						<div class="col-md-6">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="input-group">
										   		<div class="form-control uneditable-input span3" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
										 		<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="filename"></span>
										   		<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
										</div>
 	    							</div>
								</div>
								<div class="form-group">
									<div class="col-md-6">
										<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</fieldset>
						</form>
						<?php
					} else
					{
						$name = $_POST['name'];
						if ($name == "")
						{
							?>
							<form class="form-horizontal" action="additems.php?shop=<?php echo $shop->name;?>" method="post">
								<fieldset>
									<div class="form-group">
										<label class="col-md-2 control-label" for="name">Item Name</label>
					           	   		<div class="col-md-10">
											<input id="name" name="name" type="text" placeholder="Item Name" class="form-control input-md">
	            						</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="sku">SKU</label>
					           	   		<div class="col-md-10">
											<input id="sku" name="sku" type="text" placeholder="SKU" class="form-control input-md">
	            						</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="short_desc">Short Description</label>
					           	   		<div class="col-md-10">
											<input id="short_desc" name="short_desc" type="text" placeholder="Short Description (156 characters or less)..." class="form-control input-md">
	            						</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="desc">Description</label>
										<div class="col-md-10">
											<textarea rows="16" id="desc" name="desc" class="form-control"></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2"></div>
										<div class="col-md-2">
											<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</fieldset>
							</form>
							<?php
						} else
						{
							$item = new Item($shop->id, $name, $_POST['sku'], $_POST['short_desc'], $_POST['desc'], -1);
							$shop->addItem($item);
							header("Location: item.php?shop=".$shop->name."&item=".$item->sku);
							die();
						}
					}
					?>
				</div>
			</div>
		</div>
		<script>
			tinymce.init({
				selector: "textarea",
				plugins: [
					"advlist autolink lists link image charmap print preview anchor",
					"searchreplace visualblocks code fullscreen",
					"insertdatetime media table contextmenu paste"
				],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				autosave_ask_before_unload: false});
		</script>
		<?php
		include 'include/footer.php';
	}
}
?>