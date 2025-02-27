<?php
  $cartItems = $data['cart_items'] ?? [];
  $cartCount = $data['cart_count'] ?? 0;
  $cartTotal = $data['cart_total'] ?? 0;
  
  // Manual recalculation to ensure accuracy
  $manualCartCount = 0;
  foreach ($cartItems as $item) {
    $manualCartCount += (int)($item['Quantity'] ?? 0);
  }
  $cartCount = $manualCartCount;
  ?>

<!DOCTYPE html>
<html>

<head>
    <title><?=$data['page_title'] . " | " . WEBSITE_TITLE?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?=ASSETS?>style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php require_once 'includes/svg-icons.php'; ?>

    <div id="preloader" class="preloader-container">
        <div class="book">
            <div class="inner">
                <div class="left"></div>
                <div class="middle"></div>
                <div class="right"></div>
            </div>
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </div>

    <div class="search-popup">
        <div class="search-popup-container">

            <form role="search" method="get" class="search-form" action="">
                <input type="search" id="search-form" class="search-field" placeholder="Type and press enter" value=""
                    name="s" />
                <button type="submit" class="search-submit"><svg class="search">
                        <use xlink:href="#search"></use>
                    </svg></button>
            </form>

            <h5 class="cat-list-title">Browse Categories</h5>

            <ul class="cat-list">
                <li class="cat-list-item">
                    <a href="#" title="Romance">Romance</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Thriller">Thriller</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Sci-fi">Sci-fi</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Cooking">Cooking</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Health">Health</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Lifestyle">Lifestyle</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Fiction">Fiction</a>
                </li>
            </ul>

        </div>
    </div>

    <header id="header" class="site-header">

        <div class="top-info border-bottom d-none d-md-block ">
            <div class="container-fluid">
                <div class="row g-0">
                    <div class="col-md-4">
                        <p class="fs-6 my-2 text-center">Need any help? Call us <a href="#">+855 12345678</a></p>
                    </div>
                    <div class="col-md-4 border-start border-end">
                        <p class="fs-6 my-2 text-center">Summer sale discount off 60% off! <a
                                class="text-decoration-underline" href="shop">Shop Now</a></p>
                    </div>
                    <div class="col-md-4">
                        <p class="fs-6 my-2 text-center">2-3 business days delivery & free returns</p>
                    </div>
                </div>
            </div>
        </div>

        <nav id="header-nav" class="navbar navbar-expand-lg py-3">
            <div class="container">
                <a class="navbar-brand" href="index">
                    <img src="<?=ASSETS?>images/main-logo.png" class="logo">
                </a>
                <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <svg class="navbar-icon">
                        <use xlink:href="#navbar-icon"></use>
                    </svg>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar"
                    aria-labelledby="bdNavbarOffcanvasLabel">
                    <div class="offcanvas-header px-4 pb-0">
                        <a class="navbar-brand" href="index">
                            <img src="<?=ASSETS?>images/main-logo.png" class="logo">
                        </a>
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                            aria-label="Close" data-bs-target="#bdNavbar"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul id="navbar"
                            class="navbar-nav text-uppercase justify-content-start justify-content-lg-center align-items-start align-items-lg-center flex-grow-1">
                            <?php 
                            // Get the current URL path
                            $current_page = strtolower(trim($_SERVER['REQUEST_URI'], '/'));
                            $current_page = str_replace('phpbookstore/', '', $current_page);
                            if(empty($current_page)) $current_page = 'home';
                            ?>
                            <li class="nav-item">
                                <a class="nav-link me-4 <?=$current_page == 'home' ? 'active' : ''?>"
                                    href="<?=ROOT?>home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4 <?=$current_page == 'about' ? 'active' : ''?>"
                                    href="<?=ROOT?>about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4 <?=$current_page == 'shop' ? 'active' : ''?>"
                                    href="<?=ROOT?>shop">Shop</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4 <?=$current_page == 'blog' ? 'active' : ''?>"
                                    href="<?=ROOT?>blog">Blogs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4 <?=$current_page == 'contact' ? 'active' : ''?>"
                                    href="<?=ROOT?>contact">Contact</a>
                            </li>
                        </ul>
                        <div class="user-items d-flex">
                            <ul class="d-flex justify-content-end list-unstyled mb-0">
                                <li class="search-item pe-3">
                                    <a href="#" class="search-button">
                                        <svg class="search">
                                            <use xlink:href="#search"></use>
                                        </svg>
                                    </a>
                                </li>
                                <li class="pe-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <svg class="user">
                                            <use xlink:href="#user"></use>
                                        </svg>
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header border-bottom-0">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="tabs-listing">
                                                        <nav>
                                                            <div class="nav nav-tabs d-flex justify-content-center"
                                                                id="nav-tab" role="tablist">
                                                                <button class="nav-link text-capitalize active"
                                                                    id="nav-sign-in-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#nav-sign-in" type="button"
                                                                    role="tab" aria-controls="nav-sign-in"
                                                                    aria-selected="true">Sign In</button>
                                                                <button class="nav-link text-capitalize"
                                                                    id="nav-register-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#nav-register" type="button"
                                                                    role="tab" aria-controls="nav-register"
                                                                    aria-selected="false">Register</button>
                                                            </div>
                                                        </nav>
                                                        <div class="tab-content" id="nav-tabContent">
                                                            <div class="tab-pane fade active show" id="nav-sign-in"
                                                                role="tabpanel" aria-labelledby="nav-sign-in-tab">
                                                                <div class="form-group py-3">
                                                                    <label class="mb-2" for="sign-in">Username or email
                                                                        address *</label>
                                                                    <input type="text" minlength="2" name="username"
                                                                        placeholder="Your Username"
                                                                        class="form-control w-100 rounded-3 p-3"
                                                                        required>
                                                                </div>
                                                                <div class="form-group pb-3">
                                                                    <label class="mb-2" for="sign-in">Password *</label>
                                                                    <input type="password" minlength="2" name="password"
                                                                        placeholder="Your Password"
                                                                        class="form-control w-100 rounded-3 p-3"
                                                                        required>
                                                                </div>
                                                                <label class="py-3">
                                                                    <input type="checkbox" required="" class="d-inline">
                                                                    <span class="label-body">Remember me</span>
                                                                    <span class="label-body"><a href="#"
                                                                            class="fw-bold">Forgot Password</a></span>
                                                                </label>
                                                                <button type="submit" name="submit"
                                                                    class="btn btn-dark w-100 my-3">Login</button>
                                                            </div>
                                                            <div class="tab-pane fade" id="nav-register" role="tabpanel"
                                                                aria-labelledby="nav-register-tab">
                                                                <div class="form-group py-3">
                                                                    <label class="mb-2" for="register">Your email
                                                                        address *</label>
                                                                    <input type="text" minlength="2" name="username"
                                                                        placeholder="Your Email Address"
                                                                        class="form-control w-100 rounded-3 p-3"
                                                                        required>
                                                                </div>
                                                                <div class="form-group pb-3">
                                                                    <label class="mb-2" for="sign-in">Password *</label>
                                                                    <input type="password" minlength="2" name="password"
                                                                        placeholder="Your Password"
                                                                        class="form-control w-100 rounded-3 p-3"
                                                                        required>
                                                                </div>
                                                                <label class="py-3">
                                                                    <input type="checkbox" required="" class="d-inline">
                                                                    <span class="label-body">I agree to the <a href="#"
                                                                            class="fw-bold">Privacy
                                                                            Policy</a></span>
                                                                </label>
                                                                <button type="submit" name="submit"
                                                                    class="btn btn-dark w-100 my-3">Register</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="wishlist-dropdown dropdown pe-3">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button"
                                        aria-expanded="false">
                                        <svg class="wishlist">
                                            <use xlink:href="#heart"></use>
                                        </svg>
                                    </a>
                                    <div
                                        class="dropdown-menu animate slide dropdown-menu-start dropdown-menu-lg-end p-3">
                                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-primary">Your wishlist</span>
                                            <span class="badge bg-primary rounded-pill">2</span>
                                        </h4>
                                        <ul class="list-group mb-3">
                                            <li
                                                class="list-group-item bg-transparent d-flex justify-content-between lh-sm">
                                                <div>
                                                    <h5>
                                                        <a href="single-product">The Emerald Crown</a>
                                                    </h5>
                                                    <small>Special discounted price.</small>
                                                    <a href="#" class="d-block fw-medium text-capitalize mt-2">Add to
                                                        cart</a>
                                                </div>
                                                <span class="text-primary">$2000</span>
                                            </li>
                                            <li
                                                class="list-group-item bg-transparent d-flex justify-content-between lh-sm">
                                                <div>
                                                    <h5>
                                                        <a href="single-product">The Last Enchantment</a>
                                                    </h5>
                                                    <small>Perfect for enlightened people.</small>
                                                    <a href="#" class="d-block fw-medium text-capitalize mt-2">Add to
                                                        cart</a>
                                                </div>
                                                <span class="text-primary">$400</span>
                                            </li>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between">
                                                <span class="text-capitalize"><b>Total (USD)</b></span>
                                                <strong>$1470</strong>
                                            </li>
                                        </ul>
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <a href="#" class="w-100 btn btn-dark mb-1" type="submit">Add all to
                                                cart</a>
                                            <a href="cart" class="w-100 btn btn-primary" type="submit">View cart</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-dropdown dropdown">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" role="button"
                                        aria-expanded="false">
                                        <svg class="cart">
                                            <use xlink:href="#cart"></use>
                                        </svg>
                                        <span class="fs-6 fw-light">(<?=$cartCount ?? 0?>)</span>
                                    </a>
                                    <div
                                        class="dropdown-menu animate slide dropdown-menu-start dropdown-menu-lg-end p-3">
                                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-primary">Your cart</span>
                                            <span class="badge bg-primary rounded-pill"><?=$cartCount ?? 0?></span>
                                        </h4>
                                        <ul class="list-group mb-3">
                                            <?php if (isset($cartItems) && !empty($cartItems)): ?>
                                            <?php foreach ($cartItems as $item): ?>
                                            <li
                                                class="list-group-item bg-transparent d-flex justify-content-between lh-sm">
                                                <div>
                                                    <h5>
                                                        <a
                                                            href="<?=ROOT?>singleproduct/<?=$item['BookID'] ?? ''?>"><?=htmlspecialchars($item['Title'] ?? '')?></a>
                                                    </h5>
                                                    <small>
                                                        Quantity: <?=intval($item['Quantity'] ?? 0)?> ×
                                                        $<?=number_format((float)($item['Price'] ?? 0), 2)?>
                                                    </small>
                                                    <br>
                                                    <a href="#"
                                                        data-url="<?=ROOT?>cart/remove?book_id=<?=$item['BookID']?>"
                                                        class="btn btn-sm btn-danger mt-2 remove-item">
                                                        Remove
                                                    </a>
                                                </div>
                                                <span class="text-primary">
                                                    $<?=number_format((float)($item['Price'] ?? 0) * (int)($item['Quantity'] ?? 0), 2)?>
                                                </span>
                                            </li>
                                            <?php endforeach; ?>
                                            <li class="list-group-item bg-transparent d-flex justify-content-between">
                                                <span class="text-capitalize"><b>Total (USD)</b></span>
                                                <strong
                                                    id="cart-total">$<?=number_format((float)($cartTotal ?? 0), 2)?></strong>
                                            </li>
                                            <?php else: ?>
                                            <li class="list-group-item bg-transparent text-center">
                                                Your cart is empty
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <a href="<?=ROOT?>cart" class="w-100 btn btn-dark mb-1">View Cart</a>
                                            <?php if (!empty($cartItems)): ?>
                                            <a href="<?=ROOT?>checkout" class="w-100 btn btn-primary">Go to checkout</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <script>
    const SITE_ROOT = '<?=ROOT?>';
    </script>
    <script src="<?=ASSETS?>js/cart.js"></script>
    <script src="<?=ASSETS?>js/swiper-init.js"></script>
</body>

</html>