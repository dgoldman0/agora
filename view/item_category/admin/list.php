<?
require_once 'data.php';

include 'view/_adminmenu.php';

$objects = ItemCategory::get(null, $_shop->id);

?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.min.css" />
<div class="container col-md-10">
	<h2>Item Category Management</h2>
	<div class="btn-group">
		<a class="btn btn-sm btn-default glyphicon glyphicon-plus" title = "Add Category" href = "?layout=admin&action=edit&sid=<?=$_shop->id?>"></a>
	</div>
	<hr/>
	<table id = "items" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
		<thead>
			<tr>
				<th>Name</th>
				<th>Parent</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>		
			<?
			foreach ($objects as $object)
			{
				?>
				<tr>
					<td><?=$object->name?></td>
					<td><?=$object->parent?></td>
					<td>
						<div class="btn-group">
							<a class="btn btn-sm btn-default glyphicon glyphicon-edit" title="Edit" href="?action=edit&iid=<?=$item->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-eye-open" title="Details" href="?action=edit&iid=<?=$item->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-trash" title="Delete" href="?action=delete&iid=<?=$item->id?>"></a>
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
		<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
	    		$('#items').dataTable();
				$('.glyphicon-edit, .glyphicon-plus').click(function (event) {
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
