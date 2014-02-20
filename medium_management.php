<?php
require_once 'data.php';

function displayMediaManagement($shop)
{
	?>
	<div class="container">
		<div class="row">
			<?
			// Display media
			$media = $shop->getMediaList();
			foreach ($media as $medium)
			{
				
			}
			?>	
		</div>
	</div>
	<?
}
include 'include/header.php';
include 'menu.php';
$shop = $market->shop;
displayMediaManagement($shop);
include 'include/footer.php';
?>