<?
require_once 'data.php';

function displayRestaurantSlider($shop)
{
	// Create a slider and display menus and specials
}

function displayHours($hours)
{
	echo "<table>";
		foreach ($hours as $day=>$times)
		{
			$first = true;
			foreach ($times as $time)
			{
				?>
				<tr>
					<td>
						<?= ($first) ? $day : ""?>
					</td>
					<td>
						<?=$time->open?> - <?=$time->close?>
					</td>
				</tr>
				<?
			}
		}
	echo "</table>";
}
// This function is mainly going to be called from shop.php
function displayRestaurant($shop)
{
	// Assume that the shop is a restaurant. Error checking will be in the outer layer
	displayRestaurantSlider($shop);
	// List hours and location information
?>
	<div class="row">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						Hours
					</div>
					<div class="panel-body">
						<?
						// Pull up hours
						displayHours($shop->getHours());
						?>
					</div>
				</div>
			</div>
	</div>
<?
}
?>