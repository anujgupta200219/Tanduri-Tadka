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
    $emailid = $_POST['emailid'];
    $password = $_POST['password'];

    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "user_img/" . $filename;
    
    $sql = "SELECT * from user where phoneno='$phoneno'";
    $result = mysqli_query($conn, $sql);
    $phoner=mysqli_num_rows($result);
    

    $sql = "SELECT * from user where emailid='$emailid'";
    $result = mysqli_query($conn, $sql);
    $emailr=mysqli_num_rows($result);

    if ($phoner > 0) {
        echo "<p class='nav'>Phone number already registered</p>";
    } 
    elseif($emailr>0){
        echo "<p class='nav'>EmailID already registered</p>";
    }
    else {
        move_uploaded_file($tempname, $folder);
        $sql = "insert into user values('$name','$phoneno','$location','$emailid','$password','$folder')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $cart="cart".$phoneno;
            $sql1 = "CREATE table $cart (photo varchar(400),name varchar(50),quantity int, price int)";
            $create = mysqli_query($conn, $sql1);
            header("location: userlogin.php");
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
    <link rel="stylesheet" href="signup.css">
</head>

<body>
    <nav id="navbar">
        <div class="logo">
            <h1>TanduriTadka</h1>
        </div>
        <span class="data">
            <li class="item"><a href="first.php" id="addrest">Home</a></li>
            <li class="item"><a href="userlogin.php" id="addrest">Login</a></li>
            <li class="item"><a href="first.php" id="addrest">Back</a></li>
        </span>
    </nav>
    <div class="container">
        <div class="box">
            <div class="heading">
                <h1>Sign Up</h1>
            </div>
            <form action="/project1/signup.php" method="post" id="reg" onsubmit="return validate()" enctype="multipart/form-data">

                <h2>Name:<b><span class="formerror">*</span></b></h2><input type="text" id="name" name="name" required>
                <h2>Phone no.:<b><span class="formerror">*</span></b></h2> <input type="number" id="phone"name="phoneno" required>
                <h2>Location:<b><span class="formerror">*</span></b></h2> <input type="text" id="location" name="location" required>
                <h2>Email Id:<b><span class="formerror">*</span></b></h2> <input type="email" id="email" name="emailid" required><br>
                <h2>Password:<b><span class="formerror">*</span></b></h2> <input type="password" id="password" name="password"required>
                <h2>Upload Image<b><span class="formerror">*</span></b></h2> <input type="file" accept="image/*" id="image" name="image" required>
                <button type="submit" id="submit">Submit</button>
                <button type="reset" id="reset">Reset</button>
            </form>
        </div>
    </div>
</body>
<script>
    function validate() {
        var phoneno = document.forms['reg']['phoneno'].value;
        var pass = document.forms['reg']['password'].value;
        if (phoneno.length != 10) {
            var a = alert("Phone no should be of 10 digit");
            if (a) {
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
