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
//    alert( "Data Loaded: " + data );});
    var like = $( "#like ");
    like.blur();
    if (like.attr('class') == 'glyphicon glyphicon-heart-empty')
    	like.attr('class', 'glyphicon glyphicon-heart');
    else
    	like.attr('class', 'glyphicon glyphicon-heart-empty');
}
$( document ).tooltip();
$( "#chat" ).dialog();
$( "#tabs" ).tabs();
