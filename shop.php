<?php
// Shop index
require_once 'data.php';

class Shop
{
	private $id, $name, $stylized, $master, $url;
	
	public function __construct($name, $stylized, $url, $id)
	{
		$this->name = $name;
		$this->stylized = $stylized;
		$this->url = $url;
		$this->id = $id;
	}
	public static function addShop($shop)
	{
		mysqli_query("INSERT INTO shops (name, stylized, url) VALUES ('".$shop->name."', '".$shop->stylized."', ".$shop->url."');");
	}
	function addShopUser($shop, $user)
	{
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
$shop = $_GET['shop'];
if ($shop == "")
{
	header("Location: " + getServiceURL());
} else
{
	include 'include/header.php';
	include 'include/menu.php';
	
	include 'include/footer.php';	
}
?>