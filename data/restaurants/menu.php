<?
require_once 'data.php';
require_once 'data/restaurants/menu.php';

class Menu
{
	public $title, $description, $shop_id, $created_on, $id;
	function __construct($title, $description, $shop_id, $created_on, $id)
	{
		$this->title = $title;
		$this->description = $description;
		$this->shop_id = $shop_id;
		$this->created_on = $created_on;
		$this->id = $id;
	} 
}
?>