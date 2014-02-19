<?php
// Shop index
require_once 'data.php';
require_once 'data/shop.php';
require_once 'restaurants/restaurant.php';
require_once 'stores/store.php';

$shop = $market->shop;
if ($shop == "" || $shop == null)
{
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	// Check if the current URL matches any stores, of so, set store to that
//	header("Location: ".$protocol.getServiceURL());
	die();
} else
{
	include 'include/header.php';
	include 'menu.php';
	if ($shop->shop_type == 0)
	{
		// Display store data
		displayStore($shop);
	} else if ($shop->shop_type == 1)
	{
		// Display restaurant data
		displayRestaurant($shop);
	}
	include 'include/footer.php';
}
?>