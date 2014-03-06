<?require_once 'data.php'?>
<table class="table table-striped">
	<thead><tr><th><input id="checkall_master" type="checkbox" class="form-control input-md"></th><th>Username</th><th>First</th><th>Last</th><th>Email</th><th>Role</th></tr></thead>
	<?php
	// Change this to Market->getUserList(true)
	$users = $market->getUserList(true);
	foreach ($users as $user)
	{
		?>
		<tbody>
		<tr>
			<td>
				<input id="check_<?=$user->id?>" type="checkbox" class="form-control input-md checkall_slave">
			</td>
			<td>
				<a href="user.php?user=<?=$user->username?>&edit=true"><?=$user->username?></a>
			</td>
			<td>
				<?=$user->first?>
			</td>
			<td>
				<?=$user->last?>
			</td>
			<td>
				<?=$user->email?>
			</td>
			<td>
				<?=$user->user_role?>
			</td>
		</tr>
		</tbody>
	<?php
	}
	?>
</table>