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
	public static function exists($id)
	{
		$con = BaseObject::$con;
		if (is_numeric($id))
		{
			$response = $con->query("SELECT id FROM shops WHERE id=$id;");
		}
		else
		{
			$name = $con->real_escape_string($id);
			$response = $con->query("SELECT id FROM shops WHERE name='$name';");
		}
		if ($row = $response->fetch_array())
		{
			return true;
		}
		return false;
	}
	function getBoard()
	{
		$con = BaseObject::$con;
		$sql = "SELECT * FROM boards WHERE shop_id = $this->id AND default_board = TRUE;";
		$response = $con->query($sql);
		if ($row = $response->fetch_array())
		{
			return Board::getFromRow($row);
		}
	}
	public static function get($id)
	{
		$con = BaseObject::$con;
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$response = $con->query("SELECT * FROM shops WHERE id=$id;");
			}
			else
			{
				$name = $con->real_escape_string($id);
				$response = $con->query("SELECT * FROM shops WHERE name='$name';");
			}
			if ($row = $response->fetch_array())
			{
				$shop = Shop::getFromRow($row);
				return $shop;
			}
		} else
		{
			$response = $con->query("SELECT * FROM shops;");
			$shops = array();
			while ($row = $response->fetch_array())
			{
				$shops[] = Shop::getFromRow($row);
			}
			return $shops;
		}
	}
	public static function getFromRow($row)
	{
		$shop = new Shop($row['name'], $row['url'], $row['shop_type'], $row['short_desc'], $row['stylized']);
		$shop->init($row);
		return $shop;
	}
	public function write()
	{
		$con = BaseObject::$con;
		if (!$this->live)
		{
			$sql = "INSERT INTO shops (?, ?, ?, ?, ?);";
			$stmt->bind_param('ssiss', $this->name, $this->url, $this->shop_type, $this->short_desc, $this->stylized);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$sql = "UPDATE shops SET name = ?, url = ?, shop_type = ?, short_desc = ?, stylized = ? WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('ssissi', $this->name, $this->url, $this->shop_type, $this->short_desc, $this->stylized, $this->id);
			$stmt->execute();
			$stmt->close();
			return $this->id;
		}
	}
	public static function validate() {}
}
?>
