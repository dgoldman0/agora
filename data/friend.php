<?
require_once 'data.php';

class Friend extends User
{
	public $user_id, $friend_id;
	public function __construct($user_id, $friend_id, $username, $password, $user_role, $email, $first, $last)
	{
		parent::__construct("friends", array("user_id", "friend_id"));
		$this->user_id = $user_id;
		$this->friend_id = $friend_id;
	}
	public static function get($id, $user_id, $friend_id)
	{
		$con = BaseObject::$con;
		if (isset($id))
		{
			$sql = "SELECT users.*, friends.* FROM friends INNER JOIN users ON friends.id=users.id WHERE friends.id = $id;";
			$result = mysqli_query($con, $sql);
			if ($row = $result->fetch_array())
				return Friend::getFromRow($row);
		} else
		{
			if (isset($user_id))
			{
				if (isset($friend_id))
				{
					$sql = "SELECT users.*, friends.* FROM friends INNER JOIN users ON friends.id=users.id WHERE friends.user_id=$user_id AND friends.friend_id = $friend_id;";
					$result = mysqli_query($con, $sql);
					if ($row = $result->fetch_array())
						return Friend::getFromRow($row);
				} else
				{
					$objects = array();
					$sql = "SELECT users.*, friends.* FROM friends INNER JOIN users ON friends.id=users.id WHERE friends.user_id=$user_id;";
					$result = mysqli_query($con, $sql);
					while ($row = $result->fetch_array())
						$objects[] = Friend::getFromRow($row);
					return $objects;
				}
			}
		}
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
		// There's no point in saving a live version since a different user_id or friend_id would mean a different object anyway
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO users (user_id, friend_id) VALUES (?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('ii', $this->user_id, $this->friend_id);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		}
	}
	public static function getFromRow($row)
	{
		$friend = New Friend($row['user_id'], $row['friend_id'], $row['username'], $row['password'], $row['user_role'], $row['email'], $row['first'], $row['last']);
		$friend.init($row);	
		return $friend;
	}
}