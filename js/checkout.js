$( "#payment_method" ).change(function ()
{
	var option = $(this).val();
	if (option == "new")
	{
		$( "#new_payment" ).show();
	} else
	{
		$( "#new_payment" ).hide();
	}
});

