<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM products_db WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Product not found.";
    exit;
}

$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<style>
    .product-image {
        width: 100%;
        height: 350px;
        object-fit: contain;
        background-color: #f8f8f8;
        border-radius: 10px;
        padding: 10px;
    }

    .product-card {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 30px 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
        text-align: center;
    }

    .product-card:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }

    .product-card h2 {
        font-weight: bold;
        color: #198754;
    }

    .product-card p {
        color: #6c757d;
    }

    .product-card .price {
        font-size: 24px;
        font-weight: bold;
        color: #000;
        margin: 15px 0;
    }

    .product-card .btn {
        padding: 12px;
        font-size: 16px;
    }
</style>

<body>

<?php include('nav_main.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="product-card">
                <img src="img/<?php echo htmlspecialchars($product['image']); ?>" 
                     class="product-image mb-4" alt="Product image">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <div class="price">
                    $<?php echo number_format($product['price'], 2); ?> / kg
                </div>

                <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" 
                   class="btn btn-success w-100 rounded-pill">
                   Add to Cart
                </a>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
    window.addEventListener("load", function () {
        const spinner = document.getElementById("spinner");
        if (spinner) {
            spinner.style.display = "none";
        }
    });
</script>
</body>
</html>
