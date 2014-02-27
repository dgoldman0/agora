<?
require_once 'data.php';
require_once 'activity.php';
?>
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