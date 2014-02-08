<?
require_once 'data.php';
// Shopping bag class
class Bag
{
	// Structure
	public $cart_id, $shop_id, $active, $id;
	
	// Additional information: useful when pushing JSON data
	public $item_count;
	
	public function __construct($cart_id, $shop_id, $active = 0, $id = -1)
	{
		$this->cart_id = $cart_id;
		$this->shop_id = $shop_id;
		$this->active = $active;
		$this->id = $id;
		$this->item_count = 0;
		if (id != -1)
		{
			global $market;
			$con = $market->con;
			$response = mysqli_query($con, "SELECT SUM(cnt) AS scnt FROM bag_items WHERE bag_id={$id}");
			if ($row = mysqli_fetch_array($response))
			{
				$this->item_count = $row['scnt'];
			}
		}
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
}
?>