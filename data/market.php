<?php
require_once 'data.php';

// Basically move stuff from data.php and any general market related functionality here
class Market extends BaseObject
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
			
	public $shop, $session, $current_user, $active;
	public function __construct($shop, $session)
	{
		$this->shop = $shop;
		$this->session = $session;
		$this->current_user = User::getUserByID($this->getUserID());
	}
	function getUserList($all_info)
	{
		$con = BaseObject::$con;
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
	function getItemByID($id)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT * FROM items WHERE id={$id};");
		if ($row = mysqli_fetch_array($response))
		{
			return new Item($row['shop_id'], $row['name'], $row['sku'], $row['short_desc'], $row['long_desc'], $row['id']);
		}
	}
	function getMarketEmail()
	{
		$response = mysqli_query(BaseObject::$con, "SELECT email FROM agora;");
		if ($row = mysqli_fetch_array($response))
		{
			return $row['email'];
		}
	}
	function createNewCart($cart)
	{
		$response = mysqli_query(BaseObject::$con, "INSERT INTO shopping_carts (owner_id, name, wishlist, active) VALUES ({$cart->owner_id}, '{$cart->name}', {$cart->wishlist}, {$cart->active});");
		if ($row = mysqli_fetch_array($response))
		{
			return mysqli_insert_id($con);
		}
	}
	function getCart($cart_id)
	{
		$response = mysqli_query(BaseObject::$con, "SELECT * FROM shopping_carts WHERE id={$cart_id};");
		if ($row = mysqli_fetch_array($response))
		{
			return new Cart($row['owner_id'], $row['name'], $row['wishlist'], $row['active'], $row['id']);
		}
	}
	function getBag($bag_id)
	{
		$response = mysqli_query(BaseObject::$con, "SELECT * FROM shopping_bags WHERE id={$bag_id};");
		if ($row = mysqli_fetch_array($response))
		{
			$bag = new Bag($row['cart_id'], $row['shop_id'], $row['active']);
			return $bag->init($row);
		}
	}
	function getUserID()
	{
		if (!$current_user)
		{
			$session = $this->session;
			$con = BaseObject::$con;
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
		} else
		{
			return $current_user;
		}
	}
	function getCurrentUser()
	{
		return $this->current_user;
	}
	function alreadyLiked($item)
	{
		$con = BaseObject::$con;
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
		$con = BaseObject::$con;
		$type = ACTIVITY::ACTIVITY_TYPE_LIKE;
		$response = mysqli_query($con, "DELETE FROM activity WHERE content='{$item->sku}' AND type={$type} AND shop_id={$item->shop_id};");
	}
	// Gets the newest version by default
	function getPageByID($id)
	{
		$con = BaseObject::$con;
		$response = mysqli_query($con, "SELECT * FROM pages WHERE id={$id} ORDER BY tstamp DESC LIMIT 1;");
		if ($row = mysqli_fetch_array($response))
		{
			return new Page($row['title'], $row['perma'], $row['shop_id'], $row['tstamp'], $row['content'], $row['type'], $row['id']);
		}
	}
	// Gets the newest version by default
	function getPageByPerma($perma, $use_shop = true)
	{
		$con = BaseObject::$con;
		$shop_id = 0;
		if ($use_shop && $this->shop)
			$shop_id = $this->shop->id;
		$response = mysqli_query($con, "SELECT * FROM pages WHERE perma='{$perma}' AND shop_id={$shop_id} ORDER BY tstamp DESC LIMIT 1;");
		if ($row = mysqli_fetch_array($response))
		{
			return new Page($row['title'], $row['perma'], $row['shop_id'], $row['tstamp'], $row['content'], $row['type'], $row['id']);
		}
	}
	// This currently uses two separate queries. I want to combine this into a single query
	function getPageLinks($use_shop = false)
	{
		$con = BaseObject::$con;
		$shop_id = 0;
		if ($use_shop && $this->shop)
			$shop_id = $this->shop->id;
		$response = mysqli_query($con, "SELECT DISTINCT id FROM pages WHERE shop_id={$shop_id};");
		$links = array();
		while ($row = mysqli_fetch_array($response))
		{
			$resp = mysqli_query($con, "SELECT perma, title FROM pages WHERE id={$row['id']} ORDER BY tstamp DESC LIMIT 1;");
			if ($rrow = mysqli_fetch_array($resp))
				$links[] = new PageLink($rrow['perma'], $rrow['title']);
		}
		return $links;
	}
	function addPage($page)
	{
		$con = BaseObject::$con;
		$page = $page->makeInjectionSafe();
		$shop_id = $page->shop_id;
		if ($shop_id == -1)
			$shop_id = 0;
		if ($page->id == -1)
			$sql = "INSERT INTO pages (title, perma, shop_id, content, type) VALUES ('{$page->title}', '{$page->perma}', {$shop_id}, '{$page->content}', {$page->type});";
		else
		{
			// Change this to only if changes are made
			$sql = "INSERT INTO pages (id, title, perma, shop_id, content, type) VALUES ({$page->id}, '{$page->title}', '{$page->perma}', {$shop_id}, '{$page->content}', {$page->type});";
		}
		$response = mysqli_query($con, $sql);
		return mysqli_insert_id($con);
	}
	// This isn't even written correctly! Change this to do what it's supposed to do.
	// Might work now after changes have been made
	function userRoleIncludes($capability)
	{
		$con = BaseObject::$con;
		$id = $this->getUserID();
		if ($id != -1)
		{
			// Is the user an administrator
			$sql = "SELECT user_role FROM users WHERE id={$id} AND user_role=0;";
			$response = mysqli_query($con, $sql);
			if ($row = mysqli_fetch_array($response))
				return true;
	
			// If not, does the user's role include the requested permission
			$sql = "SELECT capability FROM user_role_capabilities WHERE capability={$capability} AND user_role={$role};";
			$response = mysqli_query($con, $sql);
			return $row = mysqli_fetch_array($response);
		}
	}
	function addOrder($order)
	{
		$con = BaseObject::$con;
		$sql = "INSERT INTO orders (user_id) VALUES ({$user->id})";
		$response = mysqli_query($con, $sql);
		if ($row = mysqli_fetch_array($response))
		{
			return mysqli_insert_id($con);
		}
	}
	// I should probably switch this to get recent notifications...
	function getRecentMessages($user_id)
	{
		$con = BaseObject::$con;
		mysqli_query($con, "LOCK TABLES activity, session_notifications WRITE;");
		$sql = "SELECT * FROM activity WHERE (type=10 OR TYPE=11) AND (from_id={$user_id} OR to_id={$user_id}) ORDER BY created_on asc;";
		$response = mysqli_query($con, $sql);
		$activity = array();
		while ($row = mysqli_fetch_array($response))
		{
			$act = new Activity($row['from_id'], $row['to_id'], $row['shop_id'], $row['type'], $row['content'], $row['privacy_level']);
			array_push($activity, $act->init($row));
		}
		$sql = "DELETE FROM session_notifications WHERE activity_id IN (SELECT id FROM activity WHERE type=10 OR TYPE=11 AND from_id={$user_id} OR to_id={$user_id} ORDER BY created_on desc) AND session_id='{$this->session}';";
		$result = mysqli_query($con, $sql);
		mysqli_query($con, "UNLOCK TABLES;");
		return $activity;
	}
	// getActivity grabs the activity from a given user if from_id is not null
	// getActivity grabs all friend activity for a given user if from_id is null
	// grab the last x posts.
	// Way too much redundancy with getRecentMessages, etc
	function getActivity($params)
	{
		$con = BaseObject::$con;
		$activity = array();
		$from_id = $params['from_id'];
		$to_id = $params['to_id'];
		$order = $params['order'];
		if (!$privacy_level = $params['privacy_level'])
			$privacy_level = 0;
		$sql = "SELECT * FROM activity WHERE privacy_level<={$privacy_level} AND from_id={$from_id}";
		if ($to_id != null) $sql = "{$sql} AND to_id={$to_id}";
		if ($order != null) $sql = "{$sql} ORDER BY created_on {$order}";
		$sql = "{$sql};";
		$response = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_array($response))
		{
			$act = new Activity($row['from_id'], $row['to_id'], $row['shop_id'], $row['type'], $row['content'], $row['privacy_level']);
			array_push($activity, $act->init($row));
		}
		return $activity;
	}
	function addActivity($activity)
	{
		$con = BaseObject::$con;
		$aid = $activity->write();
		// Push to active sessions, but only for certain activity subclasses
		$id = $this->getUserID();
		$sql = "INSERT INTO session_notifications (session_id, activity_id) (SELECT id, {$aid} FROM sessions WHERE user={$id} AND expires > unix_timestamp());";
		print_r($sql);
		mysqli_query($con, $sql);
		return $aid;
	}
	function getSessionNotifications($session)
	{
		$con = BaseObject::$con;
		// Thank you stackoverflow for this one
		mysqli_query($con, "LOCK TABLES activity, session_notifications WRITE;");
		$sql = "SELECT * FROM activity WHERE id IN (SELECT activity_id FROM session_notifications WHERE session_id='{$session}') ORDER BY created_on asc;";
		$result = mysqli_query($con, $sql);
		$activity = array();
		while ($row = mysqli_fetch_array($result))
		{
			$act = new Activity($row['from_id'], $row['to_id'], $row['shop_id'], $row['type'], $row['content'], $row['privacy_level']);
			$act->init($row);
			array_push($activity, $act);
		}
		$sql = "DELETE FROM session_notifications WHERE session_id='{$session}'";
		$result = mysqli_query($con, $sql);
		mysqli_query($con, "UNLOCK TABLES;");
		if (count($activity) > 0)
			return $activity;
		return null;
	}
	public function write()
	{	
	}
	public function get($id = null)
	{
		
	}
	public function getFromRow($row)
	{	
	}
	}