<?php
require_once 'data.php';

class Shop
{
	public $id, $name, $stylized, $short_desc, $url, $shop_type;
	
	public function __construct($name, $stylized, $short_desc, $url, $shop_type, $id)
	{
		$this->name = $name;
		$this->stylized = $stylized;
		$this->short_desc = $short_desc;
		$this->url = $url;
		$this->shop_type = $shop_type;
		$this->id = $id;
	}
	// This needs to be moved into Market
	static function addShop($shop)
	{
		$con = BaseObject::$con;
		$sql = "INSERT INTO shops (name, stylized, short_desc, url, shop_type) VALUES ('{$shop->name}', '{$shop->stylized}', '{$shop->short_desc}', {$shop->shop_type}, '{$shop->url}');";
		mysqli_query($con, $sql);
	}
	function addUser($user)
	{
		$con = BaseObject::$con;
		mysqli_query($con, "INSERT INTO shop_users (id, shop_id) VALUES ({$user->id}, {$this->id});");
	}
	function setUserRole($user, $role)
	{
		$con = BaseObject::$con;
		mysqli_query($con, "UPDATE shop_users SET role_id={$role} WHERE id={$user->id};");
	}
	// These functons probably belong in market.php->Market class
	static function getShopFromName($name)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT * FROM shops WHERE name='{$name}';");
		if ($row = mysqli_fetch_array($response))
		{
			$shop = new Shop($row['name'], $row['stylized'], $row['short_desc'], $row['url'], $row['shop_type'], $row['id']);
			return $shop;
		}
	}
	static function getShopFromID($id)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT * FROM shops WHERE id={$id};");
		if ($row = mysqli_fetch_array($response))
		{
			$shop = new Shop($row['name'], $row['stylized'], $row['short_desc'], $row['url'], $row['shop_type'], $id);
			return $shop;
		}
	}
	// Get the ID list of all of the shops. If $all_info then get the entire shop data and return as Shop
	// Should move this into Market class
	static function getShopList($all_info)
	{
		$con = BaseObject::$con;
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
				array_push($shops, new Shop($row['name'], $row['stylized'], $row['short_desc'], $row['url'], $row['shop_type'], $row['id']));
			} else
			{
				array_push($shops, $row['id']);
			}
		}
		return $shops;
	}
	function getItemFromSKU($sku)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT * FROM items WHERE sku='{$sku}' AND shop_id={$this->id};");
		if ($row = mysqli_fetch_array($response))
		{
			return new Item($row['shop_id'], $row['name'], $row['sku'], $row['short_desc'], $row['long_desc'], $row['id']);
		}
	}
	function getItemList($all_info)
	{
		$con = BaseObject::$con;
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
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT id FROM shops WHERE name='{$shopname}';");
		return ($row = mysqli_fetch_array($response));
	}
	function getMediaList($all_info, $include_data = false)
	{
		$con = BaseObject::$con;
		if ($all_info)
		{
			if ($include_data)
				$response = mysqli_query($con, "SELECT * FROM media WHERE shop_id={$this->id};");
			else 
				$response = mysqli_query($con, "SELECT id, uploaded_on, name, type, alt_text, long_desc FROM media WHERE shop_id={$this->id};");
		}
		else
		{
			$response = mysqli_query($con, "SELECT id FROM media WHERE shop_id={$this->id};");
		}
		$media = aray();
		while ($row = mysqli_fetch_array($response))
		{
			if ($all_info)
			{
				if ($include_data)
					array_push($media, new Medium($row['uploaded_on'], $row['name'], $row['name'], $row['type'], $row['data'], $row['alt_text'], $row['long_desc']));
				else 
					array_push($media, new Medium($row['uploaded_on'], $row['name'], $row['name'], $row['type'], '', $row['alt_text'], $row['long_desc']));
			}
			else
			{
				array_push($media, $row['id']);
			}
		}
		return $media;
	}
	function addMedia($media)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "INSERT INTO media () VALUES ();");
		if ($row = $mysqli_fetch(array($response)))
		{
			return mysqli_insert_id($con);
		}
	}
	function addItem($item)
	{
		// Adds item to shop
		$con = BaseObject::$con;
		$item = $item->makeInjectionSafe();
		$response = mysqli_query($con, "INSERT INTO items (shop_id, name, sku, short_desc, long_desc) VALUES ({$this->id}, '{$item->name}', '{$item->sku}', '{$item->short_desc}', '{$item->long_desc}');");
		return mysqli_insert_id($con);
	}
	function getBoard()
	{
		$con = BaseObject::$con;
		$sql = "SELECT * FROM boards WHERE shop_id = $id AND default_board = TRUE;";
		$response = $con->query($sql);
		if ($row = $response->fetch_array())
		{
			return Board::getFromRow($row);
		}
	}
}
?>
