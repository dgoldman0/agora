<?
class Activity
{
	const ACTIVITY_TYPE_NOTICE = 0;
	const PRIVACY_LEVEL_PUBLIC = 0;
	public $tstamp, $from_id, $to_id, $type, $content, $privacy_level, $id;
	function __construct($tstamp, $from_id, $to_id, $type, $content, $privacy_level, $id = -1)
	{
		$this->tstamp = $tstamp;
		$this->from_id = $from_id;
		$this->to_id = $to_id;
		$this->type = $type;
		$this->content = $content;
		$this->privacy_level = $privacy_level;
		$this->id = $id;
	}
}
?>