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
<form role="form" class="form-horizontal" action="media.php?action=save&sid=<?=$_shop->id?>" method="post">
	<fieldset>
		<legend>Media</legend>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="title">Title</label>
   	   		<div class="<?=$ics?>">
				<input id="title" name="title" type="text" placeholder="Title" class="form-control input-md"/>
			</div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="alt_text">Alt Text</label>
   	   		<div class="<?=$ics?>">
				<input id="alt_text" name="alt_text" type="text" placeholder="Alt Text" class="form-control input-md"/>
			</div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="long_desc">Description</label>
   	   		<div class="<?=$ics?>">
				<textarea rows="16" id="long_desc" name="long_desc" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="<?=$lcs?> control-label" for="url">URL</label>
   	   		<div class="<?=$ics?>">
				<input id="url" name="url" type="text" placeholder="url" class="form-control input-md"/>
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