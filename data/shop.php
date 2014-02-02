<?php
require_once 'data.php';
require_once 'data/item.php';

class Shop
{
	public $id, $name, $stylized, $short_desc, $url;
	
	public function __construct($name, $stylized, $short_desc, $url, $id)
	{
		$this->name = $name;
		$this->stylized = $stylized;
		$this->short_desc = $short_desc;
		$this->url = $url;
		$this->id = $id;
	}
	static function addShop($shop)
	{
		global $con;
		$sql = "INSERT INTO shops (name, stylized, short_desc, url) VALUES ('".$shop->name."', '".$shop->stylized."', '".$shop->short_desc."', '".$shop->url."');";
		mysqli_query($con, $sql);
	}
	function addUser($user)
	{
		global $con;
		mysqli_query($con, "INSERT INTO shop_users (id, shop_id) VALUES (".$user->id.", ".$this->id.");");
	}
	function setUserRole($user, $role)
	{
		global $con;
		mysqli_query($con, "UPDATE shop_users SET role_id=".$role." WHERE id=".$user->id.";");
	}
	// These functons probably belong in market.php->Market class
	static function getShopFromName($name)
	{
		global $con;
		$response = mysqli_query($con, "SELECT * FROM shops WHERE name='".$name."';");
		if ($row = mysqli_fetch_array($response))
		{
			$shop = new Shop($row['name'], $row['stylized'], $row['short_desc'], $row['url'], $row['id']);
			return $shop;
		}
	}
	static function getShopFromID($id)
	{
		global $con;
		$response = mysqli_query($con, "SELECT * FROM shops WHERE id=".$id.";");
		if ($row = mysqli_fetch_array($response))
		{
			$shop = new Shop($row['name'], $row['stylized'], $row['short_desc'], $row['url'], $id);
			return $shop;
		}
	}
	// Get the ID list of all of the shops. If $all_info then get the entire shop data and return as Shop
	// Should move this into Market class
	static function getShopList($all_info)
	{
		global $con;
		$shops = array();
		$response = null;
		if ($all_info)
			$response = mysqli_query($con, "SELECT * FROM shops;");
				else
			$response = mysqli_query($con, "SELECT id FROM shops;");
		while ($row = mysqli_fetch_array($response))
		{
			if ($all_info)
			{
				array_push($shops, new Shop($row['name'], $row['stylized'], $row['short_desc'], $row['url'], $row['id']));
			} else
			{
				array_push($shops, $row['id']);
			}
		}
		return $shops;
	}
	function getItemFromSKU($sku)
	{
		global $con;
		$response = mysqli_query($con, "SELECT * FROM items WHERE sku='".$sku."';");
		if ($row = mysqli_fetch_array($response))
		{
				return new Item($row['shop_id'], $row['name'], $row['sku'], $row['short_desc'], $row['long_desc'], $row['id']);
		}
	}
	function getItemList($all_info)
	{
		global $con;
		$items = array();
		$response = null;
		if ($all_info)
			$response = mysqli_query($con, "SELECT * FROM items WHERE shop_id=".$this->id.";");
				else
			$response = mysqli_query($con, "SELECT id FROM items WHERE shop_id=".$this->id.";");
		while ($row = mysqli_fetch_array($response))
		{
			if ($all_info)
			{
				array_push($items, new Item($row['shop_id'], $row['name'], $row['sku'], $row['short_desc'], $row['long_desc'], $row['id']));
			} else
			{
				array_push($items, $row['id']);
			}
		}
		return $items;
	}
	static function shopExists($shopname)
	{
		global $con;
		$response = mysqli_query($con, "SELECT id FROM shops WHERE name='".$shopname."';");
		return ($row = mysqli_fetch_array($response));
	}	
	function addItem($item)
	{
		// Adds item to shop
		global $con;
		$sql = "INSERT INTO items (shop_id, name, sku, short_desc, long_desc) VALUES (".$this->id.", '".htmlentities($item->name, ENT_QUOTES)."', '".htmlentities($item->sku, ENT_QUOTES)."', '".htmlentities($item->short_desc, ENT_QUOTES)."', '".htmlentities($item->long_desc, ENT_QUOTES)."');";
		echo $sql;
		$response = mysqli_query($con, $sql);
	}
}
?>
