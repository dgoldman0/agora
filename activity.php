<?
require_once 'data.php';
require_once 'view/activity.php';

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
//			echo "Not logged in";
		}
	} else if ($action == "recent")
	{
		// Checks for recent messages
		// $recent = Activity::getRecentActivity();
		$messages = $market->getRecentMessages($market->getUserID());
		pushActivity($messages);
	} else if ($action == "poll")
	{
		// Close the session prematurely to avoid usleep() from locking other requests
		session_write_close();

		// Automatically die after timeout (plus buffer)
		set_time_limit(MESSAGE_TIMEOUT_SECONDS+MESSAGE_TIMEOUT_SECONDS_BUFFER);
	 
		// Counter to manually keep track of time elapsed (PHP's set_time_limit() is unrealiable while sleeping)
		$counter = MESSAGE_TIMEOUT_SECONDS;
	 
		// Poll for messages and hang if nothing is found, until the timeout is exhausted
		while($counter > 0)
		{
		    // Check for new data (not illustrated)
		    // if($data = SessionNotification::getAll($market->session))
		    if($data = $market->getSessionNotifications($market->session))
		    {
		        // Break out of while loop if new data is populated
		        break;
		    }
		    else
		    {
		        // Otherwise, sleep for the specified time, after which the loop runs again
		        usleep(MESSAGE_POLL_MICROSECONDS);
		 
		        // Decrement seconds from counter (the interval was set in μs, see above)
		        $counter -= MESSAGE_POLL_MICROSECONDS / 1000000;
		    }
		}
	 
		// If we've made it this far, we've either timed out or have some data to deliver to the client
		if(isset($data))
		{
		    // Send data to client; you may want to precede it by a mime type definition header, eg. in the case of JSON or XML
		    pushActivity($data);
		} else
		{
			http_response_code(202);
		}
	} else
	{
		// Show activity stream and allow posting
	}
}
