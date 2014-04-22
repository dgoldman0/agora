<?
require_once 'data.php';
?>
<!--Templates-->
<script type="text/template" id = "item-tmpl">
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
