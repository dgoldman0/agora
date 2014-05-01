<?
require_once 'data.php';

include 'view/_adminmenu.php';

$users = User::get();

?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.min.css" />
<div class="container col-md-10">
	<h1>User Management</h1>
	<style type="text/css">
		.highlighted td
		{
			background-color: #FFFFAA ; 
		}
	</style>
	<? if(isset($_REQUEST['sub_action'])): ?>
	<div class="alert alert-success">
		<a class="close">&times;</a>
		The row has been <?=$_REQUEST['sub_action']?> successfully!
	</div>
	<? endif; ?>
	<div class="btn-group">
		<a class="btn btn-sm btn-default glyphicon glyphicon-plus cmd-new" title = "Add Item" href = "?action=edit"></a>
		<a class="btn btn-sm btn-default glyphicon glyphicon-open" title = "Add From CSV" href = "?action=csveditor"></a>
	</div>
	<hr/>
	<table id = "users" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
		<thead>
			<tr>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Role</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>		
			<?
			foreach ($users as $user)
			{
				?>
				<tr class="<?=$user->id==$_user->id ? "highlighted" : "" ?>">
					<td><?=$user->username?></td>
					<td><?=$user->first?></td>
					<td><?=$user->last?></td>
					<td><?=$user->email?></td>
					<td><?=$user->role?></td>
					<td>
						<div class="btn-group">
							<a class="btn btn-sm btn-default glyphicon glyphicon-edit" title="Edit" href="?action=edit&uid=<?=$user->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-eye-open" title="Details" href="?action=edit&uid=<?=$user->id?>"></a>
							<a class="btn btn-sm btn-default glyphicon glyphicon-trash" title="Delete" href="?action=delete&uid=<?=$user->id?>"></a>
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
	    		$('#users').dataTable();
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
				$(".close").click(function(){
					$(this).closest(".alert").slideUp();
				});
			});
		</script>
	<?
}
