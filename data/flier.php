<?
require_once 'data.php';

// Page attached to a board
class Flier extends BaseObject
{
	public $board_id, $page_id, $posted_by;
	public function __construct($board_id, $page_id, $posted_by)
	{
		$this->board_id = $board_id;
		$this->page_id = $page_id;
		$this->posted_by = $posted_by;
	}
	public static function get($id)
	{
		
	}
	public static function getFromRow($row)
	{
		$flier = new Flier($row['board_id'], $row['page_id'], $row['posted_by']);
		$flier.init();
		return $flier;
	}
	public static function write()
	{
		
	}
}
