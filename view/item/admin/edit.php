<?
require_once 'data.php';
?>
<form class="form-horizontal" action="item.php?action=save&sid=<?=$_shop->id?>" method="post">
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
			<label class="col-md-2 control-label" for="price">Price</label>
   	   		<div class="col-md-2">
				<input id="price-1" name="price[]" type="text" placeholder="$0.00" class="form-control input-md">
			</div>
			<label class="col-md-1 control-label" for="price">Category</label>
   	   		<div class="col-md-2">
				<select id="pcat-1" name="pcat[]" class="form-control input-md">
					<option value="0">List</option>
				</select>
			</div>
			<label class="col-md-1 control-label" for="price">Currency</label>
   	   		<div class="col-md-2">
				<select id="pcur-1" name="pcur[]" class="form-control input-md">
					<option value="1">USD</option>
				</select>
			</div>
			<a href=""><label class="col-md-1 control-label" for="none">Remove</label></a>
			<a href=""><label class="col-md-1 control-label" for="none">Add</label></a>
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