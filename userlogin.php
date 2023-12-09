<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";
$conn = mysqli_connect($servername, $username, $password, $database);

if(isset($_SESSION['useremail'])){
    header("location: foodres.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailid = $_POST['emailid'];
    $pass = $_POST['password'];

    $sql = "SELECT * from user where emailid='$emailid'";
    $result = mysqli_query($conn, $sql);
    $num=mysqli_num_rows($result);
    if($num==1){
        while($rows=mysqli_fetch_assoc($result)){
            if($pass==$rows['password']){
                $_SESSION['useremail']=$emailid;
                $_SESSION['phoneno']=$rows['phoneno'];
                header("location: foodres.php");
            }
            else{
                echo "<p class='fail'>Invalid Credential</p>";;
            }
        }
    }
    else{
        echo "<p class='nav'>You are not registered. Please register to continue</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="userlogin.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <nav id="navbar">
        <div class="logo">
            <h1>TanduriTadka</h1>
        </div>
        <span class="data">
            <li class="item"><a href="first.php" id="addrest">Home</a></li>
            <li class="item"><a href="signup.php" id="addrest">Sign Up</a></li>
            <li class="item"><a href="first.php" id="addrest">Back</a></li>
        </span>
    </nav>
    <section id="home">
        <div class="container">
            <div class="box">
                <div class="heading">
                    <h1>User Login</h1>
                </div>
                <form action="/project1/userlogin.php" method="post" id="reg">
                    <h2>Email Id:</h2> <input type="email" id="email" name="emailid"><br>
                    <h2>Password:</h2> <input type="password" id="password" name="password">
                    <button type="submit" id="submit">Submit</button>
                    <button type="reset" id="reset">Reset</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>