<?
require_once 'data.php';

class Price
{
	public $item_id, $price_category, $currency, $value, $id;
	public function __construct($item_id, $price_category, $currency, $value, $id = -1)
	{
		$this->item_id = $item_id;
		$this->price_category = $price_category;
		$this->currency = $currency;
		$this->value = $value;
		$this->id = $id;
	}
	public function str()
	{
		return "$".substr($this->value, 0, -1);
	}
}
?>