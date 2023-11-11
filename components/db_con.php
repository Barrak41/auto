<?php 

$db_name = "car_vista";
$db_username = "root";
$password = "";
$db_server = "localhost";

$db_conn = new PDO("mysql:host=$db_server;dbname=$db_name", $db_username, $password);

?>
