<?php
require_once 'data.php';
function printUserA($user)
{
	echo '<div class="col-md-4"><div class="panel panel-default"><div class="panel-heading"><a href="user.php?user='.$user->username.'">'.$user->username.'</a></div><div class="panel-body"><p>'.$user->first.' '.$user->last.'</p></div></div></div>';
}
function printUserB($user)
{
	echo '<div class="row">';
	echo '	<div class="col-md-4"><div class="panel panel-default"><div class="panel-heading"><a href="user.php?user='.$user->username.'">'.$user->username.'</a></div><div class="panel-body"><p>'.$user->first.' '.$user->last.'</p></div></div></div>';
	echo '	<div class="col-md-8><div class="panel panel-default"><div class="panel-heading"></div><div class="panel-body"><p></p></div></div>';
	echo '</div>';	
}
include 'include/header.php';
include 'menu.php';
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
?>