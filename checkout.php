<?
require_once 'data.php';
function displayCheckout()
{
?>
<div class="container">
	<form class="form-horizontal" action="login.php" method="post">
		<fieldset>
			<legend>Checkout</legend>
		</fieldset>
		<div class="form-group">
			<label class="col-md-2 control-label" for="method">Payment Method</label>
			<div class="col-md-4">
				<select class="form-control input-md" id="payment_method">
					<option>New Payment Method...</option>
				</select>
			</div>
		</div>
	</form>
</div>
<?
}
include 'include/header.php';
include 'menu.php';
displayCheckout();
include 'include/footer.php';
?>
