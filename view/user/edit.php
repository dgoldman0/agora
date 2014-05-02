<?
require_once 'data.php';

function javascripts()
{
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#fb-disconnect").hide();
			$("#fb-connect").click(function(event){
				event.preventDefault();
				FB.login(function(response)
				{
					if (response.authResponse) {
						$('#fb-connect').hide();
						$('#fb-disconnect').show();
						
						// Add Facebook connection information to user info
						$.get("user.php", { action: "fb-connect", format: "json" }, 'json');
					} else
					{
						
					}
				});
			});
			$("#fb-disconnect").click(function(event){
				event.preventDefault();
				FB.api("/me/permissions", "delete", function (response)
				{
					$('#fb-connect').show();
					$('#fb-disconnect').hide();
					// Problem... FB does not recognize that it no longer has permission so I can't call FB.login again
					
					// Remove Facebook connection information from user info
					$.get("user.php", { action: "fb-disconnect", format: "json" }, 'json');
				});
			});
		})
		fbStuff = function(){
			FB.getLoginStatus(function(response) {
				if (response.status === 'connected') {
					$('#fb-connect').hide();
					$('#fb-disconnect').show();
			    } else {
					$('#fb-connect').show();
					$('#fb-disconnect').hide();
			    }
			});
		}
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '1432894966961399',
				xfbml      : true,
				version    : 'v2.0'
			});
			fbStuff();
		};
	
		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<?
}
?>

<div class = "col-md-2">
	
</div>
<div class = "well col-md-10">
	<legend>Change Password</legend>
	<form>
		<div class="form-group col-md-12">
			<label class="col-md-2 control-label" for="password1">Password</label>
			<div class="col-md-4"><input id="password1" name="password1" type="password" placeholder="Password" class="form-control input-md register-password-field"></div>
		</div>
		<div class="form-group col-md-12">
			<label class="col-md-2 control-label" for="password2">Repeat Password</label>
			<div class="col-md-4"><input id="password2" name="password2" type="password" placeholder="Repeat Password" class="form-control input-md register-password-field"></div>
		</div>
	</form>
	<legend>Third Party Connect</legend>
	<form>
		<div class="form-group col-md-12">
			<label class="col-md-2">Facebook</label>
			<div id="fb-connect" class="col-md-4"><a href="#" class="glyphicon glyphicon-remove-circle" title="Connect to Facebook"></a></div>
			<div id="fb-disconnect" class="col-md-4"><a href="#" class="glyphicon glyphicon-ok-circle" title="Disconnect from Facebook"></a></div>
		</div>
	</form>
	<legend>Demographics</legend>
</div>
