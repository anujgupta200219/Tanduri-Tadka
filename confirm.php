<?php
session_start();
if (!isset($_SESSION['useremail'])) {
    header("location: userlogin.php");
}
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";
$conn = mysqli_connect($servername, $username, $password, $database);

$table = "cart" . $_SESSION['phoneno'];
$sql = "TRUNCATE table $table";
$result = mysqli_query($conn, $sql);

$email=$_SESSION['useremail'];
$sql = "SELECT * from  user where emailid='$email'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $img = $row['image'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="confirm.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <nav id="navbar">
        <div class="logo">
            <h1>TanduriTadka</h1>
        </div>
        <span class="data">
            <li class="ite"><a href="first.php" id="addrest">Home</a></li>
            <li class="ite"><a href="logout.php" id="addrest">Logout</a></li>
            <li class="ite"><img src=" <?php echo $img;?>" alt=""></li>
        </span>
    </nav>
    <section class="order">
        <div class="container">
            <div class="box">
                <h2>Your Order has been received</h2>
                <img src="allimg/tick.jpg" alt="">
                <h2>Thanks for your purchase !</h2>
                <p>You will receive an email with details of your Order.</p>
                <button id="continue" onclick="redirect()">Continue</button>
            </div>
        </div>
    </section>

</body>
<script>
    function redirect(){
        window.location = `/project1/foodres.php`;
    }
</script>

</html>