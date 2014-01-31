<?php
require_once 'data.php';

class Shop
{
	private $id, $name, $stylized, $master, $url;
	
	public function __construct($name, $stylized, $url, $id)
	{
		$this->name = $name;
		$this->stylized = $stylized;
		$this->url = $url;
		$this->id = $id; // Should I include this or have a separate role class
	}
	static function addShop($shop)
	{
		mysqli_query("INSERT INTO shops (name, stylized, url) VALUES ('".$shop->name."', '".$shop->stylized."', ".$shop->url."');");
	}
	function addUser($shop, $user)
	{
		mysqli_query("INSERT INTO shop_users (id, shop_id) VALUES (".$user->id.", ".$shop->id.");");
	}
	function setUserRole($user, $role)
	{
		mysqli_query("UPDATE shop_users SET role_id=".$role." WHERE id=".$user->id.";");
	}
	static function getShopFromID($id)
	{
		$response = mysqli_query("SELECT * FROM shops WHERE id=".$id.";");
		if ($row = mysqli_fetch_array($response))
		{
			$shop = new Shop($row['name'], $row['stylized'], $row['url'], $id);
		}
		return $shop;
	}
}
?>
