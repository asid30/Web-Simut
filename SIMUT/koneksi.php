<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'simut';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_select_db($conn, $db);
?>