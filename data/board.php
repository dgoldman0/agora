<?
require_once 'data.php';

class Board extends BaseObject
{
	public $shop_id, $title, $open, $abstract_only;
	function __construct($shop_id, $title, $open, $abstract_only, $is_default)
	{
		parent::__construct("board", array("shop_id", "title", "open", "abstract_only", "is_default"));
		$this->shop_id = $shop_id;
		$this->title = $title;
		$this->open = $open;
		$this->abstract_only = $abstract_only;
		$this->is_default = $is_defualt;
	}
	public function get($id)
	{
		
	}
	public function getFromRow($row)
	{
		$board = new Board($row['shop_id'], $row['title'], $row['open'], $row['abstract_only'], $row['default_board']);
		$board.init();
		return $board;
	}
	public function write()
	{
		
	}
	public function makeDefault()
	{
		// Make this board the default board for a store
	}
	public function getFliers()
	{
		$con = BaseObject::$con;
		$sql = "SELECT * FROM fliers WHERE board_id=$this->id";
		$res = $con->query($sql);
		$fliers = array();
		while ($row = $res->fetch_array())
		{
			$fliers[] = Flier::getFromRow($row);
		}
		return $fliers;
	}
}
