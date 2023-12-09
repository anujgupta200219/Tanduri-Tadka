<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";
$conn = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table="cart".$_SESSION['phoneno'];
// Retrieve data from the AJAX request
$name = $_POST['name'];
$photo = $_POST['photo'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];


// Perform SQL insertion (replace "your_table" with the actual table name)
$sql = "DELETE from $table where name='$name'";
if ($conn->query($sql) === TRUE) {
    // Send a success response to the client
    echo "Data deleted successfully";
} else {
    // Send an error response to the client
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
