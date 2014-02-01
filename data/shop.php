<?php
require_once 'data.php';

class Shop
{
	public $id, $name, $stylized, $short_desc, $url;
	
	public function __construct($name, $stylized, $short_desc, $url, $id)
	{
		$this->name = $name;
		$this->stylized = $stylized;
		$this->short_desc = $short_desc;
		$this->url = $url;
		$this->id = $id; // Should I include this or have a separate role class
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
			$shop = new Shop($row['name'], $row['stylized'], $row['short_desc'], $row['url'], $id);
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
				array_push($shops, new Shop($row['name'], $row['stylized'], $row['short_desc'], $row['url'], $id));
			} else
			{
				array_push($shops, $row['id']);
			}
		}
		return $shops;
	}
	static function shopExists($shopname)
	{
		global $con;
		$response = mysqli_query($con, "SELECT id FROM shops WHERE name='".$shopname."';");
		return ($row = mysqli_fetch_array($response));
	}	
}
?>
