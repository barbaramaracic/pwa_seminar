<?php
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "";
$port = 3307;
$database = "news_portal";

// Create connection
$dbc = mysqli_connect($servername, $username, $password, $database, $port);

// Check connection
if (!$dbc) {
    die('Error connecting to MySQL server: ' . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($dbc, "utf8");

?>
