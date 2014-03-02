<?
require_once 'data.php';

function printFriend($friend)
{
	
}

function listFriends($friends)
{
	include 'include/header.php';
	include 'menu.php';
?>
<?
	foreach ($friends as $friend)
	{
		printFriend($friend);
	}
	include 'footer.php';
}
