<?php
require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($cid = $_REQUEST['cid'])
{
	$cart = Cart::get($cid);
} else
{
	// Check logged in
	if (isset($_current_user))
	{
		$cart = Cart::getActiveCart($_current_user->id);
	}
}

if ($action = $_REQUEST['action'])
{
	if ($action == "edit" && isset($cart))
	{
		$view = "cart/edit";
	} else if ($action = "save")
	{
	}
} else
{
	if (isset($cart))
	{
		$view = "cart/contents";
	}
	else
	{
		if ($layout == "admin" && isAdmin($_shop->id))
			$view = "cart/admin/list";
	}
}
switch ($format)
{
	case "modal":
	case "csv":
	case "json":
		$include = "view/$view.php";
		break;
	default:
		$include = "view/_base.php";
}
include $include;