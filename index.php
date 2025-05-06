<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(0);
include("connection/connect.php");
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Home</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="home">

    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/icn.png" alt=""> </a>
                <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home</a> </li>
                        <!-- Menu link -->
                        <li class="nav-item"> <a class="nav-link active" href="menu.php">Menu</a> </li>

                        <?php
                        if (empty($_SESSION["user_id"])) // if user is not logged in
                        {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
                              <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                        } else {
                            echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                            echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
                        }
                        ?>
                        <!-- Cart link -->
                        <li class="nav-item">
                            <a class="nav-link active" href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero bg-image" data-image-src="images/img/pimg.jpg">
        <div class="hero-inner">
            <div class="container text-center hero-text font-white">
                <h1>Order Delivery & Take-Out </h1>
                <div class="banner-form">
                    <form class="form-inline">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="bottom-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 payment-options color-gray">
                        <h5>Payment Options</h5>
                        <ul>
                            <li><a href="#"> <img src="images/bkash.jpg" alt="Bkash" height="25px"> </a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-4 address color-gray">
                        <h5>Address</h5>
                        <p>East West University, Aftab Nogor, Merul Badda, Dhaka, 1212</p>
                        <h5>Phone: +996XXXXXXXXXX</a></h5>
                    </div>
                    <div class="col-xs-12 col-sm-5 additional-info color-gray">
                        <h5>EWUSlice</h5>
                        <p>A taste that you will never forget</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>
</html>
