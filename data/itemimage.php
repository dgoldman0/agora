<?php
class ItemImage
{
	public $item_id, $medium_id, $id;
	public function __construct($item_id, $medium_id, $id)
	{
		
	}
	public function getMedium()
	{
		new Medium($row['name'], $row['type'], $row['alt_text'], $row['long_desc'], $row['id']);
	}
}
?>