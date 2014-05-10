<?

class ItemPrice extends BaseObject
{
	public $item_id, $price_category, $currency, $value;
	function __construct($item_id, $price_category, $currency, $value)
	{
		$this->item_id = $item_id;
		$this->price_category = $price_category;
		$this->currency = $currency;
		$this->value = $value;
	}
	public static function get($id = null, $item_id = null)
	{
		$con = BaseObject::$con;
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$response = $con->query("SELECT * FROM item_prices WHERE id=$id;");
				if ($row = $response->fetch_array())
				{
					$object = ItemPrice::getFromRow($row);
					return $object;
				}
			}
		} else
		{
			if (isset($item_id) && is_numeric($item_id))
			{
				$objects = array();
				$response = $con->query("SELECT * FROM item_prices WHERE item_id = $item_id;");
				while ($row = $response->fetch_array())
				{
					$objects[] = ItemPrice::getFromRow($row);
				}
				return $objects;
			}
		}
	}
	public static function getFromRow($row)
	{
		$object = new ItemCategory($row['item_id'], $row['price_category'], $row['currency'], $row['value']);
		$object->init($row);
		return $object;
	}
	public function write()
	{
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO item_prices (item_id, price_category, currency, value) VALUES (?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iiid', $this->item_id, $this->price_category, $this->currency, $this->value);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$con = BaseObject::$con;
			$sql = "UPDATE item_prices SET item_id = ?, price_category = ?, currency = ?, value = ?) WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iiidi', $this->item_id, $this->price_category, $this->currency, $this->value);
			$stmt->execute();
			$stmt->close();
			return $this->id;
		}
	}
	public static function validate($object)
	{
		
	}
}
