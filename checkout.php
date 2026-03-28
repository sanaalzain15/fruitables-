<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'config.php';

$isLoggedIn = !empty($_SESSION['user_id']) || !empty($_SESSION['username']) || !empty($_SESSION['email']);
if (!$isLoggedIn) {
    $_SESSION['flash'] = 'sign in to continue shopping.';
    header('Location: login.php?redirect=checkout.php');
    exit();
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) { $_SESSION['cart'] = []; }
$cart = $_SESSION['cart'];
if (empty($cart)) { header("Location: cart.php"); exit(); }

$subtotal = 0.0;
foreach ($cart as $it) { 
    $subtotal += ((float)$it['price']) * ((int)$it['quantity']); 
}
$shipping = 3.00;
$total    = $subtotal + $shipping;
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
    <h1 class="mb-4">Billing details</h1>

    <?php if (!empty($_SESSION['flash'])): ?>
      <div class="alert alert-warning"><?php echo htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
    <?php endif; ?>

    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_cart">
      <input type="hidden" name="upload" value="1">
      <input type="hidden" name="business" value="ebusiness@fruitable.com">
      <input type="hidden" name="currency_code" value="USD">
      <input type="hidden" name="return" value="http://localhost/fruitables-1.0.0/thankyou.php">
      <input type="hidden" name="cancel_return" value="http://localhost/fruitables-1.0.0/checkout.php">

      <div class="row g-5">
        <div class="col-md-12 col-lg-6 col-xl-7">
          <div class="row">
            <div class="col-md-6">
              <div class="form-item w-100">
                <label class="form-label my-3">First Name<sup>*</sup></label>
                <input type="text" name="first_name" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-item w-100">
                <label class="form-label my-3">Last Name<sup>*</sup></label>
                <input type="text" name="last_name" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="form-item">
            <label class="form-label my-3">Company Name</label>
            <input type="text" name="company" class="form-control">
          </div>
          <div class="form-item">
            <label class="form-label my-3">Address<sup>*</sup></label>
            <input type="text" name="address" class="form-control" required>
          </div>

          <div class="form-item">
            <label class="form-label my-3">Mobile<sup>*</sup></label>
            <input type="tel" name="mobile" class="form-control" required>
          </div>
          <div class="form-item">
            <label class="form-label my-3">Email Address<sup>*</sup></label>
            <input type="email" name="email" class="form-control" required>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 col-xl-5">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Products</th>
                  <th>Name</th>
                  <th class="text-end">Price</th>
                  <th class="text-end">Qty</th>
                  <th class="text-end">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i = 1;
                foreach ($cart as $item):
                  $line = (float)$item['price'] * (int)$item['quantity']; 
                  ?>
                  <input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo htmlspecialchars($item['name']); ?>">
                  <input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo number_format((float)$item['price'], 2, '.', ''); ?>">
                  <input type="hidden" name="quantity_<?php echo $i; ?>" value="<?php echo (int)$item['quantity']; ?>">

                  <tr>
                    <th scope="row">
                      <div class="d-flex align-items-center">
                        <img src="img/<?= htmlspecialchars($item['image']) ?>" class="img-fluid me-3 rounded-circle" style="width:48px;height:48px;" alt="">
                      </div>
                    </th>
                    <td class="align-middle"><?= htmlspecialchars($item['name']) ?></td>
                    <td class="align-middle text-end">$<?= number_format((float)$item['price'], 2) ?></td>
                    <td class="align-middle text-end"><?= (int)$item['quantity'] ?></td>
                    <td class="align-middle text-end">$<?= number_format($line, 2) ?></td>
                  </tr>
                <?php $i++; endforeach; ?>
                <tr>
                  <td colspan="4" class="text-end"><strong>Shipping</strong></td>
                  <td class="text-end">$<?= number_format($shipping, 2) ?></td>
                </tr>
                <tr>
                  <td colspan="4" class="text-end"><strong>Total</strong></td>
                  <td class="text-end"><strong>$<?= number_format($total, 2) ?></strong></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="row g-4 text-center align-items-center justify-content-center pt-4">
            <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal Checkout">
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<?php include('footer.php'); ?>
<?php include('copy.php'); ?>

<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top">
  <i class="fa fa-arrow-up"></i>
</a>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
