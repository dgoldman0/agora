<?
require_once 'data.php';
require_once 'view/activity/_base.php';

function printBoard($user)
{
	?>
	<div class="container">
		<?=printActivityEditor();?>
	</div>
	<?
}

if ($view == "user/board")
	printBoard($user);
?>