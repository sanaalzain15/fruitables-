<!-- nav_main.php -->
<div class="container-fluid fixed-top">
    <!-- Top bar -->
    <div class="container topbar bg-primary d-none d-lg-block py-1">
        <div class="d-flex justify-content-between align-items-center">
            <div class="top-info ps-2 small">
                <small class="me-2">
                    <i class="fas fa-map-marker-alt me-1 text-secondary"></i>
                    <a href="#" class="text-white">123 Street, New York</a>
                </small>
                <small>
                    <i class="fas fa-envelope me-1 text-secondary"></i>
                    <a href="#" class="text-white">Email@Example.com</a>
                </small>
            </div>
            <div class="top-link pe-2 small">
                <a href="#" class="text-white"><small class="text-white mx-1">Privacy</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-1">Terms</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-1">Refunds</small></a>
            </div>
        </div>
    </div>

    <!-- Main navbar -->
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl py-2">
            <a href="index.php" class="navbar-brand me-3">
                <h2 class="text-primary m-0" style="font-size: 24px;">Fruitables</h2>
            </a>
            <button class="navbar-toggler py-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="shop.php" class="nav-item nav-link">Shop</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="cart.php" class="dropdown-item">Cart</a>
                            <a href="checkout.php" class="dropdown-item">Checkout</a>
                            <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                        </div>
                    </div>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
                <div class="d-flex ms-auto me-0">
                    <button class="btn-search btn border border-secondary btn-sm-square rounded-circle bg-white me-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search text-primary"></i>
                    </button>
                    <a href="#" class="position-relative me-2 my-auto">
                        <i class="fa fa-shopping-bag fa-lg"></i>
                        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                              style="top: -5px; left: 12px; height: 18px; min-width: 18px; font-size: 12px;">3</span>
                    </a>
                   <a href="login.php" class="my-auto">
                     <i class="fas fa-user fa-2x"></i>
                   </a>

                </div>
            </div>
        </nav>
    </div>
</div>
