<?
require_once 'data.php';

function printBoard($board)
{
	?>
	<div class="container board">
		<?
		$fliers = $board::getFliers();
		foreach ($fliers as $flier)
		{
			include 'view/flier/mini.php';
		}
		?>
	</div>
	<?
}

if ($view == "user/board")
	printBoard($shop->getBoard());
?>