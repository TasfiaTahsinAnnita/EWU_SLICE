<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(0);
include("connection/connect.php");

// Handle adding items to the cart
if(isset($_POST['add_to_cart'])) {
    $pizza_id = $_POST['pizza_id'];
    $pizza_name = $_POST['pizza_name'];
    $pizza_price = $_POST['pizza_price'];

    // Store the pizza in the session cart
    if(isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    } else {
        $cart = [];
    }

    // Add the pizza to the cart
    $cart[] = ['id' => $pizza_id, 'name' => $pizza_name, 'price' => $pizza_price];
    $_SESSION['cart'] = $cart;
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Domino's Pizza Menu</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div style="background-image: url('images/img/pimg.jpg');">
        <header id="header" class="header-scroll top-header headrom">
            <nav class="navbar navbar-dark">
                <div class="container">
                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                    <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/icn.png" alt=""> </a>
                    <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"> <a class="nav-link active" href="index.php">Home</a> </li>
                            <li class="nav-item"> <a class="nav-link active" href="menu.php">Menu</a> </li>
                            <?php
                            if(empty($_SESSION["user_id"])) {
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

        <div class="page-wrapper">
            <section class="contact-page inner-page">
                <div class="container">
                    <h2>Domino's Pizza Menu</h2>
                    <div class="row">
                        <?php
                        // Example pizza items, you can fetch this from the database
                        $pizzas = [
                            ['id' => 1, 'name' => 'Margherita Pizza', 'price' => 10.99, 'image' => 'images/pizza1.jpg'],
                            ['id' => 2, 'name' => 'Pepperoni Pizza', 'price' => 12.99, 'image' => 'images/pizza2.jpg'],
                            ['id' => 3, 'name' => 'BBQ Chicken Pizza', 'price' => 14.99, 'image' => 'images/pizza3.jpg']
                        ];

                        foreach($pizzas as $pizza) {
                            echo '<div class="col-md-4">
                                    <div class="menu-item">
                                        <img src="'.$pizza['image'].'" alt="'.$pizza['name'].'" class="menu-item-img">
                                        <h3>'.$pizza['name'].'</h3>
                                        <p>Price: $'.$pizza['price'].'</p>
                                        <form method="post">
                                            <input type="hidden" name="pizza_id" value="'.$pizza['id'].'">
                                            <input type="hidden" name="pizza_name" value="'.$pizza['name'].'">
                                            <input type="hidden" name="pizza_price" value="'.$pizza['price'].'">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                                        </form>
                                    </div>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
            </section>

            <footer class="footer">
                <div class="container">
                    <div class="row bottom-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 payment-options color-gray">
                                    <h5>Payment Options</h5>
                                    <ul>
                                        <li><a href="#"> <img src="images/bkash.jpg" alt="Bkash" height="25px" > </a></li>
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
                </div>
            </footer>
        </div>

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
