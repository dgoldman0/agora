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
	.highlighted td
	{
		background-color: #FFFFAA ; 
	}
</style>
<div class="container col-md-10">
	<h1>Shop Management</h1>
	<? if(isset($_REQUEST['sub_action'])): ?>
	<div class="alert alert-success">
		<a class="close">&times;</a>
		The row has been <?=$_REQUEST['sub_action']?> successfully!
	</div>
	<? endif; ?>
	<div class="btn-group">
		<a class="btn btn-sm btn-default glyphicon glyphicon-plus cmd-new" title = "Add Shop" href = "?action=edit&layout=admin"></a>
	</div>
	<hr/>
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
				<tr class="<?=$shop->id==$_shop->id ? "highlighted" : "" ?>">
					<td title="Select <?=$shop->stylized?>"><a href = "?sid=<?=$shop->id?>&layout=admin"><?=$shop->stylized?></a></td>
					<td><?=$shop->url?></td>
					<td></td>
					<td><?=$shop->short_desc?></td>
					<td class = "actiongroup">
						<div class="btn-group">
							<a class="btn btn-sm btn-default glyphicon glyphicon-edit" title="Edit" href="?action=edit&layout=admin&sid=<?=$shop->id?>"></a>
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
				$(".highlighted td").delay(2000).animate({backgroundColor: ""}, 2000);
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
