<?
class Activity
{
	const ACTIVITY_TYPE_NOTICE = 0;
	const ACTIVITY_TYPE_LIKE = 1;
	const ACTIVITY_TYPE_FRIEND_REQUEST = 2;
	const ACTIVITY_TYPE_FRIEND_ACCEPTED = 4;
	const PRIVACY_LEVEL_PUBLIC = 0;
	const PRIVACY_LEVEL_FRIEND_OF_FRIEND = 1;
	const PRIVACY_LEVEL_FRIEND_PENDING = 2;
	const PRIVACY_LEVEL_FRIEND = 4;
	public $tstamp, $from_id, $to_id, $shop_id, $type, $content, $privacy_level, $id;
	function __construct($tstamp, $from_id, $to_id, $shop_id, $type, $content, $privacy_level, $id = -1)
	{
		$this->tstamp = $tstamp;
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