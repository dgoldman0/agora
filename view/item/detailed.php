<?

require_once 'data.php';
$item = $_item;

switch ($format)
{
	case "json":
		$response = array();
		$response['data'] = $_item;
		echo json_encode($response);
		break;
	default:
		?>
		
		<div class="row">
			<div class="col-sm-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?=$item->name?>
					</div>
					<div class="panel-body">
						<div id="images" class="carousel slide col-md-3" data-ride="carousel">
							<ol class="carousel-indicators">
								<?php
								$c = count($media);
								if (c == 0)
								{
									echo "<li data-target=\"#images\" data-slide-to=\"0\" class=\"active\"></li>";
								} else
								{
									for ($i = 0; $i < c; $i++)
									{
										if ($i = 0)
											echo "<li data-target=\"#images\" data-slide-to=\"{$i}\" class=\"active\"></li>";
										else
											echo "<li data-target=\"#images\" data-slide-to=\"{$i}\"></li>";
									}
								}
								?>
							</ol>
							<div class="carousel-inner">
								<?php
								if (c == 0)
								{
									echo "<div class=\"item active\"><img src=\"images/default.png\" alt=\"Default\"/></div>";
								} else
								{
									$first = true;
									foreach ($media as $medium)
									{
										if ($first)
										{
											$first = false;
											echo '<div class="item active">';
										} else
										{
											echo '<div class="item">';
										}
										echo "<img data-src=\"medium.php?name={$medium->$name}\" alt=\"{$medium->alt_text}\"></div>";
									}
								}
								?>
							</div>
						  <!-- Controls -->
						  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
						    <span class="glyphicon glyphicon-chevron-left"></span>
						  </a>
						  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right"></span>
						  </a>
						</div>
						<div class = "col-md-9">
							<legend><?=$item->short_desc?></legend>
							<?=$item->long_desc?>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						Reviews
					</div>
					<div id = "reviews" class="panel-body">
					</div>
				</div>
			</div>
			<div class="col-sm-3" style = "height: 100%;">
				<div class="panel panel-default">
					<div class="panel-heading">
						Product Information
					</div>
					<div class="panel-body">
						<div class="button-toolbar" role="toobar">
							<div class="btn-group">
								<a href = "bag.php?action=add&cid=<?=$_cart->id?>&iid=<?=$item->id?>" class="glyphicon glyphicon-briefcase" title="Add to Bag"></a>
							</div>
						</div>
						<hr/>
						Price: <br/>
						Score: <?=round($item->score, 2)?>
					</div>
				</div>
			</div>
		</div>
		
		<!--Templates-->
		<script type="text/template" id = "review-tmpl">
			<? if (isset($_current_user)):?>
				<div class="well col-md-12">
					<legend><a href = "#" id = "minimize" class = "glyphicon glyphicon-resize-small"></a> Review <?=$_item->name?></legend>
					<div id = "my_review">
						<div class="col-md-8">
							<form class="form-horizontal" action="item_review.php?action=save&iid=<?=$_item->id?>" method="post" id="review-form">
								<fieldset>
									<input type="text" id = "title" name="title" class="form-control input-md" placeholder="" style="margin-bottom: 5px;">
									<textarea id = "content" name="content"><?=$content?></textarea>
								</fieldset>
								<input type = "hidden" name = "score" id = "score"/>
								<input type = "hidden" name = "rid" id = "rid"/>
							</form>
						</div>
						<div class="col-md-4">
							<legend>Rate</legend>
							<div id = "rating"></div>
						</div>
					</div>
				</div>
			<? endif;?>
			{{#each data}}
			<?= (isset($_current_user)) ? "{{#ifCond reviewer_id '!=' $_current_user->id}}" : ""?>
			<div class="well col-md-12">
				<legend>{{title}}</legend>
				{{& content}}
			</div>
			<?= (isset($_current_user)) ? "{{/ifCond}}" : ""?>
			{{/each}}
		</script>
		<!--End of Templates-->
		<?
		function javascripts()
		{
			global $_item, $_current_user; 
			?>
			<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0-alpha.2/handlebars.min.js"></script>
			<script type="text/javascript" src="js/jquery.raty.min.js"></script>
			<script type="text/javascript">
				$('document').ready(function() {
					Handlebars.registerHelper("ifCond",function(v1,operator,v2,options) {
						switch (operator)
						{
						    case "==":
						        return (v1==v2)?options.fn(this):options.inverse(this);
						
						    case "!=":
						        return (v1!=v2)?options.fn(this):options.inverse(this);
						
						    case "===":
						        return (v1===v2)?options.fn(this):options.inverse(this);
						
						    case "!==":
						        return (v1!==v2)?options.fn(this):options.inverse(this);
						
						    case "&&":
						        return (v1&&v2)?options.fn(this):options.inverse(this);
						
						    case "||":
						        return (v1||v2)?options.fn(this):options.inverse(this);
						
						    case "<":
						        return (v1<v2)?options.fn(this):options.inverse(this);
						
						    case "<=":
						        return (v1<=v2)?options.fn(this):options.inverse(this);
						
						    case ">":
						        return (v1>v2)?options.fn(this):options.inverse(this);
						
						    case ">=":
						     return (v1>=v2)?options.fn(this):options.inverse(this);
						
						    default:
						        return eval(""+v1+operator+v2)?options.fn(this):options.inverse(this);
						}
					});
					var tmpl = Handlebars.compile($("#review-tmpl").html());
					$(document).ready(function(){
						var the_score = 0.0;
						$.get("item_review.php?format=json&iid=<?=$_item->id?>", function(data){
							$("#reviews").html(tmpl(data));
							<? if (isset($_current_user)):?>
								data.data.forEach(function(entry)
								{
									console.log(entry);
									if (entry.reviewer_id == <?=$_current_user->id?>)
									{
										$('#title').val(entry.title);
										$('#content').val(entry.content);
										$('#rid').val(entry.id);
										the_score = entry.score;
										$('#score').val(the_score);
									}
								});
							<? endif;?>
							$('#minimize').click(function (event)
							{
								var that = this;
								event.preventDefault();
								$('#my_review').toggle(100);
							});
							
							tinymce.init({
							selector: "textarea",
							plugins: [
								"save advlist autolink lists link image charmap print preview anchor",
								"searchreplace visualblocks code fullscreen",
								"insertdatetime media table contextmenu paste"
							],
							toolbar: "save | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
							autosave_ask_before_unload: false});
							
							<? if (isset($_current_user)):?>
								$.fn.raty.defaults.path = '/images';  
								$('#rating').raty({
									half  : true,
									number: 5,
									score : the_score,
				       				click: function(score, evt) {
				       					$('#score').val(score);
				      				}
				      			});	
				      		<? endif;?>
						}, 'json'
						);
						return false;
					});
				});
			</script>
		<?
		}
}