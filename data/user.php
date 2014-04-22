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
	public static function getUsername($id)
	{
		if (isset($id))
		{
			$sql = "SELECT username FROM users WHERE id = $id;";
			$response = BaseObject::$con->query($sql);
			if ($row = $response->fetch_array())
			{
				return $row['username'];
			}
		}
	}
	public static function getFromRow($row)
	{
		$user = new User($row['username'], $row['password'], $row['user_role'], $row['email'], $row['first'], $row['last']);
		$user->init($row);
		return $user;
	}
	public function write()
	{
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO users (username, password, user_role, email, first, last) VALUES (?,?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('ssisss', $this->username, $this->password, $this->user_role, $this->email, $this->first, $this->last);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$con = BaseObject::$con;
			$sql = "UPDATE users SET username = ?, password = ?, user_role = ?, email = ?, first = ?, last = ?) WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('ssisssi', $this->username, $this->password, $this->user_role, $this->email, $this->first, $this->last, $this->id);
			$stmt->execute();
			$stmt->close();
			return $id;
		}
	}
	public static function validate(User $user)
	{
		
	}
}