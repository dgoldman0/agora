<?
require_once 'data.php';

// Display activity editor if not modal
if ($format != "modal" && isset($_current_user))
{
	?>
	<div class="col-md-12">
		<form class="form-horizontal" action="activity.php?action=post" method="post">
			<legend>Post an Update</legend>
			<fieldset>
				<div class="form-group col-md-12">
					<textarea name="content" class="col-md-12 form-control" rows="3"></textarea>
				</div>
			</fieldset>
			<fieldset>
				<div class="col-md-2">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
				</div>
			</fieldset>
		</form>
		<hr/>
	</div>
	<?
}

$activity = Activity::getRecent();

?>
<div id="recentActivity" class = "container col-md-12">
<?
	foreach ($activity as $act)
	{
		$from_name = User::getUsername($act->from_id);
		$heading = "Activity from $from_name on $act->created_on";
		$inner = $act->content;
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?=$heading?>
				</div>
				<div class="panel-body">
					<p><?=$inner?></p>
				</div>
			</div>
		</div>
		<?
	}
?>
</div>