<?
require_once 'data.php';
require_once 'baseobject.php';
// Shopping bag class
class Bag extends BaseObject
{
	// Structure
	public $cart_id, $shop_id, $active;
	
	// Additional information: useful when pushing JSON data
	public $item_count;
	
	public function __construct($cart_id, $shop_id, $active = 0)
	{
		$this->cart_id = $cart_id;
		$this->shop_id = $shop_id;
		$this->active = $active;
		$this->item_count = null;
	}
	public function getItemCount()
	{
		if (!$item_count && $id != -1)
		{
			$con = $this->con;
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
		$con = $this->con;
		$response = mysqli_query($con, "INSERT INTO bag_items (bag_id, item_id) VALUES ({$this->id}, {$item->id}) ON DUPLICATE KEY UPDATE cnt = cnt + 1;");
		if ($row = mysqli_fetch_array($response))
		{
			return mysqli_insert_id($con);
		}
	}
	function getBagItems()
	{
		$con = $this->con;
		$response = mysqli_query($con, "SELECT * FROM bag_items WHERE bag_id={$this->id}");
		$items = array();
		while ($row = mysqli_fetch_array($response))
		{
			$item = new BagItem($row['bag_id'], $row['item_id'], $row['cnt']);
			$items[] = $item->init($row['id'], $row['created_on'], $row['updated_on']);
		}
		return $items;
	}
}
class BagItem extends BaseObject
{
	public $bag_id, $item_id, $cnt;
	public function __construct($bag_id, $item_id, $cnt)
	{
		$this->bag_id = $bag_id;
		$this->item_id = $item_id;
		$this->cnt = $cnt;
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