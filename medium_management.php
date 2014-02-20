<?php
require_once 'data.php';

function displayAddMedium($shop)
{
	?>
	<div class="container">
		<form class="form-horizontal" action="register.php" method="post" id="register-form">
			<fieldset>
				<legend>Add Media</legend>
				<div id="get-media-file" class="form-group">
					<div class="col-md-6">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="input-group">
						   		<div class="form-control uneditable-input span3" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
								<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="filename"></span>
								<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						</div>
					</div>
				</div>
				<div id="media-edit-view" class="form-group">
					<img src="media.php?id=" alt="">
				</div>
				<div id="media-edit-info" class="form-group">
					<div class="col-md-2">
						
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<?
}
function displayMediaManagement($shop)
{
	?>
	<div class="container">
		<div class="row">
			<?
			// Display media
			$media = $shop->getMediaList(false);
			foreach ($media as $medium)
			{
				?>
				<div class="col-md-1">
					<img src="media.php?id=<?=$media->id?>" alt="<?=$media->alt_text?>">
				</div>
				<?
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