<?

require_once 'data.php';
$item = $_item;

?>

<div class="row">
	<div class="col-sm-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?=$item->name?>
			</div>
			<div class="panel-body">
						<div id="images" class="carousel slide" data-ride="carousel">
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
				<?=$item->short_desc?>
				<hr/>
				<?=$item->long_desc?>
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
				Score: 
			</div>
		</div>
	</div>
</div>

<!--Templates-->
<script type="text/template" id = "review-tmpl">
	<? if (isset($_current_user)):?>
		<legend><a href = "#" id = "minimize" class = "glyphicon glyphicon-resize-small"></a> Review <?=$_item->name?></legend>
		<div id = "my_review">
			<div class="col-md-8">
				<form class="form-horizontal" action="item_review.php?action=save&iid=<?=$_item->id?>" method="post" id="register-form">
					<fieldset>
						<input type="text" name="title" class="form-control input-md" placeholder="" style="margin-bottom: 5px;">
						<textarea name="content"><?=$content?></textarea>
					</fieldset>
				</form>
			</div>
			<div class="col-md-4">
				<legend>Rate</legend>
				<div id = "rating"></div>
			</div>
		</div>
	<? endif;?>
	{{#each data}}
	<div class="col-md-12">
	</div>
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
			var tmpl = Handlebars.compile($("#review-tmpl").html());
			review_score = 0;
			$(document).ready(function(){
				$.get("item_review.php?format=json&iid=<?=$_item->id?>", function(data){
					$("#reviews").html(tmpl(data));

					$('#minimize').click(function (event)
					{
						var that = this;
						event.preventDefault();
						$('#my_review').toggle(1000);
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
							score : 0,
		       				click: function(score, evt) {
		       					review_score = score;
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