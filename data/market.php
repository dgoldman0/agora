<?php
require_once 'data.php';
// Basically move stuff from data.php and any general market related functionality here
class Market
{
	public $con, $shop, $session;
	public function __construct($con, $shop, $session)
	{
		$this->con = $con;
		$this->shop = $shop;
		$this->session = $session;
	}
	function getUserList($shop = 0)
	{
		$con = $this->con;
		$response = null;
		if ($shop == 0)
		{
			$response = mysqli_query($con, "SELECT id FROM users;");
		} else
		{
			$response = mysqli_query($con, "SELECT id FROM shop_users WHERE shop_id = ".$shop.";");
		}
		$users = array();
		while ($row = mysqli_fetch_array($response))
		{
			array_push($users, ($row['id']));
		}
		return $users;
	}
	function getUserInfo($user, $shop = 0)
	{
		$con = $this->con;
		$response = null;
		if ($shop == 0)
		{
			$response = mysqli_query($con, "SELECT * from users WHERE id=".$user.";");
		} else
		{
			$response = mysqli_query($con, "SELECT * FROM shop_users WHERE id=".$user." AND shop_id=".$shop.";");
		}
		return mysqli_fetch_array($response);
	}
}
	
}
?>