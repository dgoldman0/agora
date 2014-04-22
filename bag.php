<?php
require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($bid = $_REQUEST['bid'])
{
	$bag = Bag::get($bid);
} else
{
	// Check logged in
	if (isset($_current_user))
	{
		$bag = Bag::getActiveBag(Cart::getActiveCart($_current_user->id));
	}
}

if ($action = $_REQUEST['action'])
{
	if ($action == "edit" && isset($bag))
	{
		$view = "bag/edit";
	} else if ($action = "save")
	{
	}
} else
{
	if (isset($bid))
	{
		$view = "bag/edit";
	}
	else
	{
		if ($layout == "admin" && isAdmin($_shop->id))
			$view = "bag/admin/list";
	}
}
if ($format == "modal")
{
	$include = "view/$view.php";
} else
{
	$include = "view/{$root}_base.php";
}
include $include;
