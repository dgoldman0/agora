<?
require_once 'data.php';
?>
<style type="text/css">
	.pos-btn
	{
		width: 150px;
		height: 150px;
		word-wrap:break-word;
		text-wrap:unrestricted;
	}
</style>
<!--Templates-->
<script type="text/template" id = "item-tmpl">
	{{#each data}}
	<button class = "pos-btn">{{name}}</button>
	{{/each}}
</script>
<!--End of Templates-->
<div class="col-md-6 container" id = "ticket">
	<table class="item_table" id = "ticket_items" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
		<thead>
			<tr>
				<th>Name</th>
				<th>SKU</th>
				<th>CNT</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>		
		</tbody>
	</table>
</div>
<div class="col-md-6 container" id = "item_block">
</div>
<?
function javascripts()
{
	global $_shop; 
	?>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0-alpha.2/handlebars.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(function() {			
			var tmpl = Handlebars.compile($("#item-tmpl").html());
			
			$(document).ready(function(){
				$.get("item.php?format=json&sid=<?=$_shop->id?>", function(data){
					$("#item_block").html(tmpl(data));
		    		$('#ticket_items').dataTable({
		    			"bFilter": false
		    		});
				}, 'json'
				);
				$.get("itemcategory.php?format=json&sid=<?=$_shop->id?>", function (data) {
					
				}, 'json'
				);
				return false;
			});
		});
	</script>
<?
}