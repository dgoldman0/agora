<?
require_once 'data.php';

class Item extends BaseObject
{
	public $shop_id, $name, $sku, $short_desc, $long_desc;
	public function __construct($shop_id, $name, $sku, $short_desc, $long_desc)
	{
		$this->shop_id = $shop_id;
		$this->name = $name;
		$this->sku = $sku;
		$this->short_desc = $short_desc;
		$this->long_desc = $long_desc;
	}
	public static function get($id = null, $shop_id = null)
	{
		$con = BaseObject::$con;
		if ($id)
		{
			if (is_numeric($id))
			{
				$response = $con->query("SELECT * FROM items WHERE id=$id;");
			}
			else
			{
				$sku = $con->real_escape_string($id);
				$response = $con->query("SELECT * FROM items WHERE sku=$sku AND shop_id = $shop_id;");
			}
			if ($row = $response->fetch_array())
			{
				$item = Item::getFromRow($row);
				return $item;
			}
		} else
		{
			$items = array();
			if (!isset($shop_id))
				$response = $con->query("SELECT * FROM items;");
			else
				$response = $con->query("SELECT * FROM items WHERE shop_id = $shop_id;");
			while ($row = $response->fetch_array())
			{
				$items[] = Item::getFromRow($row);
			}
			return $items;
		}
	}
	public static function getFromRow($row)
	{
		$item = new Item($row['shop_id'], $row['name'], $row['sku'], $row['short_desc'], $row['long_desc']);
		$item->init($row);
		return $item;
	}
	public function write()
	{
		$con = BaseObject::$con;
		if (!$this->live)
		{
			$sql = "INSERT INTO items (shop_id, name, sku, short_desc, long_desc) VALUES (?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('issss', $this->shop_id, $this->name, $this->sku, $this->short_desc, $this->long_desc);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$sql = "UPDATE items SET shop_id = ?, name = ?, sku = ?, short_desc = ?, long_desc = ?) WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('issssi', $this->shop_id, $this->name, $this->sku, $this->short_desc, $this->long_desc, $this->id);
			$stmt->execute();
			$stmt->close();
			return $id;
		}
	}
	public static function validate(Item $item)
	{
		
	}
}