<?php
require_once 'data.php';
require_once 'view/shop.php';

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
