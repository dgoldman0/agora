<?
require_once 'data.php';

include 'view/_adminmenu.php';

$pages = Page::get(null, $_shop->id);

?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.min.css" />
<div class="col-md-10">
	<h1>Page Management</h1>
	<div class="btn-group">
		<a class="btn btn-sm btn-default glyphicon glyphicon-plus cmd-new" title = "Add Shop" href = "?layout=admin&action=edit"></a>
	</div>
	<hr/>
	<table id = "pages" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
		<thead>
			<tr>
				<th>Title</th>
				<th>Perma</th>
				<th>Shop</th>
				<th>Type</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>		
			<?
			foreach ($pages as $page)
			{
				?>
				<tr>
					<td><?=$page->title?></td>
					<td><?=$page->perma?></td>
					<td><?=$page->shop_id?></td>
					<td></td>
					<td>
						<div class="btn-group">
							<a class="btn btn-sm btn-default glyphicon glyphicon-edit" title="Edit" href="?layout=admin&action=edit&pid=<?=$page->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-eye-open" title="Details" href="?layout=admin&action=edit&pid=<?=$page->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-trash" title="Delete" href="?layout=admin&action=delete&pid=<?=$page->id?>"></a>
						</div>
					</td>
				</tr>
				<?
			}
		?>
		</tbody>
	</table>
</div>
<?
function javascripts()
{
	?>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
	    		$('#pages').dataTable();
				$('.glyphicon-edit, .cmd-new').click(function (event) {
					var that = this;
					event.preventDefault();
					$.get(that.href, { format: 'modal'}, function(data){
						var myModal = $("#myModal");
						$(".modal-content", myModal).html(data);
						myModal.modal('show');
					})
				});
				$('.glyphicon-delete').click(function (event) {
					var that = $this;
					event.preventDefault();
				});
			});
		</script>
	<?
}