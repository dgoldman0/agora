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
function addItem(sku, shop)
{
	$.get( "item.php", {action: 'addtobag', shop: shop, item: sku}).done(function ( data ) {
		$( "#bagadd" ).blur();
		var bag = JSON.parse( data );
		$( "#item_count" ).text(bag.item_count);
	}).fail(function () {
	});
}
function likeItem(sku, shop)
{
	$.get( "item.php", {action: 'like', shop: shop, item: sku});
	//.done(function( data ) {
//    alert( "Data Loaded: " + data );});
    var like = $( "#like");
    like.blur();
    if (like.attr('class') == 'glyphicon glyphicon-heart-empty')
    	like.attr('class', 'glyphicon glyphicon-heart');
    else
    	like.attr('class', 'glyphicon glyphicon-heart-empty');
}
/*
function addItem(sku, shop)
{
	$.get( "item.php", {action: 'addToBag', shop: shop, item: sku}).done(function ( data ) {
		var bag = JSON.parse( data );
		alert(data);
		#( "#item_count" ).text(bag.item_count);
	});
	$( "#bagadd" ).blur();
}
*/
$( document ).tooltip();
$( "#chat" ).dialog();
$( "#tabs" ).tabs();
