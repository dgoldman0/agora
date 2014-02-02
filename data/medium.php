<?
class Medium
{
	public $name, $type, $data, $alt_text, $long_desc, $id;
	public function __construct($name, $type, $data, $alt_text, $long_desc, $id)
	{
		$this->name = $name;
		$this->type = $type;
		$this->data = $data;
		$this->alt_text = $alt_text;
		$this->long_desc = $long_desc;
		$this->id = $id;
	}
}
?>
