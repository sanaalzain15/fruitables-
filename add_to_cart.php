<?php
session_start();
require_once 'config.php';

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch product info
    $query = "SELECT * FROM products_db WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $item = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => $row['image'],
            'quantity' => 1
        ];

        // Add to cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // If already in cart, increase quantity
        $found = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $item['id']) {
                $cart_item['quantity']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $item;
        }
    }
}

header("Location: cart.php");
exit;
?>
