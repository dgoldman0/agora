<?
require_once 'data.php';
require_once 'view/activity/_base.php';

$static = Activity::$_static;
if ($user)
	$activities = $static.get();
else

	$activities = $static.getByPrivacyLevel(); 
?>