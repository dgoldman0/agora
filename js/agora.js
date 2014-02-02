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