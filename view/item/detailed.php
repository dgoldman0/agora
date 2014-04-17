<?

require_once 'data.php';
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
	</div>
	<div class="col-sm-3" style = "height: 100%;">
		<div class="panel panel-default">
			<div class="panel-heading">
				Product Information
			</div>
			<div class="panel-body">
				<div class="button-toolbar" role="toobar">
					<div class="btn-group">
						<button type="button" onClick="addItem('<?=$item->sku?>', '<?=$shop->name?>');" class="btn btn-default"><span id="bagadd" class="glyphicon glyphicon-briefcase" title="Add to Bag"></span></button>
						<? if ($market->alreadyLiked($item)) {?>
						<button type="button" onClick="likeItem('<?=$item->sku?>', '<?=$shop->name?>');" class="btn btn-default"><span id="like" class="glyphicon glyphicon-heart-empty" title="Like"></span></button>
						<?} else {?>
						<button type="button" onClick="likeItem('<?=$item->sku?>', '<?=$shop->name?>');" class="btn btn-default"><span id="like" class="glyphicon glyphicon-heart" title="Like"></span></button>
						<?}?>
					</div>
				</div>
				<hr/>
				Price: <?=$item->getPrice()->str()?><br/>
				Score: 
			</div>
		</div>
	</div>
	<div class="col-sm-3" style = "height: 100%;">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="cart.php" alt="Go to cart">Current Shopping Bag</a>
			</div>
			<div class="panel-body">
				Items: <span id="item_count"><?=$bag->item_count?></span>
			</div>
		</div>
	</div>
</div>