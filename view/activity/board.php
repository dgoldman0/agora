<?
require_once 'data.php';

function printBoard($user)
{
	?>
	<div class="container">
		<?=printActivityEditor();?>
		<div class="container">
			<?
			?>
		</div>
	</div>
	<?
}

if ($view == "user/board")
	printBoard($user);
?>