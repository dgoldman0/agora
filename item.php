<?php
require_once 'data.php';
require_once 'data/shop.php';
require_once 'data/user.php';
require_once 'data/item.php';

function displayItem($item)
{
	$media = $item->getItemImages(true);
	?>
	<div class="row">
		<div class="col-md-3">
			<div id="images" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php
					$c = count($media);
					for ($i = 0; $i < c; $i++)
					{
						if ($i = 0)
							echo '<li data-target="#images" data-slide-to="'.$i.'" class="active""></li>';
						else
							echo '<li data-target="#images" data-slide-to="'.$i.'"></li>';
					}
					?>
				</ol>
				<div class="carousel-inner">
					<?php
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
						echo '<img data-src="medium.php?name='.$medium->$name.'" alt="'.$medium->alt_text.'"></div>';
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?=$item->name?>
				</div>
				<div class="panel-body">
					<div class="button-toolbar" role="toobar">
						<div class="btn-group">
							<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-shopping-cart" data-toggle="tooltip" data-placement="top" title="Add to Cart"></span></button>
							<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-share" data-toggle="tooltip" data-placement="top" title="Share Item"></span></button>
						</div>
					</div>
					<hr/>
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
					Price: <br/>
					Score: 
				</div>
			</div>
		</div>
	</div>
	<?php
}
$shop = $market->shop;
if ($shop != null)
{
	include 'include/header.php';
	include 'menu.php';
	$sku = $_GET['item'];
	displayItem($shop->getItemFromSKU($sku));
	include 'include/footer.php';
} else
{
	header("Location: index.php");
	die();
}
?>