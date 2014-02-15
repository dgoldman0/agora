<?
class Medium
{
	public $uploaded_on, $name, $type, $data, $alt_text, $long_desc, $id;
	public function __construct($uploaded_on, $name, $type, $data, $alt_text, $long_desc, $id)
	{
		$this->uploaded_on = $uploaded_on;
		$this->name = $name;
		$this->type = $type;
		$this->data = $data;
		$this->alt_text = $alt_text;
		$this->long_desc = $long_desc;
		$this->id = $id;
	}
}
?>
