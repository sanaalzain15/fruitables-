<?php
require_once 'config.php'; 
?>

<!DOCTYPE html>
<html lang="en">

                <?php include('head.php');?>

    <body>

     			<?php include('Spinner.php');?>

				<?php include('nav_main.php');?>

               	<?php include('Modal.php');?>

               	<?php include('head.php');?>


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
			<h1>  *<h1>
                <h1 class="mb-4">Fresh fruits shop</h1>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-xl-3">
                                <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-xl-3">
                              <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                    <label for="fruits">Default Sorting:</label>
                                    <form method="GET" id="sortForm">
    <?php if (isset($_GET['category'])): ?>
        <input type="hidden" name="category" value="<?= htmlspecialchars($_GET['category']) ?>">
    <?php endif; ?>
    <select name="sort" class="border-0 form-select-sm bg-light me-3" onchange="document.getElementById('sortForm').submit();">
        <option value="">Default</option>
        <option value="asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'selected' : '' ?>>Price: Low to High</option>
        <option value="desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? 'selected' : '' ?>>Price: High to Low</option>
    </select>
</form>

                                </div> 
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4>Categories</h4>
                                          <ul class="list-unstyled fruite-categorie">
<?php
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products_db");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalCount = $totalRow['total'];

$activeClass = !isset($_GET['category']) ? 'text-success fw-bold' : '';
echo "
<li>
    <div class='d-flex justify-content-between fruite-name'>
        <a href='shop.php' class='$activeClass'>
            <i class='fas fa-apple-alt me-2'></i>All
        </a>
        <span>($totalCount)</span>
    </div>
</li>";

$catQuery = "SELECT category, COUNT(*) AS count FROM products_db GROUP BY category";
$catResult = mysqli_query($conn, $catQuery);

while ($cat = mysqli_fetch_assoc($catResult)) {
    $catName = htmlspecialchars($cat['category']);
    $count = $cat['count'];
    $activeClass = (isset($_GET['category']) && $_GET['category'] === $catName) ? 'text-success fw-bold' : '';
    echo "
    <li>
        <div class='d-flex justify-content-between fruite-name'>
            <a href='shop.php?category=" . urlencode($catName) . "' class='$activeClass'>
                <i class='fas fa-apple-alt me-2'></i>$catName
            </a>
            <span>($count)</span>
        </div>
    </li>";
}
?>
</ul>


                                        </div>
                                    </div>
                                 
                                   
                                    <div class="col-lg-12">
                                        <div class="position-relative">
                                            <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                                <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center">
                                  <?php
$sortOrder = "ORDER BY id DESC";
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    if ($sort === 'asc') {
        $sortOrder = "ORDER BY price ASC";
    } elseif ($sort === 'desc') {
        $sortOrder = "ORDER BY price DESC";
    }
}

if (isset($_GET['category'])) {
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $query = "SELECT * FROM products_db WHERE category='$category' $sortOrder";
} else {
    $query = "SELECT * FROM products_db $sortOrder";
}


$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="col-md-6 col-lg-6 col-xl-4">
            <div class="rounded position-relative fruite-item">
                <div class="fruite-img">
<a href="shop-detail.php?id=' . $row['id'] . '">
    <img src="img/' . htmlspecialchars($row['image']) . '" class="img-fluid w-100 rounded-top" alt="">
</a>
                </div>
                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">' . htmlspecialchars($row['category']) . '</div>
                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                    <h4>' . htmlspecialchars($row['name']) . '</h4>
                    <p>' . htmlspecialchars($row['description']) . '</p>
                    <div class="d-flex justify-content-between flex-lg-wrap">
                        <p class="text-dark fs-5 fw-bold mb-0">$' . number_format($row['price'], 2) . ' / kg</p>
                           <a href="cart.php?action=add&id=' . $row['id'] . '" class="btn border border-secondary rounded-pill px-3 text-primary">
    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
</a>

                    </div>
                </div>
            </div>
        </div>';
}
?>

                             
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->


        <?php include('footer.php');?>

        <?php include('copy.php');?>




        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

