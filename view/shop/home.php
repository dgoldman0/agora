<?
require_once 'data.php';

?>
<!--Templates-->
<script type="text/template" id = "item-tmpl">
	{{#each data}}
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="item.php?iid={{id}}">{{name}}</a>
			</div>
			<div class="panel-body">
				{{short_desc}}
			</div>
		</div>
	</div>
	{{/each}}
</script>
<!--End of Templates-->
<div class="col-md-3">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="shop.php?shop=<?=$_shop->name?>"><?=$_shop->stylized?></a>
		</div>
		<div class="panel-body">
			<p><?=$_shop->short_desc?></p>
		</div>
	</div>
</div>	
<div class="col-md-7 container" id = "item_block">
</div>
<div class="col-md-2 container" id = "categories">
	
</div>
<?
function javascripts()
{
	global $_shop; 
	?>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0-alpha.2/handlebars.min.js"></script>
	<script type="text/javascript">
		$(function() {			
			var tmpl = Handlebars.compile($("#item-tmpl").html());
			
			$(document).ready(function(){
				$.get("item.php?format=json&sid=<?=$_shop->id?>", function(data){
					$("#item_block").html(tmpl(data));
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