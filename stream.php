<?php
function printStreamUpdate($heading, $inner)
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
include 'include/header.php';
include 'menu.php';
?>
                <div class="jumbotron">
                        <h1><?=$market->current_user->username?>'s Stream...</h1>
                </div>
                <!-- Content Sections -->
				<div class="stream-container">
					<div class="row">
					</div>
				</div>
<?
include 'include/footer.php';
?>