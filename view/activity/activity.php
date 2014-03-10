<?
require_once 'data.php';

function printActivityBlock($heading, $inner)
{
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
function printActivityEditor()
{
}