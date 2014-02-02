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
		<div class="col-md-1">
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
	</div>
	<?php
}
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