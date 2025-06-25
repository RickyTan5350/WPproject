<?php
$host = 'sql306.byetcluster.com';
$db   = 'mseet_39296034_wp_db';
$user = 'mseet_39296034';
$pass = 'Rk1340925';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
