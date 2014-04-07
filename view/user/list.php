<?
require_once 'data.php';

$users = User::get();

print_r($users);
