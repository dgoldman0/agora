<?
require_once 'data.php';
require_once 'views/friend.php';

if ($action = $_REQUEST['action'])
{
	// Search for possible friends
	if ($action == "search")
	{
		
	}
} else
{
	// List friends
	listFriends(Friend::listAll($market->getUserID()));
}
