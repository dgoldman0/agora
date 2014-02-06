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
			
	public $con, $shop, $session, $current_user, $active;
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
	function getMarketEmail()
	{
		$response = mysqli_query($this->con, "SELECT email FROM agora;");
		if ($row = mysqli_fetch_array($response))
		{
			return $row['email'];
		}
	}
	function getUserID()
	{
		$session = $this->session;
		$con = $this->con;
		if ($session != 0)
		{
			$sql = "SELECT user, expires FROM sessions WHERE id='{$session}';";
			$response = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($response);
			if ($row["expires"] > time())
			{
				return $row["user"];
			}
		}
		return -1;
	}
	// getActivity grabs the activity from a given user if from_id is not null
	// getActivity grabs all friend activity for a given user if from_id is null
	// grab the last x posts
	function getActivity($params)
	{
		$con = $this->con;
		$activity = array();
		$from_id = $params['from_id'];
		$to_id = $params['to_id'];
		$order = $params['order'];
		if (!$privacy_level = $params['privacy_level'])
			$privacy_level = 0;
		$sql = "SELECT * FROM activity WHERE privacy_level<={$privacy_level} AND from_id={$from_id}";
		if ($to_id != null) $sql = "{$sql} AND to_id={$to_id}";
		if ($order != null) $sql = "{$sql} ORDER BY tstamp {$order}";
		$sql = "{$sql};";
		$response = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_array($response))
		{
			array_push($activity, new Activity($row['tstamp'], $row['from_id'], $row['to_id'], $row['shop_id'], $row['type'], $row['content'], $row['privacy_level'], $row['id']));
		}
		return $activity;
	}
	function addActivity($activity)
	{
		$con = $this->con;
		$sql = "INSERT INTO activity (from_id, to_id, shop_id, type, content, privacy_level) VALUES ({$activity->from_id}, {$activity->to_id}, {$activity->shop_id}, {$activity->type}, '{$activity->content}', {$activity->privacy_level});";
		$response = mysqli_query($con, $sql);
	}
	function alreadyLiked($item)
	{
		$con = $this->con;
		$type = ACTIVITY::ACTIVITY_TYPE_LIKE;
		$sql = "SELECT id FROM activity WHERE content='{$item->sku}' AND type={$type} AND shop_id={$item->shop_id};";
		$response = mysqli_query($con, $sql);
		if ($row = mysqli_fetch_array($response))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function removeLike($item)
	{
		$con = $this->con;
		$type = ACTIVITY::ACTIVITY_TYPE_LIKE;
		$response = mysqli_query($con, "DELETE FROM activity WHERE content='{$item->sku}' AND type={$type} AND shop_id={$item->shop_id};");
	}
	function getPageByID($id)
	{
		$con = $this->con;
		$response = mysqli_query($con, "SELECT * FROM pages WHERE id={$id};");
		if ($row = mysqli_fetch_array($response))
		{
			return new Page($row['title'], $row['perma'], $row['shop_id'], $row['tstamp'], $row['content'], $row['type'], $row['id']);
		}
	}
	function getPageByPerma($perma, $use_shop = true)
	{
		$con = $this->con;
		$shop_id = 0;
		if ($use_shop && $this->shop)
			$shop_id = $this->shop->id;
		$response = mysqli_query($con, "SELECT * FROM pages WHERE perma='{$perma}' AND shop_id={$shop_id};");
		if ($row = mysqli_fetch_array($response))
		{
			return new Page($row['title'], $row['perma'], $row['shop_id'], $row['tstamp'], $row['content'], $row['type'], $row['id']);
		}
	}
	function getPageLinks($use_shop = false)
	{
		$con = $this->con;
		$shop_id = 0;
		if ($use_shop && $this->shop)
			$shop_id = $this->shop->id;
		$response = mysqli_query($con, "SELECT perma, title FROM pages WHERE shop_id={$shop_id};");
		$links = array();
		while ($row = mysqli_fetch_array($response))
		{
			array_push($links, new PageLink($row['perma'], $row['title']));
		}
		return $links;
	}
	function addPage($page)
	{
		$con = $this->con;
		$page = $page->makeInjectionSafe();
		$shop_id = $page->shop_id;
		if ($shop_id == -1)
			$shop_id = 0;
		$sql = "INSERT INTO pages (title, perma, shop_id, content, type) VALUES ('{$page->title}', '{$page->perma}', {$shop_id}, '{$page->content}', {$page->type});";
		$response = mysqli_query($con, $sql);
		return mysqli_insert_id($con);
	}
}
?>