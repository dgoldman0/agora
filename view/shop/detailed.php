<?
require_once 'data.php';

switch ($format)
{
	case "json":
		$response = array();
		$response['data'] = $_shop;
		echo json_encode($response);
		break;
		break;
	default:
		?>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.0.0/themes/default/style.min.css">
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
					<a href="shop.php?sid=<?=$_shop->name?>"><?=$_shop->stylized?></a>
				</div>
				<div class="panel-body">
					<p><?=$_shop->short_desc?></p>
					<legend>Categories</legend>
					<div class="col-md-12 container" id = "categories">
					  <ul>
<li>All Items<ul id="cat-1"><li>Games</li></ul><ul id="cat-2"><li>Comics</li></ul></li> 					  </ul>
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-7 container" id = "item_block">
		</div>
		<?
		function javascripts()
		{
			global $_shop; 
			?>
			<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0-alpha.2/handlebars.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.0.0/jstree.min.js"></script>
			<script type="text/javascript">
				$(function() {			
					var tmpl = Handlebars.compile($("#item-tmpl").html());
					
					$(document).ready(function(){
						$.get("item.php?format=json&sid=<?=$_shop->id?>", function(data){
							$("#item_block").html(tmpl(data));
						}, 'json'
						);
						$.get("item_category.php?format=json&sid=<?=$_shop->id?>", function (data) {
							$('#categories').jstree();
						}, 'json'
						);
						return false;
					});
				});
			</script>
		<?
		}
		break;
}