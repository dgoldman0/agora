<?
require_once 'data.php';
function displayCheckout()
{
?>
<div class="container">
	<form class="form-horizontal" action="login.php" method="post">
		<fieldset>
			<legend>Checkout</legend>
			<div class="form-group">
				<label class="col-md-2 control-label" for="method">Payment Method</label>
				<div class="col-md-4">
					<select class="form-control input-md" id="payment_method">
						<option value="new">New Payment Method...</option>
					</select>
				</div>
			</div>
			<fieldset id="new_payment" class="col-md-12">
				<div class="form-group">
					<label class="col-md-2 control-label" for="ccn">Credit Card Number</label>
					<input name = "ccn" id = "ccn" type = "password">
				</div>
			</fieldset>
		</fieldset>
	</form>
</div>
<?
}
if (!$action = $_GET['action'])
{
	include 'include/header.php';
	include 'menu.php';
	displayCheckout();
	include 'include/footer.php';
} else if ($action == "finalize")
{
	// Note: Mostly stubs and pseudocode right now
	// Generate order & invoices
	if ($market->addOrder(new Order()))
	{
		$order_num = mysqli_insert_id($con);
		if ($bags = $_POST['bags'])
		{
			// Generate invoices
			$c = count($bags); // Stores bag ID #
			for ($i = 0; $i < $c; $i++)
			{
				// Get payment method for bag
				if ($method = $_POST["method_{$bags[$i]}"]) // Stores the payment method ID #
				{
					$invoice = new Invoice();
					$invoice = $order->getInvoice($order->addInvoice($invoice));
					$invoice->addBagToInvoice($market->getBag($bags[$i]));
				}
			}
		}
	}
}
?>
