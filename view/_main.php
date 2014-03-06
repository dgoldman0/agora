<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/agora.css" rel="stylesheet">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
		<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
	</head>
	<body>
		<!--
		<div id="login" class="container">
			<form class="form-horizontal" action="login.php" method="post">
				<fieldset>
					<legend>Agora Login</legend>
					<div class="form-group">
						<label class="col-md-2 control-label" for="username">Username</label>
						<div class="col-md-4">
							<input id="username" name="username" type="text" placeholder="Username" class="form-control input-md">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="password">Password</label>
						<div class="col-md-4"><input id="password" name="password" type="password" placeholder="Password" class="form-control input-md"></div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="singlebutton">Login</label>
						<div class="col-md-2">
							<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
						</div>
						<div class="col-md-2">
							<a href="register.php">Register</a>
						</div>
					</div>
				</fiedset>
			</form>
		</div>
		-->
		<div class="container">
			<?=include "view/$view.php"?>
		</div>
		<?=(isLoggedIn()) ? displayChat(): ''?>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="//code.jquery.com/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jasny-bootstrap.min.js"></script>
		<script src="js/agora.js"></script>
		<script src="js/activity.js"></script>
		<script src="js/opentip-jquery-min.js"></script>
		<script>
			$( document ).ready(function ()
			{
				$( "#<?=$market->active?>" ).addClass("active");
				loadNotificationManager();
			});
		</script>
	</body>
</html>