<?php
require_once 'data.php';
require_once 'data/user.php';
require_once 'data/activity.php';
// Basically move stuff from data.php and any general market related functionality here
class Market
{
	/*
	const USER_PERMISSION_VIEW_SHOP		= 4;
	const USER_PERMISSION_EDIT_SHOP		= 8;
	const USER_PERMISSION_VIEW_USER		= 16;
	const USER_PERMISSION_EDIT_USER		= 32;
	const USER_PERMISSION_EDIT_SHOP		= 64;
	const USER_PERMISSION_MODULE		= 128;
	const USER_PERMISSION_EDIT_ITEMS	= 256;
	*/
			
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
			$sql = "SELECT user, expires FROM sessions WHERE id='".$session."';";
			$response = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($response);
			if ($row["expires"] > time())
			{
				return $row["user"];
			}
		}
		return -1;
	}
	function getActivity($from_id, $to_id = null, $privacy_level = 0)
	{
		$session = $this->session;
		$con = $this->con;
		$activity = array();
		$sql = "SELECT * FROM activity WHERE privacy_level<=".$privacy_level." AND from_id=".$from_id;
		if ($to_id != null) $sql = $sql." AND to_id=".$to_id;
		$sql = $sql.";";
		$response = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_array($response))
		{
			
		}
	}
}
?>