<?php
require_once 'data.php';

class User
{
	public $id;
	public $username;
	public $password;
	public $user_role;
	public $email;
	public $first;
	public $last;
	
	function __construct($username, $password, $user_role, $email, $first, $last, $id)
	{
		$this->username = $username;
		$this->password = $password;
		$this->user_role = $user_role;
		$this->email = $email;
		$this->first = $first;
		$this->last = $last;
		$this->id = $id;
	}
	static function addUser($usr)
	{
		global $con;
		$sql = "INSERT INTO users (username, password, user_role, email, first, last) VALUES ('".$usr->username."', SHA('".$usr->password."'), ".$usr->user_role.", '".$usr->email."', '".$usr->first."', '".$usr->last."');";
		mysqli_query($con, $sql);		
		// Should add a check to make sure it worked!
	}
	static function getUserByUsername($username)
	{
		global $con;
		$response = mysqli_query($con, "SELECT * from users WHERE username='".$username."';");
		if ($row = mysqli_fetch_array($response))
		{
			$user = new User($row['username'], $row['user_role'], '', $row['email'], $row['first'], $row['last'], $row['id']);
			return $user;
		}
	}
	static function getUserByID($id)
	{
		global $con;
		$response = mysqli_query($con, "SELECT * from users WHERE id='".$id."';");
		if ($row = mysqli_fetch_array($response))
		{
			$user = new User($row['username'], $row['user_role'], '', $row['email'], $row['first'], $row['last'], $row['id']);
			return $user;
		}
	}
}
?>