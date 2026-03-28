<?php require_once('config.php')

//connect();

?>
<!DOCTYPE html>
<html lang="en">

    <?php include ('head.php'); ?>
    <body>

        <!-- Spinner Start -->
         <?php include ('Spinner.php'); ?>
        <!-- Spinner End -->


        <!-- Navbar -->
		<?php include ('nav_main.php');?>

        
        <!-- Modal Search -->
		<?php include('Modal.php'); ?>

        <!-- Hero -->
		<?php include('Hero.php'); ?>

        <!-- Featurs Section -->
		<?php include('Featurs Section.php'); ?>



        <!-- Fruits Shop Start-->

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

        <!-- Fruits Shop End-->

        <!-- Featurs  -->
       <?php include ('feature.php');?>


        <!-- Banner Section -->
         <?php include ('banner.php');?>



        <!-- Bestsaler -->
        <?php include ('Bestsaler.php');?>



        <!-- Fact  -->
        <?php include ('fact.php');?>


        <!-- Footer Start -->
		<?php include ('footer.php');?>
		

        <!-- Copyright Start -->
        <?php include ('copy.php');?>
        <!-- Copyright End -->



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

</html>
