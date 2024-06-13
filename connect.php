<?php
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "";
$port = 3307;
$database = "news_portal";

$dbc = mysqli_connect($servername, $username, $password, $database, $port);

if (!$dbc) {
    die('Error connecting to MySQL server: ' . mysqli_connect_error());
}

mysqli_set_charset($dbc, "utf8");

?>
