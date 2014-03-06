<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/agora.css" type="text/css" rel="stylesheet" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables.min.css" />
	</head>
	<body>
		<?include 'menu.php'?>
		<div class="container-fluid">
		    <div class="row-fluid">
    			<div class="span2">
    				<!--Sidebar content-->
    			</div>
    			<div class="span10">
					<?include "admin/$view.php"?>
    			</div>
    		</div>
    	</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="//code.jquery.com/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jasny-bootstrap.min.js"></script>
		<script src="js/agora.js"></script>
		<script src="js/opentip-jquery-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>
		<?
			foreach ($scripts as $script)
			{
				echo $script;
			}
		?>
	</body>
</html>