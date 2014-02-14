<?php
require_once 'data.php';
require_once 'data/price.php';

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
	function makeInjectionSafe()
	{
		global $market;
		$con = $market->con;
		return new Item($this->shop_id,
			mysqli_real_escape_string($con, $this->name),
			mysqli_real_escape_string($con, $this->sku),
			mysqli_real_escape_string($con, $this->short_desc),
			mysqli_real_escape_string($con, $this->long_desc),
			$this->id);
	}
	public function getItemImages($all_info)
	{
		global $market;
		$con = $market->con;
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
	public function removePrices()
	{
		global $market;
		$con = $market->con;
		$response = mysqli_query($con, "DELETE FROM item_prices WHERE item_id={$this->id};");
	}
	public function addPrice($price)
	{
		global $market;
		$con = $market->con;
		if ($this->id != -1)
		{
			$response = mysqli_query($con, "INSERT INTO item_prices (item_id, price_category, currency, value) VALUES ({$this->id}, {$price->price_category}, {$price->currency}, {$price->value});");
		}
	}
	// Only selects list price right now
	public function getPrice()
	{
		global $market;
		$con = $market->con;
		$response = mysqli_query($con, "SELECT * FROM item_prices WHERE item_id={$this->id} AND price_category=0;");
		if ($row = mysqli_fetch_array($response))
		{
			return new Price($row['item_id'], $row['price_category'], $row['currency'], $row['value'], $row['id']);
		}
		return new Price($this->id, 0, 1, '0.000', -1);
	}
}
?>