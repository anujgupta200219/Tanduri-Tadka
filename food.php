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
$t = $_GET['restid'];
$gst = substr($t, 1);
$sql = "SELECT * from  rest where gstno='$gst'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $resname = $row['name'];
    $resadd = $row['location'];
    $resimg = $row['image'];
}
$user = $_SESSION['useremail'];
$sql = "SELECT * from  user where emailid='$user'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $imgsource = $row['image'];
}

$sql = "SELECT * from $t limit 2";
$result = mysqli_query($conn, $sql);
$i = 0;
$a;
$b;
while ($row = mysqli_fetch_assoc($result)) {
    if ($i == 0) {
        $a = $row['photo'];
        $i = $i + 1;
    } else {
        $b = $row['photo'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="food.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



    <nav id="navbar">
        <div class="logo">
            <h1>TanduriTadka</h1>
        </div>
        <div class="sb">
            <form action="foodres.php" method="post" id="searchform" enctype="multipart/form-data">
                <input type="text" id="search" name="searc" placeholder="Whats in your mind today...">
                <input type="submit" value="Search" id="searchsubmit" name="searchsubmit">
            </form>
        </div>
        <div class="data">
            <li><a href="cart.php" id=cart ><img id="cartimg" src="allimg/cart.png" alt=""></a></li>
            <li class="ite"><a href="first.php" class="addrest">Home</a></li>
            <li class="ite"><a href="logout.php" class="addrest">Logout</a></li>
            <li id="log"><img src="<?php echo $imgsource; ?>" alt=""></li>
        </div>
    </nav>

    <section class="rest">
        <div class="restcont">
            <div class="restimg">
                <div id="ft">
                    <img id="first" src="<?php echo $resimg; ?>" alt="" no-repeat center cover>
                </div>
                <div class="st">
                    <img id="second" src="<?php echo $a; ?>" alt="">
                    <img id="third" src="<?php echo $b; ?>" alt="">
                </div>
            </div>
            <div class="restname">
                <h2 class="name"><?php echo $resname; ?></h2>
                <h5 class="address"><?php echo $resadd; ?></h5>
            </div>
        </div>
    </section>

    <section id="data">
        <div class="sec">
            <div class="eat">
                <h1>Menu</h1>
            </div>
            <div class="container">
                <?php
                if (isset($_GET['restid'])) {
                    $t = $_GET['restid'];
                    $sql = "SELECT * from  $t";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="box" id=' . $row['sno'] . ' >
                                <img src=' . $row['photo'] . ' alt="chowmein ">
                                <h2>' . $row['name'] . '</h2>
                                <p>₹' . $row['price'] . '</p>
                                <div class="id">
                                    <span id="dec" class="decrease" >-</span>
                                     <span id="no" class="number">1</span>
                                     <span id="inc" class="increase">+</span>
                                </div>';

                        $tname = $row['name'];
                        $table="cart".$_SESSION['phoneno'];
                        $sql1 = "SELECT * from  $table where name='$tname'";
                        $result1 = mysqli_query($conn, $sql1);
                        $resu = mysqli_num_rows($result1);
                        if ($resu == 1) {
                            echo '
                                <button class="addtocart"style="padding: 5px 7px;
                                margin-left: 110px;
                                margin-top: 20px;
                                margin-bottom: 20px;
                                border-radius: 5px;
                                color: white;
                                background-color: green;
                                font-family: "poppins";
                                width: 100px;
                                font-size: 14px;>✓ Added</button>
                            </div>';
                        } else {
                            echo '
                                <button class="addtocart">Add to Cart</button>
                            </div>';
                        }
                    }
                }
                ?>
            </div>

        </div>
    </section>
    <footer>
        <div class="center">
            Copyright &copy; www.tanduritadka.com. All Right reserved
        </div>
    </footer>

</body>
<script>
    //---------------------------------------------------------------Addtocart---------------------------------------------------------//

    cart = document.getElementsByClassName('addtocart');
    Array.from(cart).forEach((element) => {
        element.addEventListener("click", (e) => {

            tr = e.target.parentNode;
            var photo = tr.getElementsByTagName("img")[0].src.substring(26);
            var name = tr.getElementsByTagName("h2")[0].innerText;
            var price = tr.getElementsByTagName("p")[0].innerText.substring(1);
            var quantity = tr.childNodes[7].childNodes[3].innerText;

            var no = tr.getElementsByTagName("button")[0];
            d = no.innerText;
            if (d == "Add to Cart") {
                no.innerText = "✓ Added";
                no.style.backgroundColor = "green";

                $.ajax({
                    type: 'POST',
                    url: 'insert.php',
                    data: {
                        photo: photo,
                        name: name,
                        price: price,
                        quantity: quantity
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            } else {
                no.innerText = "Add to Cart";
                no.style.backgroundColor = "rgb(65, 149, 213)";

                $.ajax({
                    type: 'POST',
                    url: 'delete.php',
                    data: {
                        photo: photo,
                        name: name,
                        price: price,
                        quantity: quantity
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        })
    });

    //-------------------------------------------------------------decrease------------------------------------------------------------//

    dec = document.getElementsByClassName('decrease');
    Array.from(dec).forEach((element) => {
        element.addEventListener("click", (e) => {
            tr = e.target.parentNode;
            var no = tr.getElementsByTagName("span")[1];
            a = no.innerText;
            if (a > 1 & a <= 10) {
                a--;
                no.innerText = a;
                ht = e.target.parentNode.parentNode;
                var price = ht.getElementsByTagName("p")[0];
                p = price.innerText.substring(1);
                pr = (p / (a + 1)) * a;
                console.log(pr);
                price.innerText = "₹" + pr;
            }
        })
    });

    //----------------------------------------------------------------increase--------------------------------------------------------//

    inc = document.getElementsByClassName('increase');
    Array.from(inc).forEach((element) => {
        element.addEventListener("click", (e) => {
            tr = e.target.parentNode;
            var no = tr.getElementsByTagName("span")[1];
            a = no.innerText;
            if (a > 0 & a < 10) {
                a++;
                no.innerText = a;

                ht = e.target.parentNode.parentNode;
                var price = ht.getElementsByTagName("p")[0];
                p = price.innerText.substring(1);

                pr = (p * a) / (a - 1);
                price.innerText = "₹" + pr;
            }

        })
    });
</script>

</html>