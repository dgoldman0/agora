<?
require_once 'data.php';
require_once 'data/shop.php';
require_once 'data/user.php';
require_once 'data/item.php';
require_once 'data/bag.php';

class Cart
{
	public $owner_id, $name, $wishlist, $active, $id;
	public function __construct($owner_id, $name, $wishlist = 0, $active = 0, $id)
	{
		$this->owner_id = $owner_id;
		$this->name = $name;
		$this->wishlist = $wishlist;
		$this->active = $active;
		$this->id = $id;
	}
	function getActiveBag($shop_id)
	{
		global $market;
		$con = $market->con;
		// Should I include AND cart_id = $id?
		$response = mysqli_query($con, "SELECT id FROM shopping_bags WHERE shop_id = {$shop_id} AND active = 1;");
		if ($row = mysqli_fetch_array($response))
			return $row['id'];
	}
	function getBags()
	{
		global $market;
		$con = $market->con;
		$response = mysqli_query($con, "SELECT id FROM shopping_bags WHERE cart_id={$this->id};");
		$bags = array();
		while ($row = mysqli_fetch_array($response))
		{
			$bags[] = $row['id'];
		}
		if (count($bags) > 0)
			return $bags;
	}
	function createNewBag($bag)
	{
		global $market;
		$con = $market->con;
		$response = mysqli_query($con, "INSERT INTO shopping_bags (cart_id, shop_id, active) VALUES ({$this->id}, {$bag->shop_id}, {$bag->active});");
		if ($row = mysqli_fetch_array($response))
		{
			return mysqli_insert_id($con);
		}
	}
}
?>