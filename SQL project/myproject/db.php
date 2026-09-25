<?php
// db.php
$conn = mysqli_connect("localhost", "root", "", "webtechdb");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
