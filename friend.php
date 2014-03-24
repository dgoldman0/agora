<?
require_once 'data.php';

if ($action = $_REQUEST['action'])
{
	// Search for possible friends
	if ($action == "search")
	{
		$view = "friend/search";
	}
} else
{
	$view = "friend/list";
}
