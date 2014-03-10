<?
require_once 'data.php';
class Activity extends BaseObject
{
	const ACTIVITY_TYPE_JOIN = 0;
	const ACTIVITY_TYPE_LIKE = 1;
	const ACTIVITY_TYPE_FRIEND_REQUEST = 2;
	const ACTIVITY_TYPE_FRIEND_ACCEPTED = 4;
	const ACTIVITY_TYPE_MESSAGE = 10;
	const ACTIVITY_TYPE_MESSAGE_READ = 11;
	const PRIVACY_LEVEL_PUBLIC = 0;
	const PRIVACY_LEVEL_FRIEND_OF_FRIEND = 1;
	const PRIVACY_LEVEL_FRIEND_PENDING = 2;
	const PRIVACY_LEVEL_FRIEND = 4;
	public $from_id, $to_id, $shop_id, $type, $content, $privacy_level;
	function __construct($from_id, $to_id, $shop_id, $type, $content, $privacy_level)
	{
		parent::__construct("activity", array("from_id", "to_id", "shop_id", "type", "content", "privacy_level"));
		$this->from_id = $from_id;
		$this->to_id = $to_id;
		$this->shop_id = $shop_id;
		$this->type = $type;
		$this->content = $content;
		$this->privacy_level = $privacy_level;
	}
	public static function get($id)
	{
		$con = BaseObject::$con;
		if ($id)
		{
			$sql = "SELECT * FROM activity WHERE id=$id;";
			return $this->getFromResult($con->query($sql));
		} else
		{
			$sql = "SELECT id FROM activity;";
			return $this->getAllFromResult($con->query($sql));
		}
	}
	public static function getByPrivacyLevel($privacy_level, $all_data)
	{
		$con = BaseObject::$con;
		if ($all_data)
			$sql = "SELECT * FROM activity WHERE privacy_level >= $privacy_level;";
		else
			$sql = "SELECT id FROM activity WHERE privacy_level >= $privacy_level";
		return $this->getAllFromresponse($con->query($sql));
	}
	public static function getFromRow($row)
	{
		$act = new Activity($row['from_id'], $row['to_id'], $row['shop_id'], $row['type'], $row['content'], $row['privacy_level']);
		$act.init();
		return $act;
	}
	public function write()
	{
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO activity (from_id, to_id, shop_id, type, content, privacy_level) VALUES (?,?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iiiisi', $this->from_id, $this->to_id, $this->shop_id, $this->type, $this->content, $this->privacy_level);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		}
	}
}