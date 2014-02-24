<?
require_once 'data/baseobject.php';

class Activity extends BaseObject
{
	const ACTIVITY_TYPE_NOTICE = 0;
	const ACTIVITY_TYPE_LIKE = 1;
	const ACTIVITY_TYPE_FRIEND_REQUEST = 2;
	const ACTIVITY_TYPE_FRIEND_ACCEPTED = 4;
	const ACTIVITY_TYPE_MESSAGE = 10;
	const PRIVACY_LEVEL_PUBLIC = 0;
	const PRIVACY_LEVEL_FRIEND_OF_FRIEND = 1;
	const PRIVACY_LEVEL_FRIEND_PENDING = 2;
	const PRIVACY_LEVEL_FRIEND = 4;
	public $from_id, $to_id, $shop_id, $type, $content, $privacy_level, $id;
	function __construct($from_id, $to_id, $shop_id, $type, $content, $privacy_level, $id = -1)
	{
		$this->from_id = $from_id;
		$this->to_id = $to_id;
		$this->shop_id = $shop_id;
		$this->type = $type;
		$this->content = $content;
		$this->privacy_level = $privacy_level;
		$this->id = $id;
	}
}
?>