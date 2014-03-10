<?php
require_once 'data.php';
require_once 'view/user.php';

if ($action = $_GET['action'])
{
	if ($action == "gtusrname")
	{
		echo jsonResponse(json_encode(User::getUserByID($_GET['id'])->username));
	}
} else
{
	include 'include/header.php';
	include 'menu.php';
	$market->active="members";
	$username = $_GET['user'];
	if ($username == "")
	{
		// Get user list	
		$users = $market->getUserList(true);
		echo '<div class="row">';
		foreach ($users as $user)
		{
			printUserA($user);
		}
		echo '</div>';
	} else
	{
		// Get single user display
		$user = User::getUserByUsername($username);
		printUserB($user);
	}
	include 'include/footer.php';
}