<?
require_once 'data.php';

// Shopping bag class
class Bag extends BaseObject
{
	// Structure
	public $cart_id, $shop_id, $active;
	
	public function __construct($cart_id, $shop_id, $active = 0)
	{
		$this->cart_id = $cart_id;
		$this->shop_id = $shop_id;
		$this->active = $active;
	}
	function getActiveBag($user_id)
	{
		$con = BaseObject::$con;
		$sql = "SELECT * FROM shopping_bags WHERE cart_id = $cart_id AND shop_id = $_shop->id AND active=true;";
		$response = mysqli_query($con, $sql);
		if ($row = mysqli_fetch_array($response))
		{
			return Bag::getFromRow($row);
		}
	}
	public static function get($id = null, $cart_id = null, $owner_id = null)
	{
		$con = BaseObject::$con;
		if ($id)
		{
			if (is_numeric($id))
			{
				$response = $con->query("SELECT * FROM shopping_bags WHERE id=$id;");
				if ($row = $response->fetch_array())
				{
					$object = Bag::getFromRow($row);
					return $object;
				}
			}
		} else
		{
			$objects = array();
			if (!isset($cart_id))
			{
				if (!isset($owner_id))
					$response = $con->query("SELECT * FROM shopping_bags;");
				else
					if (is_numeric($owner_id))
						$response = $con->query("SELECT * FROM shopping_bags WHERE cart_id IN (SELECT id FROM shopping_carts WHERE owner_id = $owner_id);");
					else
						$response = $con->query("SELECT * FROM shopping_bags WHERE cart_id IN (SELECT id FROM shopping_carts WHERE owner_id = (SELECT id FROM users WHERE username='$owner_id'));");
			}
			else
			{
				if (is_numeric($cart_id))
					$response = $con->query("SELECT * FROM shopping_bags WHERE cart_id = $cart_id;");
			}
			if (isset($response))
			{
				while ($row = $response->fetch_array())
				{
					$objects[] = Bag::getFromRow($row);
				}
			}
			return $objects;
		}
	}
	public function write()
	{	
	}
	public static function getFromRow($row)
	{
		$object = new Bag($row['cart_id'], $row['shop_id'], $row['active']);
		$object->init($row);
		return $object;
	}
	public static function validate($object)
	{
	}
}

class BagItem extends Item
{
	public $bag_id, $item_id, $cnt;
	public function __construct($bag_id, $item_id, $cnt, $shop_id = null, $name = null, $sku = null, $short_desc = null, $long_desc = null)
	{
		parent::__construct($shop_id, $name, $sku, $short_desc, $long_desc);
		$this->bag_id = $bag_id;
		$this->item_id = $item_id;
		$this->cnt = $cnt;
	}
	function getItemCount($item_id)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT cnt FROM bag_items WHERE bag_id={$this->bag_id} AND item_id={$item_id}");
		if ($row = mysqli_fetch_array($response))
		{
			return $row['cnt'];
		} else
		{
			return 0;
		}
	}
	public static function get($id = null, $bag_id)
	{
		$con = BaseObject::$con;
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$response = $con->query("SELECT bag_items.*,items.* FROM bag_items INNER JOIN items ON bag_items.item_id=items.id WHERE bag_items.id=$id;");
				if ($row = $response->fetch_array())
				{
					$object = BagItem::getFromRow($row);
					return $object;
				}
			}
		} else
		{
			$objects = array();
			if (isset($bag_id))
			{
				$response = $con->query("SELECT bag_items.*,items.* FROM bag_items INNER JOIN items ON bag_items.item_id=items.id WHERE bag_items.bag_id = $bag_id;");
				$objects = array();
				while ($row = $response->fetch_array())
				{
					$objects[] = BagItem::getFromRow($row);
				}
			}
			return $objects;
		}
	}
	public function write()
	{	
	}
	public static function getFromRow($row)
	{	
		$object = new BagItem($row['bag_id'], $row['item_id'], $row['cnt'], $row['shop_id'], $row['name'], $row['sku'], $row['short_desc'], $row['long_desc']);
		$object->init($row);
		return $object;
	}
	public static function validate($object)
	{
		
	}
}