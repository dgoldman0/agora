<?
// View and edit pages
require_once 'administration.php';
require_once 'data/page.php';
include 'include/header.php';
include 'menu.php';

$action = $_GET['action'];
// Modify to take care of revision history. Right now it just posts a new page with the same perma, which causes errors
if ($action == "save")
{
	$shop_id = 0;
	if ($market->shop)
		$shop_id = $market->shop->id;
	if (!$perma = $_POST['perma'])
		$perma = toURLSafe($_POST['title']);
	$page = new Page($_POST['title'], $perma, $shop_id, null, $_POST['content'], 1, -1);
	$id = $market->addPage($page);
	header("Location: page.php?id={$id}");
} else
{
	if ($id = $_GET['id'])
		$page = $market->getPageByID($id);
	else if ($perma = $_GET['perma'])
		$page = $market->getPageByPerma($perma);
	$market->active=$perma;
	// Check edit privileges
	if ($page && $action != "edit" || $noedit)
	{
		?>
		<div class="jumbotron">
			<p><?=$page->title?></p>
		</div>
		<div class="container">
			<?=$page->content?>
		</div>
		<?
	} else
	{
		$placeholder = "New Page";
		$content = "";
		$legend = "New Page";
		if ($action == "edit" && $page)
		{
			$title = $page->title;
			$content = $page->content;
			$legend = "Edit Page";
		}
		?>
		<div class="row">
			<?displayAdminPanel();?>
			<div class="col-md-10">
				<form class="form-horizontal" action="page.php?action=save" method="post" id="register-form">
					<fieldset>
						<legend><?=$legend?></legend>
						<input type="text" name="title" class="form-control input-md" placeholder="<?=$placeholder?>" value="<?=$title?>" style="margin-bottom: 5px;">
						<textarea name="content"><?=$content?></textarea>
					</fieldset>
				</form>
			</div>
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