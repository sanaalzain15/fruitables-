<?php
require_once 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$cart = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];

$subtotal = 0.0;
foreach ($cart as $item) {
    $subtotal += ((float)$item['price']) * (int)$item['quantity'];
}
$shipping = 3.00;
$total    = $subtotal + $shipping;

$amount   = $total;
$currency = 'USD';
$status   = 'Completed';
$id       = uniqid('BILL_');

if (!empty($cart)) {
    foreach ($cart as $item) {
        $productId = (int)$item['id'];
        $qty       = (int)$item['quantity'];

        $update = "UPDATE products_db 
                   SET stock = stock - {$qty} 
                   WHERE id = {$productId} AND stock >= {$qty}";
        mysqli_query($conn, $update);
    }
}

$sql = "INSERT INTO transactionss (id, amount, currency, status) VALUES (?, ?, ?, ?)";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "sdss", $id, $amount, $currency, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav_main.php'); ?>

<div class="main-content container py-5">
    <h1 class="text-center text-success mb-4">✔ Thank You for Your Order!</h1>

    <div class="card shadow mt-5" id="invoice">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Invoice</h4>
        </div>
        <div class="card-body">
            <p><strong>Date:</strong> <?= date("Y-m-d H:i:s") ?></p>
            <p><strong>Customer:</strong> <?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?></p>
            <p><strong>Status:</strong> <?= $status ?></p>
            <p><strong>Transaction ID:</strong> <?= $id ?></p>
            <p><strong>Amount Paid:</strong> $<?= number_format($amount, 2) . " " . $currency ?></p>

            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Quantity</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cart as $item): 
                    $line = (float)$item['price'] * (int)$item['quantity']; ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td class="text-end">$<?= number_format($item['price'], 2) ?></td>
                        <td class="text-end"><?= (int)$item['quantity'] ?></td>
                        <td class="text-end">$<?= number_format($line, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                        <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Shipping</strong></td>
                        <td class="text-end">$<?= number_format($shipping, 2) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                        <td class="text-end text-success"><strong>$<?= number_format($total, 2) ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center mt-4">
                <button onclick="printInvoice()" class="btn btn-primary px-4">🖨 Print Invoice</button>
                <a href="index.php" class="btn btn-success px-4">Return to Home</a>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
function printInvoice() {
    const invoiceContent = document.getElementById("invoice").innerHTML;
    const w = window.open('', '', 'width=900,height=650');
    w.document.write('<html><head><title>Invoice</title>');
    w.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
    w.document.write('</head><body>');
    w.document.write(invoiceContent);
    w.document.write('</body></html>');
    w.document.close();
    w.print();
}
</script>
</body>
</html>
