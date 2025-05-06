<?php
session_start();
error_reporting(0);
include("connection/connect.php");

// Check if the user is logged in
if (!isset($_SESSION['u_id'])) {
    echo "You must be logged in to view the cart.";
    exit;
}

// Get the user ID
$user_id = $_SESSION['u_id'];

// Handle adding item to cart
if (isset($_POST['add_to_cart'])) {
    $dish_id = $_POST['dish_id'];
    $quantity = $_POST['quantity'] ?: 1;  // Default to 1 if quantity is not specified

    // Check if the dish is already in the cart
    $sql_check = "SELECT * FROM `cart` WHERE `u_id` = '$user_id' AND `d_id` = '$dish_id'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // If dish exists, update quantity
        $sql_update = "UPDATE `cart` SET `quantity` = `quantity` + $quantity WHERE `u_id` = '$user_id' AND `d_id` = '$dish_id'";
        $conn->query($sql_update);
    } else {
        // Otherwise, add new item to cart
        $sql_add = "INSERT INTO `cart` (`u_id`, `d_id`, `quantity`) VALUES ('$user_id', '$dish_id', '$quantity')";
        $conn->query($sql_add);
    }

    header("Location: cart.php");  // Redirect back to cart
}

// Handle removing item from cart
if (isset($_GET['remove'])) {
    $dish_id = $_GET['remove'];
    $sql_remove = "DELETE FROM `cart` WHERE `u_id` = '$user_id' AND `d_id` = '$dish_id'";
    $conn->query($sql_remove);
    header("Location: cart.php");  // Redirect back to cart
}

// Handle updating item quantity in the cart
if (isset($_POST['update_quantity'])) {
    $dish_id = $_POST['dish_id'];
    $quantity = $_POST['quantity'];

    if ($quantity > 0) {
        $sql_update_quantity = "UPDATE `cart` SET `quantity` = '$quantity' WHERE `u_id` = '$user_id' AND `d_id` = '$dish_id'";
        $conn->query($sql_update_quantity);
    } else {
        // Remove item if quantity is set to 0 or less
        $sql_remove_item = "DELETE FROM `cart` WHERE `u_id` = '$user_id' AND `d_id` = '$dish_id'";
        $conn->query($sql_remove_item);
    }

    header("Location: cart.php");  // Redirect back to cart
}

// Get all cart items for the user
$sql_cart_items = "SELECT c.*, d.title, d.price, d.img FROM `cart` c JOIN `dishes` d ON c.d_id = d.d_id WHERE c.u_id = '$user_id'";
$result_cart = $conn->query($sql_cart_items);

// Calculate total price
$total_price = 0;
while ($row = $result_cart->fetch_assoc()) {
    $total_price += $row['price'] * $row['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Your Cart</h1>

<?php if ($result_cart->num_rows == 0): ?>
    <p>Your cart is empty. <a href="index.php">Browse dishes</a></p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Dish</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $result_cart->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $item['title']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <form method="POST" action="cart.php">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                            <input type="hidden" name="dish_id" value="<?php echo $item['d_id']; ?>">
                            <button type="submit" name="update_quantity">Update</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td><a href="cart.php?remove=<?php echo $item['d_id']; ?>">Remove</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <p><strong>Total Price: $<?php echo number_format($total_price, 2); ?></strong></p>
    <a href="checkout.php" class="btn">Proceed to Checkout</a>
<?php endif; ?>

</body>
</html>
