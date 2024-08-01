<?php
$conn = mysqli_connect("localhost", "root", "", "tienda");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
