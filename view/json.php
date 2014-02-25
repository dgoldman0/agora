<?
require_once 'data.php';
function jsonResponse($data)
{
	global $market;
	$uid = $market->getUserID();
	$encoded = "{ \"session_id\" : \"{$market->session_id}\",\r\n
		  \"user_id\" : \"{$uid}\",\r\n
		  \"data\" : {$data}}";
	return $encoded;
}

