<?
require_once 'data.php';

class Friend
{
	public $user_id, $friend_id;
	public function __construct($user_id, $friend_id)
	{
		parent::__construct("friends", array("user_id", "friend_id"));
		$this->user_id = $user_id;
		$this->friend_id = $friend_id;
	}
	// List all friends for a given user
	public static function listAll($user_id)
	{
		$con = BaseObject::$con;
		$sql = "SELECT * FROM friends WHERE user_id={$user_id};";
		$result = mysqli_query($con, $sql);
		return $this->getFromResult($result);
	}
	public static function get($id)
	{
		
	}
	public static function friend($friend)
	{
		// Create in pairs
		$friend2 = new Friend($friend->friend_id, $friend_id);
		$friend = $friend.write();
		$friend2.write();
		// Post some kind of activity message
		return $friend;
	}
	public function unfriend()
	{
		$con = BaseObject::$con;
		$sql = "DELETE FROM friends WHERE user_id={$this->user_id} AND friend_id={$this->friend_id};";
		mysqli_query($con, $sql);
		$sql = "DELETE FROM friends WHERE user_id={$this->friend_id} AND friend_id={$this->user_id};";
		mysqli_query($con, $sql);
	}
	public function write()
	{	
	}
	public function getFromRow($row)
	{	
	}
	public function isFriend($id)
	{
	}
}