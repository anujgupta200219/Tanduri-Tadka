<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";
$conn = mysqli_connect($servername, $username, $password, $database);

$phoneno=99297468466;
$cart = "cart" . $phoneno;

$sql1 = "CREATE table $cart (photo varchar(400),name varchar(50),quantity int, price int";
$create = mysqli_query($conn, $sql1);
if ($create) {
    echo true;
} else {
    echo mysqli_error($conn);
}
