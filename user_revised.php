<?php
require_once 'data.php';

if ($action = $_REQUEST['action'])
{
	if ($action == "gtusrname")
	{
//		echo jsonResponse(json_encode(User::getUserByID($_GET['id'])->username));
	} else if ($action == "register")
	{
		$root="main";
		$view="user/register";
	}
} else
{
	$root = "main";
	$username = $_REQUEST['username'];
	$id = $_REQUEST['id'];
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
include "view/_$root.php";
