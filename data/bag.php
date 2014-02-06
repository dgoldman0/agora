<?
// Shopping bag class
class Bag
{
	public $cart_id, $store_id, $id;
	public function __construct($cart_id, $store_id, $id)
	{
		$this->cart_id = $cart_id;
		$this->store_id = $store_id;
		$this-> id = $id;	
	}
}
class BagItem
{
	public $bag_id, $item_id, $public;
}
?>