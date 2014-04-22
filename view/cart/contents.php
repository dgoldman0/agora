<?
require_once 'data.php';

switch ($format)
{
	case "json":
		$bags = Bag::get(null, $cart->id, null);
		// Get item information
		$bagitems = array();
		foreach ($bags as $bag)
		{
			$bagitems["$bag->id"] = BagItem::get(null, $bag->id);
		}
		$data = array();
		$data['bags'] = $bags;
		$data['bagitems'] = $bagitems;
		echo jsonResponse($data);
		break;
	default:
		?>
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.min.css" />
		<!--Templates-->
		<script type="text/template" id = "list-tmpl">
			{{#each data.bagitems}}
			<table class="item_table" id = "items_{{id}}" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
				<thead>
					<tr>
						<th>Name</th>
						<th>SKU</th>
						<th>CNT</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>		
					{{#each this}}
						<tr>
							<td>{{name}}</td>
							<td>{{sku}}</td>
							<td>{{cnt}}</td>
							<td>
								<div class="btn-group">
									<a class="btn btn-sm btn-default glyphicon glyphicon-edit" title="Edit" href="?action=edit&iid={{id}}"></a>
									<a class="btn btn-sm btn-default glyphicon glyphicon-eye-open" title="Details" href="?action=edit&iid={{id}}"></a>
									<a class="btn btn-sm btn-default glyphicon glyphicon-trash" title="Delete" href="?action=delete&iid={{id}}"></a>
								</div>
							</td>
						</tr>
					{{/each}}
				</tbody>
			</table>
			{{/each}}
		</script>
		<!--End of Templates-->
		<div class="col-md-6 container" id = "list_block">
		</div>
		<?
		function JavaScripts()
		{
			global $_shop; 
			?>
			<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0-alpha.2/handlebars.min.js"></script>
			<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>
			<script type="text/javascript">
				$(function() {			
					var tmpl = Handlebars.compile($("#list-tmpl").html());
					
					$(document).ready(function(){
						$.get("cart.php?format=json&cid=<?=$cart->id?>", function(data){
							$("#list_block").html(tmpl(data));
				    		$('.item_table').dataTable();
						}, 'json'
						);
						return false;
					});
				});
			</script>
			<?
		}
}