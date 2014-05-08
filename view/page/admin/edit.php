<?

require_once 'data.php';

$placeholder = "New Page";
$content = "";
$legend = "New Page";
if (isset($_page))
{
	$title = $_page->title;
	$placeholder = "";
	$content = $_page->content;
	$legend = "Edit Page";
	$final = "&pid={$_page->id}";
}
function javascripts()
{
	?>
	<script type = "text/javascript">
		$(document).ready(function() {
			tinymce.init({
			selector: "textarea",
			plugins: [
				"save advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"
			],
			toolbar: "save | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			autosave_ask_before_unload: false});
		});
	</script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<?
}
if ($format == "modal")
{
	?>
	<style type = "text/css">
		#editor_block {margin: 5px;}
	</style>
	<?
}
?>
<div id="editor_block">
	<form class="form-horizontal" action="page.php?action=save<?=$final?>&sid=<?=$_shop->id?>" method="post" id="register-form">
		<fieldset>
			<legend><?=$legend?></legend>
			<input type="text" name="title" class="form-control input-md" placeholder="<?=$placeholder?>" value="<?=$title?>" style="margin-bottom: 5px;">
			<textarea name="content"><?=$content?></textarea>
		</fieldset>
	</form>
</div>
<?if ($format == "modal") {?>
	<script type = "text/javascript">
		$(document).ready(function() {
			tinymce.init({
			selector: "textarea",
			plugins: [
				"save advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"
			],
			toolbar: "save | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			autosave_ask_before_unload: false});
		});
	</script>
<?
}