<?
require_once 'data.php';

class Board extends BaseObject
{
	public $shop_id, $title, $open;
	function __construct($shop_id, $title, $open)
	{
		parent::__construct("activity", array("shop_id", "title", "open"));
		$this->shop_id = $shop_id;
		$this->title = $title;
		$this->open = $open;
	}
	public function get($id)
	{
		
	}
	public function getFromRow($row)
	{
		
	}
	public function write()
	{
		
	}
	public function getFliers()
	{
		$con = BaseObject::$con;
		$sql = "SELECT * FROM fliers WHERE board_id=$this->id";
		$res = $con->query($sql);
		while ($row = $res->fetch_array())
		{
			
		}
	}
}
