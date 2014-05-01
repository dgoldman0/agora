<?
require_once 'data.php';

$friends = Friend::get(null, $_current_user->id);

if ($format == "json")
{
	echo jsonResponse($friends);
} else
{
	?>
	<!--Templates-->
	<script type="text/template" id = "friend-tmpl">
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
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<p>Summary of Friends</p>
			</div>
			<div class="panel-body">
				You have <span id="friend_cnt"></span> friends.
			</div>
		</div>
	</div>
	<div class="col-md-9 container" id = "friend_block">
	</div>
	<?
	function JavaScripts()
	{
		global $_shop; 
		?>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0-alpha.2/handlebars.min.js"></script>
		<script type="text/javascript">
			$(function() {			
				var tmpl = Handlebars.compile($("#friend-tmpl").html());
				
				$(document).ready(function(){
					$.get("friend.php?format=json", function(data){
						$("#friend_block").html(tmpl(data));
						$('friend_cnt').html(data['data'].length);
					}, 'json');
					return false;
				});
			});
		</script>
	<?
	}
}