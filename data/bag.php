<?
require_once 'data.php';
require_once 'baseobject.php';
// Shopping bag class
class Bag extends BaseObject
{
	// Structure
	public $cart_id, $shop_id, $active, $id;
	
	// Additional information: useful when pushing JSON data
	public $item_count;
	
	public function __construct($cart_id, $shop_id, $active = 0)
	{
		$this->cart_id = $cart_id;
		$this->shop_id = $shop_id;
		$this->active = $active;
		$this->item_count = 0;
	}
	public function getItemCount()
	{
		if (!$item_count && $id != -1)
		{
			global $market;
			$con = $market->con;
			$response = mysqli_query($con, "SELECT SUM(cnt) AS scnt FROM bag_items WHERE bag_id={$id}");
			if ($row = mysqli_fetch_array($response))
			{
				$this->item_count = $row['scnt'];
			}
		}
		return $item_count;
	}
	function addItem($item)
	{
		global $market;
		$con = $market->con;
		$response = mysqli_query($con, "INSERT INTO bag_items (bag_id, item_id) VALUES ({$this->id}, {$item->id}) ON DUPLICATE KEY UPDATE cnt = cnt + 1;");
		if ($row = mysqli_fetch_array($response))
		{
			return mysqli_insert_id($con);
		}
	}
	function getBagItems()
	{
		global $market;
		$con = $market->con;
		$response = mysqli_query($con, "SELECT * FROM bag_items WHERE bag_id={$this->id}");
		$items = array();
		while ($row = mysqli_fetch_array($response))
		{
			$items[] = new BagItem($row['bag_id'], $row['item_id'], $row['cnt'], $row['id']);
		}
		return $items;
	}
}
class BagItem
{
	public $bag_id, $item_id, $cnt, $id;
	public function __construct($bag_id, $item_id, $cnt, $id = -1)
	{
		$this->bag_id = $bag_id;
		$this->item_id = $item_id;
		$this->cnt = $cnt;
		$this->id = $id;
	}
	function getItemCount($item_id)
	{
		global $market;
		$con = $market->con;
		$response = mysqli_query($con, "SELECT cnt FROM bag_items WHERE bag_id={$this->bag_id} AND item_id={$item_id}");
		if ($row = mysqli_fetch_array($response))
		{
			return $row['cnt'];
		} else
		{
			return 0;
		}
	}
}