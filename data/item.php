<?
require_once 'data.php';

class Item extends BaseObject
{
	public $shop_id, $name, $sku, $short_desc, $long_desc, $score, $list;
	public function __construct($shop_id, $name, $sku, $short_desc, $long_desc, $score, $list)
	{
		$this->shop_id = $shop_id;
		$this->name = $name;
		$this->sku = $sku;
		$this->short_desc = $short_desc;
		$this->long_desc = $long_desc;
		$this->score = $score;
		$this->list = $list;
	}
	public static function get($id = null, $shop_id = null)
	{
		$select = "SELECT *, (SELECT avg(score) FROM item_reviews WHERE item_id = items.id) as score, (SELECT value FROM item_prices WHERE item_id = items.id) as list FROM items";
		$con = BaseObject::$con;
		if ($id)
		{
			if (is_numeric($id))
			{
				$response = $con->query("$select WHERE id=$id;");
			}
			else
			{
				$sku = $con->real_escape_string($id);
				$response = $con->query("$select WHERE sku='$sku' AND shop_id = $shop_id;");
			}
			if ($row = $response->fetch_array())
			{
				$object = Item::getFromRow($row);
				return $object;
			}
		} else
		{
			$objects = array();
			if (!isset($shop_id))
				$response = $con->query("$select;");
			else
				$response = $con->query("$select WHERE shop_id = $shop_id;");
			while ($row = $response->fetch_array())
			{
				$objects[] = Item::getFromRow($row);
			}
			return $objects;
		}
	}
	public static function getFromRow($row)
	{
		$object = new Item($row['shop_id'], $row['name'], $row['sku'], $row['short_desc'], $row['long_desc'], $row['score'], $row['list']);
		$object->init($row);
		return $object;
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
	public static function validate($object)
	{
		
	}
}