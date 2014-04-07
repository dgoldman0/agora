<?php
require_once 'data.php';

class User extends BaseObject
{
	public $username;
	public $password;
	public $user_role;
	public $email;
	public $first;
	public $last;
	
	function __construct($username, $password, $user_role, $email, $first, $last)
	{
		$this->username = $username;
		$this->password = $password;
		$this->user_role = $user_role;
		$this->email = $email;
		$this->first = $first;
		$this->last = $last;
	}
	function getActiveCart()
	{
		$con = BaseObject::$con;
		$sql = "SELECT id FROM shopping_carts WHERE owner_id = {$this->id} AND active=true;";
		$response = mysqli_query($con, $sql);
		if ($row = mysqli_fetch_array($response))
		{
			return $row['id'];
		}
	}
	// Change this to write and make injection safe
	static function addUser($usr)
	{
		$con = BaseObject::$con;
		$sql = "INSERT INTO users (username, password, user_role, email, first, last) VALUES ('{$usr->username}', SHA2('{$usr->password}', 512), {$usr->user_role}, '{$usr->email}', '{$usr->first}', '{$usr->last}');";
		$con->query($sql);
		return $con->insert_id;
		// Should add a check to make sure it worked!
	}
	public static function get($id = null)
	{
		$con = BaseObject::$con;
		if ($id)
		{
			if (is_numeric($id))
			{
				$response = $con->query("SELECT * FROM users WHERE id=$id;");
			}
			else
			{
				$username = $con->real_escape_string($id);
				$response = $con->query("SELECT * FROM users WHERE username=$username;");
			}
			if ($row = $response->fetch_array())
			{
				$user = User::getFromRow($row);
				$user->init($row);
				return $user;
			}
		} else
		{
			$users = array();
			$response = $con->query("SELECT * FROM users;");
			while ($row = $response->fetch_array())
			{
				$users[] = User::getFromRow($row);
			}
			return $users;
		}
	}
	public static function getFromRow($row)
	{
		$user = new User($row['username'], $row['password'], $row['user_role'], $row['email'], $row['first'], $row['last']);
		$user->init($row);
		return $user;
	}
	public function write() {}
	public static function validate(User $user)
	{
		
	}
}
?>