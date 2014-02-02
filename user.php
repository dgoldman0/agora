<?php
include 'data.php';
include 'include/header.php';
include 'menu.php';
$user = $_GET['user'];
if ($user == "")
{
	// Get user list	
	$users = $market->getUserList();
} else
{
	// Get single user display
}
include 'include/footer.php';
?>