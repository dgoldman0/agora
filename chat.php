<?
require_once 'data.php';
require_once 'view/chat.php';

if ($action = $_GET['action'])
{
	if ($action == "send")
	{
		$from = $mraket->getUserID();
		$to = $_GET['to'];
		if ($market->userRoleIncludes(0) || $market->areFriends($from, $to))
		{
			$market->addActivity(new Activity(null, $from, $to, 0, Activity::ACTIVITY_TYPE_MESSAGE, Activity::PRIVACY_LEVEL_FRIEND, $_GET['message']));
		}
	} else if ($action == "check")
	{
		
	}
}
