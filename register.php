<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";
$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phoneno = $_POST['phoneno'];
    $location = $_POST['location'];
    $gstno = $_POST['gstno'];
    $emailid = $_POST['emailid'];
    $password = $_POST['password'];

    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "rest_img/" . $filename;

    $sql = "SELECT * from rest where phoneno='$phoneno'";
    $result = mysqli_query($conn, $sql);
    $phoner = mysqli_num_rows($result);

    $sql = "SELECT * from rest where gstno='$gstno'";
    $result = mysqli_query($conn, $sql);
    $gstr = mysqli_num_rows($result);

    $sql = "SELECT * from rest where emailid='$emailid'";
    $result = mysqli_query($conn, $sql);
    $emailr = mysqli_num_rows($result);

    if ($phoner > 0) {
        echo "<p class='nav'>Phone number already registered</p>";
    } elseif ($gstr > 0) {
        echo "<p class='nav'>GST number already registered</p>";
    } elseif ($emailr > 0) {
        echo "<p class='nav'>EmailID already registered</p>";
    } else {
        move_uploaded_file($tempname, $folder);
        $sql = "insert into rest values('$name','$phoneno','$location','$gstno','$emailid','$password','$folder')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $res="r".$gstno;
            mkdir("Menu/$res",0777,true);
            $sql = "CREATE table $res (sno int NOT NULL AUTO_INCREMENT PRIMARY KEY,photo varchar(400), name varchar(20), price int)";
            $create = mysqli_query($conn, $sql);
            header("location: rest_login.php");
        } else {
            echo "<p class='fail'>Failed</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="register.css">
</head>

<body>
    <nav id="navbar">
        <div class="logo">
            <h1>TanduriTadka</h1>
        </div>
        <span class="data">
            <li class="item"><a href="first.php" id="addrest">Home</a></li>
            <li class="item"><a href="rest_login.php" id="addrest">Login</a></li>
            <li class="item"><a href="restaurant.php" id="addrest">Back</a></li>
        </span>
    </nav>

    <section class="container">
        <div class="box">
            <div class="heading">
                <h1>Register your Restaurant</h1>
            </div>
            <form action="/project1/register.php" id="reg" name="reg" method="POST" onsubmit="return validate()" enctype="multipart/form-data">

                <h2>Name:<b><span class="formerror">*</span></b></h2><input type="text" id="name" name="name" required>
                <h2>Phone no.:<b><span class="formerror">*</span></b></h2> <input type="number" id="phoneno" name="phoneno" required>
                <h2>Location:<b><span class="formerror">*</span></b></h2> <input type="text" id="location" name="location" required>
                <h2>GST No.:<b><span class="formerror">*</span></b></h2> <input type="text" id="gstno" name="gstno" required>
                <h2>Email Id:<b><span class="formerror">*</span></b></h2> <input type="email" id="emailid" name="emailid" required>
                <h2>Password:<b><span class="formerror">*</span></b></h2> <input type="password" id="password" name="password" required>
                <h2>Upload image<b><span class="formerror">*</span></b></h2> <input type="file" accept="image/*" id="image" name="image" required><br>
                <span class="bt">
                    <button type="submit" id="submit">Submit</button>
                    <button type="reset" id="reset">Reset</button>
                </span>
            </form>

        </div>
    </section>
</body>
<script>
    function validate() {
        var phoneno = document.forms['reg']['phoneno'].value;
        var gstno = document.forms['reg']['gstno'].value;
        var pass = document.forms['reg']['password'].value;
        if (phoneno.length != 10) {
            var a = alert("Phone no should be of 10 digit");
            if (a) {
                return false;
            } else {
                return false;
            }
        } else if (gstno.length != 15) {
            var b = alert("GST no. should be of 15 digit");
            if (b) {
                return false;
            } else {
                return false;
            }
        } else if (!pass.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/)) {
            var b = alert("Password must contain 6 to 10 character with atleast one Uppercase, One Lowecase, One symbol, One Numeric digit");
            if (b) {
                return false;
            } else {
                return false;
            }
        } else return true;
    }
</script>

</html>