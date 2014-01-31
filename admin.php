<?php
// This will be changed so that all the admin functions will be sent to the client, and then jQuery will swap between "windows"
require_once 'administration.php'
?>
<!DOCTYPE html><html><head>
<?php include 'include.php';?>
</head><body><div class="container">
<?php
include 'menu.php';
echo '<div class="row">';
displayAdminPanel();
echo '</div>';
?>
</div></body></html>