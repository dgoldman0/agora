<?
require_once 'data.php';
require_once 'view/json.php';

// Send messages in JSON format
function pushActivity($activities)
{
	global $market;
	$actcoded = "\"notifications\" : [";
	$first = true;
	$first1 = true;
	$first2 = true;
	$users = array();
	foreach ($activities as $activity)
	{
		if (!array_key_exists($activity->to_id))
		{
			$users[$activity->to_id] = User::getUserByID($activity->to_id)->username;
		}
		if (!array_key_exists($messages->from_id))
		{
			$users[$activity->from_id] = User::getUserByID($activity->from_id)->username;
		}
		$enc = $activity->jsonEncode();
		if ($first)
		{
			$first = false;
			$actcoded = "{$actcoded}\r\n{$enc}";
		} else
		{
			$actcoded = "{$actcoded}\r\n,{$enc}";
		}
	}
	$actcoded = $actcoded."]";
	$usrcoded = json_encode($users);
	$usrcoded = "\"usernames\" : {$usrcoded}";
	echo jsonResponse("{{$usrcoded},{$actcoded}}");
}

function displayChat()
{
?>
	<div class="navbar navbar-fixed-bottom dropup" id="chat">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#friends-collapse">
      	<span class="sr-only">Friends</span>
      	<span class="icon-bar"></span>
      	<span class="icon-bar"></span>
      	<span class="icon-bar"></span></button>
      	<a class="navbar-brand" href="#">Chat</a>
  	</div>

  	<!-- Collect the nav links, forms, and other content for toggling -->
  	<footer class="collapse navbar-collapse" id="friends-collapse">
    	<ul id="chat_bar" class="nav navbar-nav navbar">
		</ul>
    	<ul class="nav navbar-nav navbar-right">
	      	<li class="dropdown">
	        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Friends</a>
	        	<ul class="dropdown-menu">
				</ul>
			</li>
		</ul>
	</footer><!-- /.navbar-collapse -->
</div>
<?
}
