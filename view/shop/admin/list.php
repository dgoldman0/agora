<?
require_once 'data.php';

include 'view/_adminmenu.php';

$shops = Shop::get();

?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.min.css" />
<style>
	.actiongroup
	{
  		width: 120px;
  	}
</style>
<div class="container col-md-10">
	<table id = "shops" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
		<thead>
			<tr>
				<th>Shop Name</th>
				<th>URL</th>
				<th>Shop Type</th>
				<th>Short Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>		
			<?
			foreach ($shops as $shop)
			{
				?>
				<tr>
					<td title="Select Shop"><a href = "?sid=<?=$shop->id?>&layout=admin"><?=$shop->stylized?></a></td>
					<td><?=$shop->url?></td>
					<td></td>
					<td><?=$shop->short_desc?></td>
					<td class = "actiongroup">
						<div class="btn-group">
							<a class="btn btn-sm btn-default glyphicon glyphicon-edit" title="Edit" href="?action=edit&sid=<?=$shop->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-eye-open" title="Details" href="?action=edit&sid=<?=$shop->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-trash" title="Delete" href="?action=delete&sid=<?=$shop->id?>"></a>
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
	    		$('#shops').dataTable();
				$('.glyphicon-edit').click(function (event) {
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
