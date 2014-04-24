<?
require_once 'data.php';

?>
<!--Templates-->
<script type="text/template" id = "bag-tmpl">
	{{#each data}}
	<div class="col-md-3">
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
<div class="col-md-2">
	<div class="panel panel-default">
		<div class="panel-heading">
		</div>
		<div class="panel-body">
		</div>
	</div>
</div>	
<div class="col-md-6 container" id = "cart_block">
</div>
<?
function JavaScripts()
{
	global $_shop; 
	?>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0-alpha.2/handlebars.min.js"></script>
	<script type="text/javascript">
		$(function() {			
			var tmpl = Handlebars.compile($("#bag-tmpl").html());
			
			$(document).ready(function(){
				$.get("cart.php?format=json&cid=<?=$_cart->id?>", function(data){
					$("#cart_block").html(tmpl(data));
				}, 'json'
				);
				return false;
			});
		});
	</script>
<?
}