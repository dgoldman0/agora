<?php
// Shop index
require_once 'data.php';
require_once 'data/shop.php';

function printItem($item)
{
	global $shop;
	echo '<div class="col-md-6"><div class="panel panel-default"><div class="panel-heading"><a href="item.php?shop='.$shop->name.'&item='.$item->sku.'">'.$item->name.'</a></div><div class="panel-body"><p>'.$item->short_desc.'</p></div></div></div>';
}
if ($shop == "" || $shop == null)
{
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	// Check if the current URL matches any stores, of so, set store to that
	header("Location: ".$protocol.getServiceURL());
	die();
} else
{
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
	$items = $shop->getItemList(true);
	echo '<div class="row">';
	foreach ($items as $item)
	{
		printItem($item);
	}
	echo '</div>';
	include 'include/footer.php';
}
?>