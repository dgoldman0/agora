<?php
require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($cid = $_REQUEST['cid'])
{
	$_cart = Cart::get($cid);
} else
{
	// Check logged in
	if (isset($_current_user))
	{
		$_cart = Cart::getActiveCart($_current_user->id);
	}
}

if ($action = $_REQUEST['action'])
{
	if ($action == "edit" && isset($cart))
	{
		$view = "cart/edit";
	} else if ($action == "save")
	{
	} else if ($action == "add")
	{
		if ($iid = $_REQUEST['iid'])
		{
			$item = Item::get($iid);
			if ($bid = $_REQUEST['bid'])
				$_bag = Bag::get($bid);
			else if (isset($_current_user))
				$_bag = Bag::getActiveBag($_cart->id, null, $item->shop_id);
			if (isset($_bag))
			{
			}
		}
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