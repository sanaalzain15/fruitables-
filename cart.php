<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'config.php';


function init_cart() {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}
function find_cart_index($id) {
    foreach ($_SESSION['cart'] as $i => $it) {
        if ((int)$it['id'] === (int)$id) return $i;
    }
    return -1;
}
init_cart();

if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM products_db WHERE id = {$product_id}");
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $idx = find_cart_index($product['id']);
        if ($idx >= 0) {
            $_SESSION['cart'][$idx]['quantity'] += 1;
        } else {
            $_SESSION['cart'][] = [
                'id'       => (int)$product['id'],
                'name'     => $product['name'],
                'price'    => (float)$product['price'],
                'image'    => $product['image'],
                'quantity' => 1
            ];
        }
    }
    header("Location: cart.php"); exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $remove_id = (int)$_GET['id'];
    $idx = find_cart_index($remove_id);
    if ($idx >= 0) {
        unset($_SESSION['cart'][$idx]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: cart.php"); exit();
}

if (isset($_GET['action']) && isset($_GET['id']) && in_array($_GET['action'], ['inc','dec'], true)) {
    $pid = (int)$_GET['id'];
    $idx = find_cart_index($pid);
    if ($idx >= 0) {
        if ($_GET['action'] === 'inc') {
            $_SESSION['cart'][$idx]['quantity'] += 1;
        } else { // dec
            $_SESSION['cart'][$idx]['quantity'] -= 1;
            if ($_SESSION['cart'][$idx]['quantity'] <= 0) {
                unset($_SESSION['cart'][$idx]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
        }
    }
    header("Location: cart.php"); exit();
}
$cart  = $_SESSION['cart'];
$total = 0;

$isLoggedIn = !empty($_SESSION['user_id']) || !empty($_SESSION['username']) || !empty($_SESSION['email']);
$checkoutUrl = $isLoggedIn ? 'checkout.php' : 'login.php?redirect=checkout.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>

<?php include('Spinner.php'); ?>
<?php include('nav_main.php'); ?>
<?php include('Modal.php'); ?>

<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Products</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
<?php
if (!empty($cart)) {
    foreach ($cart as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total   += $subtotal;
        $id       = (int)$item['id'];

        echo '
        <tr>
            <th scope="row">
                <div class="d-flex align-items-center">
                    <img src="img/' . htmlspecialchars($item['image']) . '" class="img-fluid me-5 rounded-circle" style="width:80px;height:80px;" alt="">
                </div>
            </th>
            <td><p class="mb-0 mt-4">' . htmlspecialchars($item['name']) . '</p></td>
            <td><p class="mb-0 mt-4">$' . number_format((float)$item['price'], 2) . '</p></td>

            <td>
                <div class="d-flex align-items-center mt-3">
                    <a href="cart.php?action=dec&id=' . $id . '" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-minus"></i>
                    </a>
                    <input type="text" class="form-control text-center mx-2" style="width:70px;" value="' . (int)$item['quantity'] . '" readonly>
                    <a href="cart.php?action=inc&id=' . $id . '" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </td>

            <td><p class="mb-0 mt-4">$' . number_format($subtotal, 2) . '</p></td>
            <td>
                <a href="cart.php?action=remove&id=' . $id . '" class="btn btn-md rounded-circle bg-light border mt-4">
                    <i class="fa fa-times text-danger"></i>
                </a>
            </td>
        </tr>';
    }
} else {
    echo '<tr><td colspan="6" class="text-center">🛒 Your cart is empty</td></tr>';
}
?>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply Coupon</button>
        </div>

        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal:</h5>
                            <p class="mb-0">$<?= number_format($total, 2) ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Shipping</h5>
                            <div>
                                <p class="mb-0">Flat rate: $3.00</p>
                            </div>
                        </div>
                        <p class="mb-0 text-end">Shipping inside Jordan.</p>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                        <p class="mb-0 pe-4">$<?= number_format($total + 3, 2) ?></p>
                    </div>

                    <a href="<?= $checkoutUrl ?>" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                        Proceed Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<?php include('copy.php'); ?>

<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
