<?
require_once 'data.php';

include 'view/_adminmenu.php';

if (isset($_REQUEST['sid']))
	$roles = UserRole::get(null, $_shop->id);
else
	$roles = UserRole::get();
?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.min.css" />
<div class="container col-md-10">
	<h1>User Role Management</h1>
	<style type="text/css">
		body table.table .highlighted td{
			background-color: #FFFFAA ; 
		}
	</style>
	<? if(isset($_REQUEST['sub_action'])): ?>
	<div class="alert alert-success">
		<a class="close">&times;</a>
		The row has been <?=$_REQUEST['sub_action']?> successfully!
	</div>
	<? endif; ?>
	<p></p><a href="?action=edit" class="cmd-new">New User Role</a></p>
	<table id = "roles" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
		<thead>
			<tr>
				<th>Role ID</th>
				<th>Title</th>
				<th>Shop</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>		
			<?
			foreach ($roles as $role)
			{
				?>
				<tr>
					<td><?=$role->id?></td>
					<td><?=$role->title?></td>
					<td><?=$role->stylized?></td>
					<td>
						<div class="btn-group">
							<a class="btn btn-sm btn-default glyphicon glyphicon-edit" title="Edit" href="?action=edit&uid=<?=$role->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-eye-open" title="Details" href="?action=edit&uid=<?=$role->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-trash" title="Delete" href="?action=delete&uid=<?=$role->id?>"></a>
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
	    		$('#roles').dataTable();
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
				$(".close").click(function(){
					$(this).closest(".alert").slideUp();
				});
			});
		</script>
	<?
}
