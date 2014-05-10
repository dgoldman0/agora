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
<form role="form" class="form-horizontal" action="item_category.php?action=save" method="post">
	<fieldset>
		<legend>Category</legend>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="name">Category Name</label>
   	   		<div class="<?=$ics?>">
				<input id="name" name="name" type="text" placeholder="Category Name" class="form-control input-md">
			</div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="parent">Parent Category</label>
   	   		<div class="<?=$ics?>">
   	   			<select name="parent" id = "parent">
   	   				<?
   	   				$categories = ItemCategory::get(null, $_shop->id);
					foreach ($categories as $category)
					{
						?>
						<option value="<?=$category->id?>"><?=$category->name?></option>
						<?
					}
   	   				?>
   	   			</select>
			</div>
		</div>
		<div class="form-group">
			<div class="<?=$lcs?>"></div>
			<div class="<?=$lcs?>">
				<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</fieldset>
	<input type="hidden" name = "sid" value = "<?=$_shop->id?>">
</form>