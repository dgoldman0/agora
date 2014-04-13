<?require_once 'data.php'?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/agora.css" rel="stylesheet">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.0.20/tinymce.min.js"></script>
	</head>
	<body>
		<div class="container col-md-12">
			<?include "view/_menu.php"?>
			<?include "view/$view.php"?>
		</div>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
		      </div>
		      <div class="modal-body">
		        ...
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary">Save changes</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="js/jasny-bootstrap.min.js"></script>
		<script src="js/agora.js"></script>
		<script src="js/activity.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#login').click(function (event) {
					var that = this;
					event.preventDefault();
					$.get(that.href, { format: 'modal'}, function(data){
						var login = $("#myModal");
						$('.modal-content', login).html(data);
						login.modal('show');
					})
				});
			});	
		</script>
		<!--Single Use Scripts-->
		<?
		if (function_exists('javascripts'))
		{
			javascripts();
		}
		?>
	</body>
</html>