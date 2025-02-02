<?php include 'includes/header.php'; ?>

<body>
    
     <!-- START Wrapper -->
     <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

          <div class="page-content">
               <div class="container-xxl">
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="card">
                                   <div class="card-body">
                                        <!-- Crossfade -->
                                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                             <div class="carousel-inner" role="listbox">
                                                  <div class="carousel-item active">
                                                       <img src="../assets/images/products/p-1.png" alt="" class="img-fluid bg-light rounded">
                                                  </div>
                                                  <div class="carousel-item">
                                                       <img src="../assets/images/products/p-10.png" alt="" class="img-fluid bg-light rounded">
                                                  </div>
                                                  <div class="carousel-item">
                                                       <img src="../assets/images/products/p-13.png" alt="" class="img-fluid bg-light rounded">
                                                  </div>
                                                  <div class="carousel-item">
                                                       <img src="../assets/images/products/p-14.png" alt="" class="img-fluid bg-light rounded">
                                                  </div>
                                                  <!-- <a class="carousel-control-prev rounded" href="#carouselExampleFade" role="button" data-bs-slide="prev">
                                                       <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                       <span class="visually-hidden">Previous</span>
                                                  </a>
                                                  <a class="carousel-control-next rounded" href="#carouselExampleFade" role="button" data-bs-slide="next">
                                                       <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                       <span class="visually-hidden">Next</span>
                                                  </a> -->
                                             </div>
                                             <div class="carousel-indicators m-0 mt-2 d-lg-flex d-none position-static h-100">
                                                  <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" aria-current="true" aria-label="Slide 1" class="w-auto h-auto rounded bg-light active">
                                                       <img src="assets/images/product/p-1.png" class="d-block avatar-xl" alt="swiper-indicator-img">
                                                  </button>
                                                  <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1" aria-label="Slide 2" class="w-auto h-auto rounded bg-light">
                                                       <img src="assets/images/product/p-10.png" class="d-block avatar-xl" alt="swiper-indicator-img">
                                                  </button>
                                                  <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2" aria-label="Slide 3" class="w-auto h-auto rounded bg-light">
                                                       <img src="assets/images/product/p-13.png" class="d-block avatar-xl" alt="swiper-indicator-img">
                                                  </button>
                                                  <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="3" aria-label="Slide 3" class="w-auto h-auto rounded bg-light">
                                                       <img src="assets/images/product/p-14.png" class="d-block avatar-xl" alt="swiper-indicator-img">
                                                  </button>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="card-footer border-top">
                                        <div class="row g-2">
                                             <div class="col-lg-5">
                                                  <a href="#!" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 w-100"><i class="bx bx-cart fs-18"></i> Add To Cart</a>
                                             </div>
                                             <div class="col-lg-5">
                                                  <a href="#!" class="btn btn-light d-flex align-items-center justify-content-center gap-2 w-100"><i class="bx bx-shopping-bag fs-18"></i> Buy Now</a>
                                             </div>
                                             <div class="col-lg-2">
                                                  <button type="button" class="btn btn-soft-danger d-inline-flex align-items-center justify-content-center fs-20 rounded w-100"><iconify-icon icon="solar:heart-broken"></iconify-icon></button>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-8">
                              <div class="card">
                                   <div class="card-body">
                                        <h4 class="badge bg-success text-light fs-14 py-1 px-2">New Arrival</h4>
                                        <p class="mb-1">
                                             <a href="#!" class="fs-24 text-dark fw-medium">Men Black Slim Fit T-shirt</a>
                                        </p>
                                        <div class="d-flex gap-2 align-items-center">
                                             <ul class="d-flex text-warning m-0 fs-20  list-unstyled">
                                                  <li>
                                                       <i class="bx bxs-star"></i>
                                                  </li>
                                                  <li>
                                                       <i class="bx bxs-star"></i>
                                                  </li>
                                                  <li>
                                                       <i class="bx bxs-star"></i>
                                                  </li>
                                                  <li>
                                                       <i class="bx bxs-star"></i>
                                                  </li>
                                                  <li>
                                                       <i class="bx bxs-star-half"></i>
                                                  </li>
                                             </ul>
                                             <p class="mb-0 fw-medium fs-18 text-dark">4.5 <span class="text-muted fs-13">(55 Review)</span></p>
                                        </div>
                                        <h2 class="fw-medium my-3">$80.00 <span class="fs-16 text-decoration-line-through">$100.00</span><small class="text-danger ms-2">(30%Off)</small></h2>

                                        <div class="row align-items-center g-2 mt-3">
                                             <div class="col-lg-3">
                                                  <div class="">
                                                       <h5 class="text-dark fw-medium">Colors > <span class="text-muted">Dark</span></h5>
                                                       <div class="d-flex flex-wrap gap-2" role="group" aria-label="Basic checkbox toggle button group">
                                                            <input type="checkbox" class="btn-check" id="color-dark2" checked>
                                                            <label class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center" for="color-dark2"> <i class="bx bxs-circle fs-18 text-dark"></i></label>
               
                                                            <input type="checkbox" class="btn-check" id="color-yellow2">
                                                            <label class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center" for="color-yellow2"> <i class="bx bxs-circle fs-18 text-warning"></i></label>
               
                                                            <input type="checkbox" class="btn-check" id="color-white2">
                                                            <label class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center" for="color-white2"> <i class="bx bxs-circle fs-18 text-white"></i></label>
               
                                                            <input type="checkbox" class="btn-check" id="color-green2">
                                                            <label class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center" for="color-green2"> <i class="bx bxs-circle fs-18 text-success"></i></label>
               
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-lg-3">
                                                  <div class="">
                                                       <h5 class="text-dark fw-medium">Size > <span class="text-muted">M</span></h5>
                                                       <div class="d-flex flex-wrap gap-2" role="group" aria-label="Basic checkbox toggle button group">
                                                            <input type="checkbox" class="btn-check" id="size-s2">
                                                            <label class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center" for="size-s2">S</label>
               
                                                            <input type="checkbox" class="btn-check" id="size-m2" checked>
                                                            <label class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center" for="size-m2">M</label>
               
                                                            <input type="checkbox" class="btn-check" id="size-xl3">
                                                            <label class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center" for="size-xl3">Xl</label>
               
                                                            <input type="checkbox" class="btn-check" id="size-xxl3">
                                                            <label class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center" for="size-xxl3">XXL</label>
               
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="quantity mt-4">
                                             <h4 class="text-dark fw-medium mt-3">Quantity :</h4>
                                             <div class="input-step border bg-body-secondary p-1 mt-1 rounded d-inline-flex overflow-visible">
                                                  <button type="button" class="minus bg-light text-dark border-0 rounded-1 fs-20 lh-1 h-100">-</button>
                                                  <input type="number" class="text-dark text-center border-0 bg-body-secondary rounded h-100" value="1" min="0" max="100" readonly="">
                                                  <button type="button" class="plus bg-light text-dark border-0 rounded-1 fs-20 lh-1 h-100">+</button>
                                             </div>
                                        </div>
                                        <ul class="d-flex flex-column gap-2 list-unstyled fs-15 my-3">
                                             <li>
                                                  <i class='bx bx-check text-success'></i> In Stock
                                             </li>
                                             <li>
                                                  <i class='bx bx-check text-success'></i> Free delivery available
                                             </li>
                                             <li>
                                                  <i class='bx bx-check text-success'></i> Sales 10% Off Use Code: <span class="text-dark fw-medium">CODE123</span>
                                             </li>
                                        </ul>
                                        <h4 class="text-dark fw-medium">Description :</h4>
                                        <p class="text-muted">Top in sweatshirt fabric made from a cotton blend with a soft brushed inside. Relaxed fit with dropped shoulders, long sleeves and ribbing around the neckline, cuffs and hem. Small metal text applique. <a href="#!" class="link-primary">Read more</a></p>
                                        <h4 class="text-dark fw-medium mt-3">Available offers :</h4>
                                        <div class="d-flex align-items-center mt-2">
                                             <i class="bx bxs-bookmarks text-success me-3 fs-20 mt-1"></i>
                                             <p class="mb-0"><span class="fw-medium text-dark">Bank Offer</span> 10% instant discount on Bank Debit Cards, up to $30 on orders of $50 and above</p>
                                        </div>
                                        <div class="d-flex align-items-center mt-2">
                                             <i class="bx bxs-bookmarks text-success me-3 fs-20 mt-1"></i>
                                             <p class="mb-0"><span class="fw-medium text-dark">Bank Offer</span> Grab our exclusive offer now and save 20% on your next purchase! Don't miss out, shop today!</p>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>

<?php include 'includes/footer.php'; ?>