<?
require_once 'data.php';
require_once 'view/json.php';

function printActivityBlock($user)
{
	
}
function printActivityEditor()
{
	
}
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