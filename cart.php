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

$email = $_SESSION['useremail'];
$sql = "SELECT * from  user where emailid='$email'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    $add = $row['location'];
    $img = $row['image'];
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
    <link rel="stylesheet" href="cart.css">
</head>

<body>
    <nav id="navbar">
        <div class="logo">
            <h1>TanduriTadka</h1>
        </div>
        <span class="data">
            <li class="ite"><a href="first.php" id="addrest">Home</a></li>
            <li class="ite"><a href="logout.php" id="addrest">Logout</a></li>
            <li class="ite"><img src=" <?php echo $img; ?>" alt=""></li>
        </span>
    </nav>

    <section class="items">
        <div class="cartimage">
            <p><img src="allimg/cartimg.png" alt=""></p>
            <p>Cart</p>
        </div>
        <div class="full">
            <div class="container">
                <table>
                    <tr id="hd">
                        <th>Item Details</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    <?php
                    $table = "cart" . $_SESSION['phoneno'];
                    $sql = "SELECT * from  $table";
                    $result = mysqli_query($conn, $sql);
                    $rows = mysqli_num_rows($result);
                    $total = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="box">
                        <tr id="items">
                        <td><img src=' . $row['photo'] . ' alt=""></td>
                        <td>' . $row['name'] . '</td>
                        <td>' . $row['quantity'] . '</td>
                        <td>₹' . $row['price'] . '</td>
                    </tr></div>';
                        $total += $row['quantity'] * $row['price'];
                    }

                    ?>
                </table>

            </div>
            <div id="description">
                <div class="desc">
                    <p>Description</p>
                </div>
                <div class="item">
                    <p class="gap">Items:</p>
                    <p id="item"><?php echo $rows; ?></p>
                </div>
                <div class="item">
                    <p class="gap">Delivery:</p>
                    <p id="item">Free</p>
                </div>
                <div class="subtotal">
                    <p class="gap">Subtotal:</p>
                    <p id="subtotal"><?php echo "₹" . $total . "/-"; ?></p>
                </div>
                <div class="name">
                    <p class="gap">Name:</p>
                    <p id="name"><?php echo $name; ?></p>
                </div>
                <div class="address">
                    <p class="gap">Address:</p>
                    <p id="address"><?php echo $add; ?></p>
                </div>
                <div class="order">
                    <button id="order" onclick="send()">Order Now</button>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://smtpjs.com/v3/smtp.js"></script>
<script>
    function send() {
        Email.send({
            Host: "smtp.elasticemail.com",
            Username: "tanduritadkafood@gmail.com",
            Password: "C022291796AC6B09F55C4B16E286D8CE49D6",
            To: '<?php echo "$email"; ?>',
            From: "tanduritadkafood@gmail.com",
            Subject: "Order Confirmation",
            Body: '<?php $sql = "SELECT * from  $table";
                    $result = mysqli_query($conn, $sql);
                    echo "Thank Your for using Tanduritadka!<br><br> Your Orders:<br><br>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "Item name: " . $row['name'] . "<br> Qty: " . $row['quantity'] . "<br> Total: ₹" . $row['price'] . "<br><br>";
                    }
                    echo "Grand Total: ₹".$total;
                    ?>'
        });
        window.location= `/project1/confirm.php`;
    }
</script>

</html>