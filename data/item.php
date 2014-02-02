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
	public function getItemImages($all_info)
	{
		global $con;
		$images = array();
		$response = null;
		if ($all_info)
			$response = mysqli_query($con, "SELECT * FROM item_images WHERE id=".$this->id.";");
				else
			$response = mysqli_query($con, "SELECT id FROM item_images WHERE id=".$this->id.";");
		while ($row = mysqli_fetch_array($response))
		{
			if ($all_info)
			{
				array_push($images, new ItemImage());
			} else
			{
				array_push($images, $row['id']);
			}
		}
		return $images;
	}
}
?>