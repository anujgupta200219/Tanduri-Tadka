<?php
session_start();
if (!isset($_SESSION['restemail'])) {
    header("location: rest_login.php");
}
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";
$conn = mysqli_connect($servername, $username, $password, $database);
$insert = false;
$delete = false;
$edit = false;
$present = false;

$t=$_SESSION['restgst'];


if (isset($_GET['rdel'])) {
    if ($_GET['rdel'] == 1) {
        $g = substr($t, 1);

        $sql = "select * from rest where gstno = '$g'";
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $path=$row['image'];
        }
        unlink($path);
        
        $sql = "DELETE from rest where gstno='$g'";
        $result = mysqli_query($conn, $sql);

        $sql = "DROP table $t";
        $result = mysqli_query($conn, $sql);

        $folder = "Menu/$t";
        rmdir($folder);
        header("location: logout.php");
    }
}


$str = substr($t, 1);
$sql = "select * from rest where gstno='$str'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $td = $row['image'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['hi'])) {
        $hi = $_POST["hi"];
        $name = $_POST["nameedit"];
        $price = $_POST["priceedit"];

        $filename = $_FILES["imageedit"]["name"];
        $tempname = $_FILES["imageedit"]["tmp_name"];
        $folder = "Menu/$t/" . $filename;
        move_uploaded_file($tempname, $folder);

        $sql = "UPDATE $t SET photo='$folder', name='$name', price='$price' where sno='$hi'";
        $result = mysqli_query($conn, $sql);
        $edit = true;
    }

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "Menu/$t/" . $filename;

        $sql = "SELECT * from $t where name='$name'";
        $result = mysqli_query($conn, $sql);
        $resu = mysqli_num_rows($result);

        if ($resu > 0) {
            $present = true;
        } else {
            move_uploaded_file($tempname, $folder);

            $sql = "insert into $t (photo, name, price) values('$folder','$name','$price')";
            $result = mysqli_query($conn, $sql);
            $insert = true;
        }
    }
    if (isset($_POST['search'])) {
        $sr = $_POST['search'];
    }
}

if (isset($_GET['delete'])) {
    $item = $_GET['delete'];
    $sql = "delete from $t where sno='$item'";
    $result = mysqli_query($conn, $sql);
    $delete = true;
}
if ($insert) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    Inserted Successfully
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    $insert = false;
}
if ($delete) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    Deleted Successfully
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    $delete = false;
}
if ($edit) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    Edited Successfully
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    $edit = false;
}
if ($present) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    Already Present in Menu
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    $edit = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="rest_view.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    echo '<form action="/project1/rest_view.php" id="mod" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hi" name="hi">
                <h5><b>Name:<span class="formerror">*</span></b></h5><input type="text" id="nameedit" name="nameedit" required><br>
                <h5><b>Price:<span class="formerror">*</span></b></h5><input type="number" id="priceedit" name="priceedit" required><br>
                <h5><b>Image:<b><span class="formerror">*</span></b></h5><input type="file" accept="image/*" id="imageedit" name="imageedit" required><br>
            

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <nav id="navbar">
        <div class="logo">
            <h1>TanduriTadka</h1>
        </div>
        <span class="data">
            <li class="item"><a href="first.php" id="addrest">Home</a></li>
            <li class="item"><a href="logout.php" id="addrest">Logout</a></li>
            <li class="item"><img src="<?php echo $td; ?>" alt=""></li>
        </span>
    </nav>

    <section class="add">
        <div class="bord">
            <h4 class="menu"><b>Add Menu</b></h4>
            <?php
            echo '<form action="/project1/rest_view.php" id="reg" method="post" enctype="multipart/form-data">
                <h5><b>Name:<span class="formerror">*</span></b></h5><input type="text" id="name" name="name" required><br>
                <h5><b>Price:<span class="formerror">*</span></b></h5><input type="number" id="price" name="price" required><br>
                <h5><b>Image:<b><span class="formerror">*</span></b></h5><input type="file" accept="image/*" id="image" name="image" required><br>
                <button type="submit" id="submit" name="submit"><b>Submit</b></button>
                <button type="reset" id="reset" name="reset"><b>Reset</b></button>
            </form>';
            ?>
        </div>
    </section>

    <section class="tab">
        <div class="me">
            <h2><b>Menu</b></h2>
        </div>
        <div class="search">
            <?php
            echo '
            <form action="/project1/rest_view.php" method="post"  id="searchform" enctype="multipart/form-data">
                <input type="text" id="search" name="search" placeholder="Type here to search">
                <input type="submit" value="Go" id="searchsubmit" name="searchsubmit">
            </form>'
            ?>
        </div>
        <div class="table">
            <table>
                <tr id="hd">
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                <?php
                $t = $_SESSION['restgst'];
                if (isset($_POST['search'])) {
                    $sr = $_POST['search'];
                } else $sr = "";

                if ($sr != "") {
                    $sql = "SELECT * from $t where name regexp '$sr' ";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) == 0) {
                        echo "<h2 id='nothing'>No relevant result found</h2>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td><img id='ph' src='" . $row['photo'] . "'></td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['price'] . "</td>
                            <td><button class='edit' id=e" . $row['sno'] . ">Edit</button> <button class='delete' id=d" . $row['sno'] . ">Delete</button></td>
                          </tr>";
                        }
                    }
                } else {
                    $sql = "select * from $t";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) == 0) {
                        echo "<h2 id='nothing'>Nothing to Display</h2>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                        <td><img id='ph' src='" . $row['photo'] . "'></td>
                        <td>" . $row['name'] . "</td>
                        <td>₹" . $row['price'] . "</td>
                        <td><button class='edit' id=e" . $row['sno'] . ">Edit</button> <button class='delete' id=d" . $row['sno'] . ">Delete</button></td>
                      </tr>";
                        }
                    }
                }
                ?>
            </table>
        </div>
    </section>
    <section class="restdelete">
        <button class="resdel" onclick="myfunc()">Delete Restaurant</button>
    </section>
    <footer>
        <div class="center">
            Copyright &copy; www.tanduritadka.com. All Right reserved
        </div>
    </footer>
</body>

<script>
    
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("delete", e.target);
            name = e.target.id.substr(1);
            if (confirm("Are you sure you want to delete this item!")) {
                console.log("yes");
                window.location = `/project1/rest_view.php?delete=${name}`;
            } else {
                console.log("no");
            }
        })
    });
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            tr = e.target.parentNode.parentNode;
            name = tr.getElementsByTagName("td")[1].innerText;
            price = tr.getElementsByTagName("td")[2].innerText;
            nameedit.value = name;
            priceedit.value = price.substr(1);
            hi.value = e.target.id.substr(1);
            console.log(hi.value);
            $('#editmodal').modal('toggle');
        })
    });

    restd = document.getElementsByClassName('resdel');
    restd.addEventListener("click", myfunc);

    function myfunc() {
        rdel = 0;
        if (confirm("Are you sure you want to delete this restaurant")) {
            rdel = 1
            window.location = `/project1/rest_view.php?rdel=${rdel}`;
        }

    }
</script>

</html>