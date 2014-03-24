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
	static function getUserByUsername($username)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT * from users WHERE username='{$username}';");
		if ($row = mysqli_fetch_array($response))
		{
			$user = new User($row['username'], $row['user_role'], '', $row['email'], $row['first'], $row['last'], $row['id']);
			return $user;
		}
	}
	// Deprecated
	static function getUserByID($id)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT * from users WHERE id={$id};");
		if ($row = mysqli_fetch_array($response))
		{
			$user = new User($row['username'], $row['user_role'], '', $row['email'], $row['first'], $row['last'], $row['id']);
			return $user;
		}
	}
	public static function get($id = null)
	{
		if ($id)
		{
			$con = BaseObject::$con;
			$response = $con->query("SELECT * from users WHERE id=$id;");
			if ($row = $response->fetch_array())
			{
				$user = getFromRow($row);
				$user.init();
				return $user;
			}
		}
	}
	public static function getFromRow($row) {}
	public static function write() {}
	public static function validate(User $user)
	{
		
	}
}
?>