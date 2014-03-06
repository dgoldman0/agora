<?
require_once 'data.php';
require_once 'view/json.php';

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

// Allows printUserA to be called in other places
if ($view == "user/list")
{
	$market->active="members";
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
}