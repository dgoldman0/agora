<?
class Cart
{
	public $owner_id, $name, $wishlist, $id;
	public function __construct($owner_id, $name, $wishlist, $id)
	{
		$this->owner_id = $owner_id;
		$this->name = $name;
		$this->wishlist = $wishlist;
		$this->id = $id;
	}
}
?>