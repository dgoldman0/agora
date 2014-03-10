<?
require_once 'data.php';
?>
<div class="container">
	<form class="form-horizontal" action="invite.php" method="post" id="register-form">
		<fieldset>
			<legend>Invite</legend>
			<div class="form-group">
				<label class="col-md-2 control-label" for="email">Email</label>
           	   	<div class="col-md-4">
					<input id="email" name="email" type="text" placeholder="Email" class="form-control input-md"/>
            	</div>
			</div>
			<!--
			<div class="form-group">
				<label class="col-md-12 control-label" for="message">Custom Message</label>
				<div class="col-md-12">
					<input id="message" name=""
				</div>
			</div>
			-->
			<div class="form-group">
				<label class="col-md-2 control-label" for="singlebutton">Send Invite</label>
				<div class="col-md-2">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary">Send Invite</button>
				</div>
			</div>
			<input type="hidden" name="action" value="send"/>
		</fieldset>
	</form>
</div>
