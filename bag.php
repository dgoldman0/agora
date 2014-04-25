<?php
require_once 'data.php';

$format = $_REQUEST['format'];
$layout = $_REQUEST['layout'];

if ($bid = $_REQUEST['bid'])
{
	$_bag = Bag::get($bid);
} else
{
	if ($iid = $_REQUEST['iid'])
	{
		$item = Item::get($iid);
		$_bag = Bag::getActiveBag(null, $_current_user->id, $item->shop_id);
	} else if (isset($_current_user))
	{
		$_bag = Bag::getActiveBag(null, $_current_user->id, $_shop->id);
	}
}

if ($action = $_REQUEST['action'])
{
	if ($action == "edit" && isset($_bag))
	{
		$view = "bag/edit";
	} else if ($action == "save")
	{
	} else if ($action == "add")
	{
		if (isset($_bag))
		{
			if ($bitem = BagItem::get(null, $_bag->id, $item->id))
				$bitem->cnt = $bitem->cnt + 1;
			else
				$bitem = new BagItem($_bag->id, $item->id, 1);
			$bitem->write();
			if (BaseObject::$con->errorno == 0)
			{
				
			}
		}
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
