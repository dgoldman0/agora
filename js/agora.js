//var time = 0;
//var logoutCheck = setInterval(function() {displayKeepAliveAlert();}, time);

$( document ).ready(
function()
{
	$( "#checkall_master" ).click(function()
	{
		$( ".checkall_slave" ).prop("checked", $( "#checkall_master" ).prop("checked"));
	});
	$( "#autogenerate" ).click(function()
	{
		$( ".register-password-field" ).prop("disabled", $( "#autogenerate" ).prop("checked"));
		$( "#autogenerate" ).blur();
	});
});
function likeItem(sku, shop)
{
	$.get( "item.php", {action: 'like', shop: shop, item: sku}).done(function( data ) {
    alert( "Data Loaded: " + data );});
}
$( document ).tooltip();
$( "#chat" ).dialog();
$( "#tabs" ).tabs();
