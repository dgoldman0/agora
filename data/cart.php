<?
require_once 'data.php';

class Cart extends BaseObject
{
	public $owner_id, $name, $wishlist, $active;
	public function __construct($owner_id, $name, $wishlist = 0, $active = 0)
	{
		$this->owner_id = $owner_id;
		$this->name = $name;
		$this->wishlist = $wishlist;
		$this->active = $active;
	}
	function getActiveCart($owner_id)
	{
		$con = BaseObject::$con;
		$sql = "SELECT * FROM shopping_carts WHERE owner_id = $owner_id AND active=true;";
		$response = mysqli_query($con, $sql);
		if ($row = mysqli_fetch_array($response))
		{
			return Cart::getFromRow($row);
		} else
		{
			$cart = new Cart($owner_id, "", false, true);
			return $cart->write();
		}
	}
	public static function get($id = null, $owner_id = null)
	{
		$con = BaseObject::$con;
		if ($id)
		{
			if (is_numeric($id))
			{
				$response = $con->query("SELECT * FROM shopping_carts WHERE id=$id;");
			}
			else
			{
				$name = $con->real_escape_string($id);
				$response = $con->query("SELECT * FROM shopping_carts WHERE name='$name' AND owner_id = $owner_id;");
			}
			if ($row = $response->fetch_array())
			{
				$object = Cart::getFromRow($row);
				return $object;
			}
		} else
		{
			$objects = array();
			if (!isset($owner_id))
				$response = $con->query("SELECT * FROM shopping_carts;");
			else
				$response = $con->query("SELECT * FROM shopping_carts WHERE owner_id = $owner_id;");
			while ($row = $response->fetch_array())
			{
				$objects[] = Cart::getFromRow($row);
			}
			return $objects;
		}
	}
	public static function getFromRow($row)
	{
		$object = new Cart($row['owner_id'], $row['name'], $row['wishlist'], $row['active']);
		$object->init($row);
		return $object;
	}
	public function write()
	{
		$con = BaseObject::$con;
		if (!$this->live)
		{
			$sql = "INSERT INTO items (owner_id, name, wishlist, active) VALUES (?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('isii', $this->owner_id, $this->name, $this->wishlist, $this->active);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$sql = "UPDATE items SET owner_id = ?, name = ?, wishlist = ?, active = ?) WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('isiii', $this->owner_id, $this->name, $this->wishlist, $this->active, $this->id);
			$stmt->execute();
			$stmt->close();
			return $id;
		}
	}
	public static function validate($object)
	{
		
	}
}
?>