<?php
// Shop index
require_once 'data.php';
require_once 'data/shop.php';

$shop = $_GET['shop'];
if ($shop == "")
{
	header("Location: " + getServiceURL());
	die();
} else
{
	if (!shopExists($shop))
	{
		header("Location: ".getServiceURL());
		die();
	}
	include 'include/header.php';
	include 'menu.php';
	
	include 'include/footer.php';	
}
?>