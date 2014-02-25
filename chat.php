<?
require_once 'data.php';
require_once 'view/chat.php';

if ($action = $_GET['action'])
{
	if ($action == "send")
	{
		$from = $market->getUserID();
		if ($from != -1)
		{
			$to = $_GET['to'];
			if ($market->userRoleIncludes(0) || $market->areFriends($from, $to))
			{
				$market->addActivity(new Activity($from, $to, 0, Activity::ACTIVITY_TYPE_MESSAGE, $_GET['message'], Activity::PRIVACY_LEVEL_FRIEND));
			}
		} else
		{
			echo "Not logged in";
		}
	} else if ($action == "recent")
	{
		// Checks for recent messages
		$messages = $market->getRecentMessages($market->getUserID());
		pushMessages($messages);
	}
}
