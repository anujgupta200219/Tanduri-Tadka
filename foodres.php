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

$t=$_SESSION['useremail'];

$sql = "select * from user where emailid='$t'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $td = $row['image'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="foodres.css">
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
            <li class="ite"><img src="<?php echo $td; ?>" alt=""></li>
        </span>
    </nav>
    <section id="ser">
        <div class="sb">
            <form action="foodres.php" method="post" id="searchform" enctype="multipart/form-data">
                <input type="text" id="search" name="search" placeholder="Whats in your mind today...">
                <input type="submit" value="Search" id="searchsubmit" name="searchsubmit">
            </form>
        </div>
    </section>

    <section id="items">
        <div class="sec">
            <div class="eat">
                <h2>Eat what Make's you Happy</h2>
                <h4>Scroll for more >>></h4>
            </div>
            <div class="wrapper">
                <div class="full">
                    <div class="item"><a href="foodres.php?item=paneer"><img src="food/paneer.png" alt="paneer"></a></div>
                    <div class="iname">Paneer</div>
                </div>
                <div class="full">
                    <div class="item"><a href="foodres.php?item=thali"><img src="food/thali.png" alt="paneer"></a></div>
                    <div class="iname">Thali</div>
                </div>
                <div class="full">
                    <div class="item"><a href="foodres.php?item=roll"><img src="food/roll.png" alt="paneer"></a></div>
                    <div class="iname">Rolls</div>
                </div>
                <div class="full">
                    <div class="item"><a href="foodres.php?item=pizza"><img src="food/pizza.png" alt="paneer"></a></div>
                    <div class="iname">Pizza</div>
                </div>
                <div class="full">
                    <div class="item"><a href="foodres.php?item=chowmein"><img src="food/chowmein.png" alt="paneer"></a></div>
                    <div class="iname">Chowmein</div>
                </div>
                <div class="full">
                    <div class="item"><a href="foodres.php?item=rice"><img src="food/friedrice.png" alt="paneer"></a></div>
                    <div class="iname">Fried Rice</div>
                </div>
                <div class="full">
                    <div class="item"><a href="foodres.php?item=cake"><img src="food/cake.png" alt="paneer"></a></div>
                    <div class="iname">Cake</div>
                </div>
                <div class="full">
                    <div class="item"><a href="foodres.php?item=sandwich"><img src="food/sandwich.png" alt="paneer"></a></div>
                    <div class="iname">Sandwich</div>
                </div>
            </div>
        </div>
    </section>

    <section id="data">
        <div class="sec">
            <div class="eat">
                <h2>Restaurants</h2>
            </div>
            <div class="container">
                    <?php
                    if(isset($_POST['searc'])){
                        $sr=$_POST['searc'];
                    }
                    else if (isset($_POST['search'])) {
                        $sr = $_POST['search'];
                    }
                    else if (isset($_GET['item'])) {
                        $sr = $_GET['item'];
                    } else $sr = "";

                    $sql = "SELECT * from rest where name regexp '$sr' ";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)){
                        echo '<div class="box" id=r'.$row['gstno'].' onclick=myfunc(this.id)>
                                <img src='.$row['image'].' alt="chowmein ">
                                <h2>'.$row['name'].'</h2>
                                <p>'.$row['location'].'</p>
                            </div>';
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
    function myfunc(clickeid) {
        window.location = `/project1/food.php?restid=${clickeid}`;
    }
</script>

</html>