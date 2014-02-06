<?php
// This will be changed so that all the admin functions will be sent to the client, and then jQuery will swap between "windows"
require_once 'administration.php';
include 'include/header.php';
include 'menu.php';
$market->active = "admin";
echo '<div class="row">';
displayAdminPanel();
echo '</div>';
include 'include/footer.php';
?>
