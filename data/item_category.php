<?

class ItemCategory extends BaseObject
{
	public $name, $shop_id, $parent;
	function __construct($name, $shop_id, $parent)
	{
		$this->name = $name;
		$this->shop_id = $shop_id;
		$this->parent = $parent;
	}
	public static function get($id = null, $shop_id = null)
	{
		$con = BaseObject::$con;
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$response = $con->query("SELECT * FROM item_categories WHERE id=$id;");
			}
			else
			{
				$category = $con->real_escape_string($id);
				$response = $con->query("SELECT * FROM item_categories WHERE category='$category' AND shop_id = $shop_id;");
			}
			if ($row = $response->fetch_array())
			{
				$object = ItemCategory::getFromRow($row);
				return $object;
			}
		} else
		{
			$objects = array();
			if (!isset($shop_id))
				$response = $con->query("SELECT * FROM item_categories;");
			else
				$response = $con->query("SELECT * FROM item_categories WHERE shop_id = $shop_id;");
			while ($row = $response->fetch_array())
			{
				$objects[] = ItemCategory::getFromRow($row);
			}
			return $objects;
		}
	}
	public static function getFromRow($row)
	{
		$object = new ItemCategory($row['name'], $row['shop_id'], $row['parent']);
		$object->init($row);
		return $object;
	}
	public function write()
	{
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO item_categories (name, shop_id, parent) VALUES (?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('sii', $this->name, $this->shop_id, $this->parent);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$con = BaseObject::$con;
			$sql = "UPDATE item_categories SET name = ?, shop_id = ?, parent = ?) WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('siii', $this->name, $this->shop_id, $this->parent);
			$stmt->execute();
			$stmt->close();
			return $this->id;
		}
	}
	public static function validate($object)
	{
		
	}
}
