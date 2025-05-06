<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(0);
include("connection/connect.php");

if(isset($_POST['submit'])) {
    // Check if all fields are filled
    if(empty($_POST['username']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['cpassword'])) {
        $message = "All fields must be required!";
    } else {
        // Check if passwords match
        if($_POST['password'] != $_POST['cpassword']) {
            echo "<script>alert('Password does not match');</script>";
        }
        // Check if password is at least 6 characters
        elseif(strlen($_POST['password']) < 6) {
            echo "<script>alert('Password must be >= 6 characters');</script>";
        }
        // Check if phone number is valid (at least 10 digits)
        elseif(strlen($_POST['phone']) < 10) {
            echo "<script>alert('Invalid phone number!');</script>";
        }
        // Validate email format
        elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email address! Please enter a valid email.');</script>";
        }
        // Check if username or email already exists
        else {
            $check_username = mysqli_query($db, "SELECT username FROM users WHERE username = '".$_POST['username']."'");
            $check_email = mysqli_query($db, "SELECT email FROM users WHERE email = '".$_POST['email']."'");

            if(mysqli_num_rows($check_username) > 0) {
                echo "<script>alert('Username already exists!');</script>";
            }
            elseif(mysqli_num_rows($check_email) > 0) {
                echo "<script>alert('Email already exists!');</script>";
            }
            else {
                // Generate a verification code
                $verification_code = rand(100000, 999999); // 6-digit code
                $_SESSION['verification_code'] = $verification_code;
                // Send the verification code to the user's email
                mail($_POST['email'], "Verification Code", "Your verification code is: $verification_code");

                // Insert user details into the database (without email verification yet)
                $mql = "INSERT INTO users(username, f_name, l_name, email, phone, password, address) VALUES('".$_POST['username']."', '".$_POST['firstname']."', '".$_POST['lastname']."', '".$_POST['email']."', '".$_POST['phone']."', '".md5($_POST['password'])."', '".$_POST['address']."')";
                mysqli_query($db, $mql);

                // Redirect to login page
                header("refresh:0.1;url=login.php");
            }
        }
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Registration</title>
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
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-wrapper">
        <section class="contact-page inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">User-Name</label>
                                            <input class="form-control" type="text" name="username" id="example-text-input"> 
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">First Name</label>
                                            <input class="form-control" type="text" name="firstname" id="example-text-input"> 
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Last Name</label>
                                            <input class="form-control" type="text" name="lastname" id="example-text-input-2"> 
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Email Address</label>
                                            <input type="text" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp"> 
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Phone number</label>
                                            <input class="form-control" type="text" name="phone" id="example-tel-input-3"> 
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" name="password" id="exampleInputPassword1"> 
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Confirm password</label>
                                            <input type="password" class="form-control" name="cpassword" id="exampleInputPassword2"> 
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="exampleTextarea">Delivery Address</label>
                                            <textarea class="form-control" id="exampleTextarea" name="address" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p> <input type="submit" value="Register" name="submit" class="btn theme-btn"> </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
