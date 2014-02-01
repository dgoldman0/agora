<?php
require_once 'data.php';

class Item
{
	public $shop_id, $name, $sku, $short_desc, $long_desc, $id;
	public function __construct($shop_id, $name, $sku, $short_desc, $long_desc, $id)
	{
		$this->shop_id = $shop_id;
		$this->name = $name;
		$this->sku = $sku;
		$this->short_desc = $short_desc;
		$this->long_desc = $long_desc;
		$this->id = $id;
	}
}
?>