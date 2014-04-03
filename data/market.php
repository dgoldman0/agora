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
	function getMarketEmail()
	{
		$response = mysqli_query(BaseObject::$con, "SELECT email FROM agora;");
		if ($row = mysqli_fetch_array($response))
		{
			return $row['email'];
		}
	}
	public function write()
	{	
	}
	public static function get($id = null)
	{
		
	}
	public static function getFromRow($row)
	{	
	}
	public static function validate()
	{
		
	}
}