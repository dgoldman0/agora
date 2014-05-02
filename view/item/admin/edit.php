<?
require_once 'data.php';

if ($format == "modal")
{
	$lcs = "col-md-3";
	$ics = "col-md-8";
}
else
{
	$lcs = "col-md-2";
	$ics = "col-md-4";
}
?>
<form role="form" class="form-horizontal" action="item.php?action=save&sid=<?=$_shop->id?>" method="post">
	<fieldset>
		<legend>Item</legend>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="name">Item Name</label>
   	   		<div class="<?=$ics?>">
				<input id="name" name="name" type="text" placeholder="Item Name" class="form-control input-md">
			</div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="sku">SKU</label>
   	   		<div class="<?=$ics?>">
				<input id="sku" name="sku" type="text" placeholder="SKU" class="form-control input-md">
			</div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="price">Price</label>
   	   		<div class="<?=$lcs?>">
				<input id="price-1" name="price[]" type="text" placeholder="$0.00" class="form-control input-md">
			</div>
			<!--
			<label class="col-md-1 control-label" for="price">Category</label>
   	   		<div class="<?=$lcs?>">
				<select id="pcat-1" name="pcat[]" class="form-control input-md">
					<option value="0">List</option>
				</select>
			</div>
			<label class="col-md-1 control-label" for="price">Currency</label>
   	   		<div class="<?=$lcs?>">
				<select id="pcur-1" name="pcur[]" class="form-control input-md">
					<option value="1">USD</option>
				</select>
			</div>
			<a href=""><label class="col-md-1 control-label" for="none">Remove</label></a>
			<a href=""><label class="col-md-1 control-label" for="none">Add</label></a>
			-->
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="short_desc">Short Description</label>
   	   		<div class="<?=$ics?>">
				<input id="short_desc" name="short_desc" type="text" placeholder="Short Description (156 characters or less)..." class="form-control input-md">
			</div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="desc">Description</label>
			<div class="<?=$ics?>">
				<textarea rows="16" id="desc" name="desc" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="<?=$lcs?>"></div>
			<div class="<?=$lcs?>">
				<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</fieldset>
</form>