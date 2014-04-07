<?php
require_once 'data.php';

class Shop extends BaseObject
{
	public $name, $url, $shop_type, $short_desc, $stylized;
	
	public function __construct($name, $url, $shop_type, $short_desc, $stylized)
	{
		$this->name = $name;
		$this->url = $url;
		$this->shop_type = $shop_type;
		$this->short_desc = $short_desc;
		$this->stylized = $stylized;
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
	public static function get($id)
	{
		if (isset($id))
		{
			$con = BaseObject::$con;
			if (is_numeric($id))
			{
				$response = $con->query("SELECT * FROM shops WHERE id=$id;");
			}
			else
			{
				$name = $con->real_escape_string($name);
				$response = $con->query("SELECT * FROM shops WHERE name=$name");
			}
			if ($row = $response->fetch_array())
			{
				$shop = Shop::getFromRow($row);
				return $shop;
			}
		}
	}
	public static function getFromRow($row)
	{
		$shop = new Shop($row['name'], $row['url'], $row['shop_type'], $row['short_desc'], $row['stylized']);
		$shop->init($row);
		return $shop;
	}
	public function write() {}
	public static function validate() {}
}
?>
