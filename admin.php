<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

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