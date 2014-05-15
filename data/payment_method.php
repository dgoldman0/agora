<?

class PaymentMethod extends BaseObject
{
	public $name, $user_id, $payment_type;
	function __construct($name, $user_id, $payment_type)
	{
		$this->name = $name;
		$this->user_id = $user_id;
		$this->payment_type = $payment_type;
	}
	public static function get($id = null, $item_id = null)
	{
		$con = BaseObject::$con;
		$select = "SELECT * FROM payment_methods";
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$response = $con->query("$select WHERE id=$id;");
				if ($row = $response->fetch_array())
				{
					$object = PaymentMethod::getFromRow($row);
					return $object;
				}
			}
		} else
		{
			if (isset($item_id) && is_numeric($item_id))
			{
				$objects = array();
				$response = $con->query("$select WHERE item_id = $item_id;");
				while ($row = $response->fetch_array())
				{
					$objects[] = PaymentMethod::getFromRow($row);
				}
				return $objects;
			}
		}
	}
	public static function getFromRow($row)
	{
		$object = new ItemCategory($row['name'], $row['user_id'], $row['payment_type']);
		$object->init($row);
		return $object;
	}
	public function write()
	{
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO payment_methods (name, user_id, payment_type) VALUES (?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('sii', $name, $user_id, $payment_type);
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
