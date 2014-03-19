<?
require_once 'data.php';

$page = Page::get($flier->page_id);
?>
<div class="col-md-1">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="page.php>">
				<?=$page->title?>
			</a>
		</div>
		<div class="panel-body">
			<?=($board->abstractOnly) ? $page->getAbstract() : $page->content?>
		</div>
	</div>
</div>
