//var time = 0;
//var logoutCheck = setInterval(function() {displayKeepAliveAlert();}, time);

$( document ).ready(
function()
{
	$( "#checkall_master" ).click(function()
	{
		$( ".checkall_slave" ).prop("checked", $( "#checkall_master" ).prop("checked"));
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
function login(username, password)
{
	$.post( "login.php", {username: username, password: password}).done(function ( data ) {
		
	});
}
function getUsernameFromID(id)
{
	$.get( "user.php", {action: "gtusrname", id: id}).done(function ( data )
	{
		var result = JSON.parse( data );
		username = result.data;
	});
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
$ ( ".item_cnt" ).keypress(function(e) {
	if (e.which = 13)
	{
		// Update item quantities
		$.post( "cart.php?action=update").done(function ( data )
		{
			
		});
	}
});
*/
function displayCheckout()
{
	
}
$( document ).tooltip();
$( "#login" ).dialog({width: 600, modal: true});
$( "#checkout" ).click(function ()
{
	// Process checkout request
	displayCheckout();
});
