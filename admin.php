<?php
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