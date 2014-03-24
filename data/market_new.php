<?
require_once 'data.php';

class Market extends BaseObject
{
	public $shop, $session, $current_user, $active;
	public function __construct($shop, $session)
	{
		$this->shop = $shop;
		$this->session = $session;
		$this->current_user = User::getUserByID($this->getUserID());
	}
	public static function get($id) {}
	public static function getFromRow($row) {}
	public static function write() {}
}
