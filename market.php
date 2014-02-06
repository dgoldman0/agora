<?php
require_once 'data/shop.php';
require_once 'data.php';

function printShop($shop)
{	echo "<div class=\"col-md-4\"><div class=\"panel panel-default\"><div class=\"panel-heading\"><a href=\"shop.php?shop={$shop->name}\">{$shop->stylized}</a></div><div class=\"panel-body\"><p>{$shop->short_desc}</p></div></div></div>";	
}
include 'include/header.php';
include 'menu.php';
$market->active = "market";
?>
          <!-- Marketing area -->
              <div class="jumbotron">
                      <h1>Wander the Market...</h1>
                </div>
                <!-- Content Sections -->
        <div class="row">
		<?php
		$shops = Shop::getShopList(TRUE);
		foreach ($shops as $shop)
		{
			printShop($shop);
		}
		?>
		</div>
<?php include 'include/footer.php' ?>
