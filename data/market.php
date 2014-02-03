<?php
require_once 'data.php';
require_once 'data/user.php';
// Basically move stuff from data.php and any general market related functionality here
class Market
{
	public $con, $shop, $session, $current_user;
	public function __construct($con, $shop, $session)
	{
		$this->con = $con;
		$this->shop = $shop;
		$this->session = $session;
		$this->current_user = User::getUserByID($this->getUserID());
	}
	function getUserList($all_info)
	{
		$con = $this->con;
		$users = array();
		$response = null;
		if ($all_info)
			$response = mysqli_query($con, "SELECT * FROM users;");
				else
			$response = mysqli_query($con, "SELECT id FROM users;");
		while ($row = mysqli_fetch_array($response))
		{
			if ($all_info)
			{
				array_push($users, new User($row['username'], $row['user_role'], '', $row['email'], $row['first'], $row['last'], $row['id']));
			} else
			{
				array_push($users, $row['id']);
			}
		}
		return $users;
	}
	function getUserID()
	{
		$session = $this->session;
		$con = $this->con;
		if ($session != 0)
		{
			$sql = "SELECT user, expires from sessions WHERE id='".$session."';";
			$response = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($response);
			if ($row["expires"] > time())
			{
				return $row["user"];
			}
		}
		return -1;
	}
}
?>