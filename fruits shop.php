<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-12 text-center">
                    <h1>Our Organic Products</h1>
                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                        <?php
                        $activeCategory = isset($_GET['category']) ? $_GET['category'] : '';
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $activeCategory == '' ? 'active' : '' ?>" href="index.php">All Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $activeCategory == 'Vegetables' ? 'active' : '' ?>" href="index.php?category=Vegetables">Vegetables</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $activeCategory == 'Fruits' ? 'active' : '' ?>" href="index.php?category=Fruits">Fruits</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <?php
                        require_once 'config.php';

                        if (isset($_GET['category']) && !empty($_GET['category'])) {
                            $cat = mysqli_real_escape_string($conn, $_GET['category']);
                            $query = "SELECT * FROM products_db WHERE category = '$cat'";
                        } else {
                            $query = "SELECT * FROM products_db";
                        }

                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="product-item">
                                    <div class="position-relative">
                                        <img src="img/' . htmlspecialchars($row['image']) . '" class="img-fluid w-100 rounded-top" alt="">
                                        <div class="position-absolute top-0 start-0 bg-warning text-white px-2 py-1 rounded-bottom">' . htmlspecialchars($row['category']) . '</div>
                                    </div>
                                    <div class="border border-top-0 p-4 rounded-bottom">
                                        <h5>' . htmlspecialchars($row['name']) . '</h5>
                                        <p class="mb-2">' . htmlspecialchars($row['description']) . '</p>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">$' . number_format($row['price'], 2) . ' / kg</span>
                                            <a href="#" class="btn btn-outline-success btn-sm">
                                                <i class="fa fa-shopping-bag me-2"></i>Add to cart
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
