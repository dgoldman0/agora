<?php
require_once 'data.php';

if ($action = $_REQUEST['action'])
{
	if ($action == "gtusrname")
	{
//		echo jsonResponse(json_encode(User::getUserByID($_GET['id'])->username));
	} else if ($action == "edit")
	{
		$view="user/edit";
	}
} else
{
	if ($username || $id)
	{
		if ($username)
		{
			$user = User::getUserByUsername($username);
		} else
		{
			$user = User::getUserByID($id);
		}
		$view = "user/profile";
	}
	else
	{
		$view = "user/list";
	}
}
$format = $_REQUEST['format'];
if (!isset($format))
{
	$include = "view/{$root}_base.php";
} else if ($format == "modal")
{
	$include = "view/$view.php";
}
include $include;
