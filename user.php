<?php
require_once 'data.php';
function printUserA($user)
{
	?>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="user.php?user=<?=$user->username?>">
					<?=$user->username?>
				</a>
			</div>
			<div class="panel-body">
				<p><?=$user->first?> <?=$user->last?></p>
			</div>
		</div>
	</div>
	<?
}
function printUserB($user)
{
	?>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="user.php?user=<?=$user->username?>"><?=$user->username?></a>
				</div>
				<div class="panel-body">
					<p><?=$user->first?> <?=$user->last?></p>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Public Feed
				</div>
				<div class="panel-body">
					
				</div>
			</div>
		</div>
	</div>	
	<?
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