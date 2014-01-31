<?php
// Shop index
require_once 'data.php';
require_once 'data/shop.php';

$shop = toURLSafe($_GET['shop']);
if ($shop == "")
{
	header("Location: " + getServiceURL());
	die();
} else
{
	$shop = Shop::getShopFromName($shop);
	if (!shop)
	{
		header("Location: ".getServiceURL());
		die();
	}
	include 'include/header.php';
	include 'menu.php';
    echo '<div class="jumbotron">';
	echo $shop->short_desc;
    echo '</div>';
	include 'include/footer.php';
}
?>