<?
require_once 'data.php';

$action = $_REQUEST['action'];

if ($action == "new")
{
} else if ($action == "edit")
{
} else
{
	// Show activity stream and allow posting
	$view = "board/shop";
}
$include = "view/{$root}_base.php";
include $include;