<?
// View and edit pages
require_once 'administration.php';
require_once 'data/page.php';
include 'include/header.php';
include 'menu.php';

$action = $_GET['action'];
if ($action == "save")
{
	$shop_id = 0;
	if ($market->shop)
		$shop_id = $market->shop->id;
	$page = new Page($_POST['title'], $_POST['perma'], $shop_id, null, $_POST['content'], 1, -1);
	$id = $market->addPage($page);
	header("Location: page.php?id={$id}");
} else
{
	if ($id = $_GET['id'])
		$page = $market->getPageByID($id);
	else if ($perma = $_GET['perma'])
		$page = $market->getPageByPerma($perma);
	if ($page)
	{
		?>
		<div class="jumbotron">
			<h1><?=$page->title?></h1>
		</div>
		<div class="container">
			<?=$page->contents?>
		</div>
		<?
	} else
	{
		?>
		<div class="row">
			<?displayAdminPanel();?>
			<div class="col-md-10">
				<form class="form-horizontal" action="page.php?action=save" method="post" id="register-form">
					<fieldset>
						<legend>New Page</legend>
						<input type="text" name="title" class="form-control input-md" placeholder="Title" style="margin-bottom: 5px;">
						<textarea name="content"></textarea>
					</fieldset>
				</form>
			</div>
		<script>
			tinymce.init({
				selector: "textarea",
				plugins: [
					"save advlist autolink lists link image charmap print preview anchor",
					"searchreplace visualblocks code fullscreen",
					"insertdatetime media table contextmenu paste"
				],
				toolbar: "save | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				autosave_ask_before_unload: false});
		</script>
		<?
	}
}
include 'include/footer.php';
?>