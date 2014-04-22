<?
require_once 'data.php';

include 'view/_adminmenu.php';

$items = $bag->getBagItems();

?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.min.css" />
<div class="container col-md-10">
	<h2>Shopping Bag</h2>
	<hr/>
	<table id = "items" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
		<thead>
			<tr>
				<th>Name</th>
				<th>SKU</th>
				<th>Short Description</th>
				<th>Qnt</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>		
			<?
			foreach ($items as $item)
			{
				$sd = $item->short_desc;
				if (strlen($sd) > 50)
					$sd = substr($sd, 0, 50)."...";
				?>
				<tr>
					<td><?=$item->name?></td>
					<td><?=$item->sku?></td>
					<td title="<?=$item->short_desc?>"><?=$sd?></td>
					<td class="item-cnt" id="cnt-<?=$item->id?>"></td>
					<td>
						<div class="btn-group">
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
				$('.glyphicon-edit').click(function (event) {
					var that = this;
					event.preventDefault();
					$.get(that.href, { format: 'modal'}, function(data){
						var myModal = $("#myModal");
						$(".modal-content", myModal).html(data);
						myModal.modal('show');
					})
				});
				$('.item-cnt').click(function (event))
				{
					var that = this;
					event.preventDefault();
					
				}
				$('.glyphicon-delete').click(function (event) {
					var that = $this;
					event.preventDefault();
				});
			});
		</script>
	<?
}
