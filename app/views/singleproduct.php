<?php $this->view("header",$data);?>

    <section class="hero-section position-relative padding-large" style="background-image: url(<?=ASSETS?>images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
      <div class="hero-content">
        <div class="container">
          <div class="row">
            <div class="text-center">
              <h1>Single-Product</h1>
              <div class="breadcrumbs">
                <span class="item">
                  <a href="index.html">Home > </a>
                </span>
                <span class="item text-decoration-underline">Single-Product</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="single-product padding-large">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="d-flex gap-3 product-preview">
              <div class="swiper thumb-swiper w-50">
                <div class="swiper-wrapper d-flex flex-wrap gap-3 align-content-start">
                  <div class="swiper-slide bg-white">
                    <img src="<?=ASSETS?>images/product-thumbnail-1.png" alt="product-thumb" class="img-fluid border rounded-3">
                  </div>
                  <div class="swiper-slide bg-white">
                    <img src="<?=ASSETS?>images/product-thumbnail-2.png" alt="product-thumb" class="img-fluid border rounded-3">
                  </div>
                  <div class="swiper-slide bg-white">
                    <img src="<?=ASSETS?>images/product-thumbnail-3.png" alt="product-thumb" class="img-fluid border rounded-3">
                  </div>
                </div>
              </div>
              <div class="swiper large-swiper border rounded-3 overflow-hidden">
                <div class="swiper-wrapper">
                  <div class="swiper-slide bg-white">
                    <img src="<?=ASSETS?>images/product-large-1.png" alt="single-product" class="img-fluid">
                  </div>
                  <div class="swiper-slide bg-white">
                    <img src="<?=ASSETS?>images/product-large-2.png" alt="single-product" class="img-fluid">
                  </div>
                  <div class="swiper-slide bg-white">
                    <img src="<?=ASSETS?>images/product-large-3.png" alt="single-product" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="product-info ps-lg-5 pt-3 pt-lg-0">
              <div class="element-header">
                <h1 class="product-title">The Emerald Crown</h1>
                <div class="product-price d-flex align-items-center mt-2">
                  <span class="fs-2 fw-light text-primary me-2">$200</span>
                  <del>$260</del>
                </div>
                <div class="rating text-warning d-flex align-items-center mb-2">
                  <svg class="star star-fill">
                    <use xlink:href="#star-fill"></use>
                  </svg>
                  <svg class="star star-fill">
                    <use xlink:href="#star-fill"></use>
                  </svg>
                  <svg class="star star-fill">
                    <use xlink:href="#star-fill"></use>
                  </svg>
                  <svg class="star star-fill">
                    <use xlink:href="#star-fill"></use>
                  </svg>
                  <svg class="star star-fill">
                    <use xlink:href="#star-fill"></use>
                  </svg>
                </div>
              </div>
              <p>Justo, cum feugiat imperdiet nulla molestie ac vulputate scelerisque amet. Bibendum adipiscing platea blandit sit sed quam semper rhoncus.</p>
              <hr>
              <div class="cart-wrap">
                <div class="color-options product-select my-3">
                  <div class="color-toggle" data-option-index="0">
                    <h4 class="item-title text-decoration-underline text-capitalize">Color</h4>
                    <ul class="select-list list-unstyled d-flex mb-0">
                      <li class="select-item me-3" data-val="Green" title="Green">
                        <a href="#">Gray</a>
                      </li>
                      <li class="select-item me-3" data-val="Orange" title="Orange">
                        <a href="#">Blue</a>
                      </li>
                      <li class="select-item me-3" data-val="Red" title="Red">
                        <a href="#">White</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="swatch product-select" data-option-index="1">
                  <h4 class="item-title text-decoration-underline text-capitalize">Size</h4>
                  <ul class="select-list list-unstyled d-flex mb-0">
                    <li data-value="S" class="select-item me-3">
                      <a href="#">S</a>
                    </li>
                    <li data-value="M" class="select-item me-3">
                      <a href="#">M</a>
                    </li>
                    <li data-value="L" class="select-item me-3">
                      <a href="#">L</a>
                    </li>
                  </ul>
                </div>
                <div class="product-quantity my-3">
                  <div class="item-title">
                    <l>2 in stock</l>
                  </div>
                  <div class="stock-button-wrap mt-2 d-flex flex-wrap align-items-center">
                    <div class="product-quantity">
                      <div class="input-group product-qty align-items-center" style="max-width: 150px;">
                        <span class="input-group-btn">
                          <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-left-minus" data-type="minus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                          </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control bg-white shadow border rounded-3 py-2 mx-2 input-number text-center" value="1" min="1" max="100" required>
                        <span class="input-group-btn">
                          <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-right-plus" data-type="plus" data-field="">
                            <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="action-buttons my-3 d-flex flex-wrap gap-3">
                  <a href="#" class="btn">Order now</a>
                  <a href="#" class="btn btn-dark">Add to cart</a>
                  <a href="#" class="btn btn-dark">
                    <svg class="heart" width="21" height="21">
                      <use xlink:href="#heart"></use>
                    </svg>
                  </a>
                </div>
              </div>
<hr>
              <div class="meta-product my-3">
                <div class="meta-item d-flex mb-1">
                  <span class="fw-medium me-2">SKU:</span>
                  <ul class="select-list list-unstyled d-flex mb-0">
                    <li data-value="S" class="select-item">1223</li>
                  </ul>
                </div>
                <div class="meta-item d-flex mb-1">
                  <span class="fw-medium me-2">Category:</span>
                  <ul class="select-list list-unstyled d-flex mb-0">
                    <li data-value="S" class="select-item">
                      <a href="#">Romance</a>,
                    </li>
                    <li data-value="S" class="select-item">
                      <a href="#">Sci-Fi</a>,
                    </li>
                    <li data-value="S" class="select-item">
                      <a href="#">Fiction</a>
                    </li>
                  </ul>
                </div>
                <div class="meta-item d-flex mb-1">
                  <span class="fw-medium me-2">Tags:</span>
                  <ul class="select-list list-unstyled d-flex mb-0">
                    <li data-value="S" class="select-item">
                      <a href="#">Revenge</a>,
                    </li>
                    <li data-value="S" class="select-item">
                      <a href="#">Vampire</a>,
                    </li>
                    <li data-value="S" class="select-item">
                      <a href="#">Life</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="product-tabs">
      <div class="container">
        <div class="row">
          <div class="tabs-listing">
            <nav>
              <div class="nav nav-tabs d-flex justify-content-center py-3" id="nav-tab" role="tablist">
                <button class="nav-link text-capitalize active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Description</button>
                <button class="nav-link text-capitalize" id="nav-information-tab" data-bs-toggle="tab" data-bs-target="#nav-information" type="button" role="tab" aria-controls="nav-information" aria-selected="false">Additional information</button>
                <button class="nav-link text-capitalize" id="nav-shipping-tab" data-bs-toggle="tab" data-bs-target="#nav-shipping" type="button" role="tab" aria-controls="nav-shipping" aria-selected="false">Shipping & Return</button>
                <button class="nav-link text-capitalize" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">Reviews (02)</button>
              </div>
            </nav>
            <div class="tab-content border-bottom py-4" id="nav-tabContent">
              <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <p>Product Description</p>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.
                <ul class="fw-light">
                  <li>Donec nec justo eget felis facilisis fermentum.</li>
                  <li>Suspendisse urna viverra non, semper suscipit pede.</li>
                  <li>Aliquam porttitor mauris sit amet orci.</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.</p>
              </div>
              <div class="tab-pane fade" id="nav-information" role="tabpanel" aria-labelledby="nav-information-tab">
                <p>It is Comfortable and Best</p>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              </div>
              <div class="tab-pane fade" id="nav-shipping" role="tabpanel" aria-labelledby="nav-shipping-tab">
                <p>Returns Policy</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eros justo, accumsan non dui sit amet. Phasellus semper volutpat mi sed imperdiet. Ut odio lectus, vulputate non ex non, mattis sollicitudin purus. Mauris consequat justo a enim interdum, in consequat dolor accumsan. Nulla iaculis diam purus, ut vehicula leo efficitur at.</p>
                <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. In blandit nunc enim, sit amet pharetra erat aliquet ac.</p>
                <p>Shipping</p>
                <p>Pellentesque ultrices ut sem sit amet lacinia. Sed nisi dui, ultrices ut turpis pulvinar. Sed fringilla ex eget lorem consectetur, consectetur blandit lacus varius. Duis vel scelerisque elit, et vestibulum metus. Integer sit amet tincidunt tortor. Ut lacinia ullamcorper massa, a fermentum arcu vehicula ut. Ut efficitur faucibus dui Nullam tristique dolor eget turpis consequat varius. Quisque a interdum augue. Nam ut nibh mauris.</p>
              </div>
              <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                <div class="review-box review-style d-flex gap-3 flex-column">
                  <div class="review-item d-flex">
                    <div class="image-holder me-2">
                      <img src="<?=ASSETS?>images/review-image1.jpg" alt="review" class="img-fluid rounded-3">
                    </div>
                    <div class="review-content">
                      <div class="rating text-primary">
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                      </div>
                      <div class="review-header">
                        <span class="author-name fw-medium">Tom Johnson</span>
                        <span class="review-date">- 07/05/2022</span>
                      </div>
                      <p>Vitae tortor condimentum lacinia quis vel eros donec ac. Nam at lectus urna duis convallis convallis</p>
                    </div>
                  </div>
                  <div class="review-item d-flex">
                    <div class="image-holder me-2">
                      <img src="<?=ASSETS?>images/review-image2.jpg" alt="review" class="img-fluid rounded-3">
                    </div>                    
                    <div class="review-content">
                      <div class="rating text-primary">
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                        <svg class="star star-fill">
                          <use xlink:href="#star-fill"></use>
                        </svg>
                      </div>
                      <div class="review-header">
                        <span class="author-name fw-medium">Jenny Willis</span>
                        <span class="review-date">- 07/05/2022</span>
                      </div>
                      <p>Vitae tortor condimentum lacinia quis vel eros donec ac. Nam at lectus urna duis convallis convallis</p>
                    </div>
                  </div>
                </div>
                <div class="add-review margin-small">
                  <h3>Add a review</h3>
                  <p>Your email address will not be published. Required fields are marked *</p>
                  <div class="review-rating py-2">
                    <span class="my-2">Your rating *</span>
                    <div class="rating text-secondary">
                      <svg class="star star-fill">
                        <use xlink:href="#star-fill"></use>
                      </svg>
                      <svg class="star star-fill">
                        <use xlink:href="#star-fill"></use>
                      </svg>
                      <svg class="star star-fill">
                        <use xlink:href="#star-fill"></use>
                      </svg>
                      <svg class="star star-fill">
                        <use xlink:href="#star-fill"></use>
                      </svg>
                      <svg class="star star-fill">
                        <use xlink:href="#star-fill"></use>
                      </svg>
                    </div>
                  </div>
                  <input type="file" class="jfilestyle py-3 border-0" data-text="Choose your file">
                  <form id="form" class="d-flex gap-3 flex-wrap">
                    <div class="w-100 d-flex gap-3">
                      <div class="w-50">
                        <input type="text" name="name" placeholder="Write your name here *" class="form-control w-100">
                      </div>
                      <div class="w-50">
                        <input type="text" name="email" placeholder="Write your email here *" class="form-control w-100">
                      </div>
                    </div>
                    <div class="w-100">
                      <textarea placeholder="Write your review here *" class="form-control w-100"></textarea>
                    </div>
                    <label class="w-100">
                      <input type="checkbox" required="" class="d-inline">
                      <span>Save my name, email, and website in this browser for the next time.</span>
                    </label>
                    <button type="submit" name="submit" class="btn my-3">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="related-items" class="position-relative padding-large ">
      <div class="container">
        <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
          <h3 class="d-flex align-items-center">Related Items</h3>
          <a href="shop.html" class="btn">View All</a>
        </div>
        <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next product-slider-button-next">
          <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
            <use xlink:href="#alt-arrow-right-outline"></use>
          </svg>
        </div>
        <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev product-slider-button-prev">
          <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
            <use xlink:href="#alt-arrow-left-outline"></use>
          </svg>
        </div>
        <div class="swiper product-swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="card position-relative p-4 border rounded-3">
                <div class="position-absolute">
                  <p class="bg-primary py-1 px-3 fs-6 text-white rounded-2">10% off</p>
                </div>
                <img src="<?=ASSETS?>images/product-item1.png" class="img-fluid shadow-sm" alt="product item">
                <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">Secrets of the Alchemist</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
  
                  <div class="rating text-warning d-flex align-items-center">
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                  </div>
                </div>
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
                <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                  <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Tooltip on top">
                    <svg class="cart">
                      <use xlink:href="#cart"></use>
                    </svg>
                  </button>
                  <a href="#" class="btn btn-dark">
                    <span>
                      <svg class="wishlist">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card position-relative p-4 border rounded-3">
                <img src="<?=ASSETS?>images/product-item2.png" class="img-fluid shadow-sm" alt="product item">
                <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">Secrets of the Alchemist</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
  
                  <div class="rating text-warning d-flex align-items-center">
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                  </div>
                </div>
  
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
                <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                  <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Tooltip on top">
                    <svg class="cart">
                      <use xlink:href="#cart"></use>
                    </svg>
                  </button>
                  <a href="#" class="btn btn-dark">
                    <span>
                      <svg class="wishlist">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card position-relative p-4 border rounded-3">
                <img src="<?=ASSETS?>images/product-item3.png" class="img-fluid shadow-sm" alt="product item">
                <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">Secrets of the Alchemist</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
  
                  <div class="rating text-warning d-flex align-items-center">
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                  </div>
                </div>
  
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
                <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                  <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Tooltip on top">
                    <svg class="cart">
                      <use xlink:href="#cart"></use>
                    </svg>
                  </button>
                  <a href="#" class="btn btn-dark">
                    <span>
                      <svg class="wishlist">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card position-relative p-4 border rounded-3">
                <div class="position-absolute">
                  <p class="bg-primary py-1 px-3 fs-6 text-white rounded-2">10% off</p>
                </div>
                <img src="<?=ASSETS?>images/product-item4.png" class="img-fluid shadow-sm" alt="product item">
                <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">Secrets of the Alchemist</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
  
                  <div class="rating text-warning d-flex align-items-center">
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                  </div>
                </div>
  
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
                <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                  <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Tooltip on top">
                    <svg class="cart">
                      <use xlink:href="#cart"></use>
                    </svg>
                  </button>
                  <a href="#" class="btn btn-dark">
                    <span>
                      <svg class="wishlist">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card position-relative p-4 border rounded-3">
                <img src="<?=ASSETS?>images/product-item5.png" class="img-fluid shadow-sm" alt="product item">
                <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">Secrets of the Alchemist</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
  
                  <div class="rating text-warning d-flex align-items-center">
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                  </div>
                </div>
  
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
                <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                  <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Tooltip on top">
                    <svg class="cart">
                      <use xlink:href="#cart"></use>
                    </svg>
                  </button>
                  <a href="#" class="btn btn-dark">
                    <span>
                      <svg class="wishlist">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card position-relative p-4 border rounded-3">
                <img src="<?=ASSETS?>images/product-item6.png" class="img-fluid shadow-sm" alt="product item">
                <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">Secrets of the Alchemist</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
  
                  <div class="rating text-warning d-flex align-items-center">
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                  </div>
                </div>
  
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
                <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                  <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Tooltip on top">
                    <svg class="cart">
                      <use xlink:href="#cart"></use>
                    </svg>
                  </button>
                  <a href="#" class="btn btn-dark">
                    <span>
                      <svg class="wishlist">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div>
  
          </div>
        </div>
      </div>
    </section>

    <section id="customers-reviews" class="position-relative padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 600px;">
    <div class="container offset-md-3 col-md-6 ">
      <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next testimonial-button-next">
        <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-right-outline"></use>
        </svg>
      </div>
      <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev testimonial-button-prev">
        <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-left-outline"></use>
        </svg>
      </div>
      <div class="section-title mb-4 text-center">
        <h3 class="mb-4">Customers reviews</h3>
      </div>
      <div class="swiper testimonial-swiper ">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>"I stumbled upon this bookstore while visiting the city, and it instantly became my favorite spot. The cozy atmosphere, friendly staff, and wide selection of books make every visit a delight!"</blockquote>
              <div class="rating text-warning d-flex align-items-center">
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
              </div>
              <h5 class="mt-1 fw-normal">Emma Chamberlin</h5>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>"As an avid reader, I'm always on the lookout for new releases, and this bookstore never disappoints. They always have the latest titles, and their recommendations have introduced me to some incredible reads!"</blockquote>
              <div class="rating text-warning d-flex align-items-center">
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
              </div>
              <h5 class="mt-1 fw-normal">Thomas John</h5>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>"I ordered a few books online from this store, and I was impressed by the quick delivery and careful packaging. It's clear that they prioritize customer satisfaction, and I'll definitely be shopping here again!"</blockquote>
              <div class="rating text-warning d-flex align-items-center">
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
              </div>
              <h5 class="mt-1 fw-normal">Kevin Bryan</h5>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>“I stumbled upon this tech store while searching for a new laptop, and I couldn't be happier
                with my experience! The staff was incredibly knowledgeable and guided me through the process of choosing
                the perfect device for my needs. Highly recommended!”</blockquote>
              <div class="rating text-warning d-flex align-items-center">
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
              </div>
              <h5 class="mt-1 fw-normal">Stevin</h5>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>“I stumbled upon this tech store while searching for a new laptop, and I couldn't be happier
                with my experience! The staff was incredibly knowledgeable and guided me through the process of choosing
                the perfect device for my needs. Highly recommended!”</blockquote>
              <div class="rating text-warning d-flex align-items-center">
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
                <svg class="star star-fill">
                  <use xlink:href="#star-fill"></use>
                </svg>
              </div>
              <h5 class="mt-1 fw-normal">Roman</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="latest-posts" class="padding-large">
    <div class="container">
      <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
        <h3 class="d-flex align-items-center">Latest posts</h3>
        <a href="shop.html" class="btn">View All</a>
      </div>
      <div class="row">
        <div class="col-md-3 posts mb-4">
          <img src="<?=ASSETS?>images/post-item1.jpg" alt="post image" class="img-fluid rounded-3">
          <a href="blog.html" class="fs-6 text-primary">Books</a>
          <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">10 Must-Read Books of the Year: Our Top Picks!</a></h4>
          <p class="mb-2">Dive into the world of cutting-edge technology with our latest blog post, where we highlight
            five essential gadg <span><a class="text-decoration-underline text-black-50" href="single-post.html">Read More</a></span>
          </p>
        </div>
        <div class="col-md-3 posts mb-4">
          <img src="<?=ASSETS?>images/post-item2.jpg" alt="post image" class="img-fluid rounded-3">
          <a href="blog.html" class="fs-6 text-primary">Books</a>
          <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">The Fascinating Realm of Science Fiction</a></h4>
          <p class="mb-2">Explore the intersection of technology and sustainability in our latest blog post. Learn about
            the innovative <span><a class="text-decoration-underline text-black-50" href="single-post.html">Read More</a></span> </p>
        </div>
        <div class="col-md-3 posts mb-4">
          <img src="<?=ASSETS?>images/post-item3.jpg" alt="post image" class="img-fluid rounded-3">
          <a href="blog.html" class="fs-6 text-primary">Books</a>
          <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Finding Love in the Pages of a Book</a></h4>
          <p class="mb-2">Stay ahead of the curve with our insightful look into the rapidly evolving landscape of
            wearable technology. <span><a class="text-decoration-underline text-black-50" href="single-post.html">Read More</a></span>
          </p>
        </div>
        <div class="col-md-3 posts mb-4">
          <img src="<?=ASSETS?>images/post-item4.jpg" alt="post image" class="img-fluid rounded-3">
          <a href="blog.html" class="fs-6 text-primary">Books</a>
          <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Reading for Mental Health: How Books Can Heal and Inspire</a></h4>
          <p class="mb-2">In today's remote work environment, productivity is key. Discover the top apps and tools that
            can help you stay <span><a class="text-decoration-underline text-black-50" href="single-post.html">Read More</a></span>
          </p>
        </div>
      </div>
    </div>
  </section>

  <section id="instagram">
    <div class="container">
      <div class="text-center mb-4">
        <h3>Instagram</h3>
      </div>
      <div class="row">
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="<?=ASSETS?>images/insta-item1.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="<?=ASSETS?>images/insta-item2.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="<?=ASSETS?>images/insta-item3.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="<?=ASSETS?>images/insta-item4.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="<?=ASSETS?>images/insta-item5.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
        <div class="col-md-2">
          <figure class="instagram-item position-relative rounded-3">
            <a href="https://templatesjungle.com/" class="image-link position-relative">
              <div class="icon-overlay position-absolute d-flex justify-content-center">
                <svg class="instagram">
                  <use xlink:href="#instagram"></use>
                </svg>
              </div>
              <img src="<?=ASSETS?>images/insta-item6.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
            </a>
          </figure>
        </div>
      </div>
    </div>
  </section>

<?php $this->view("footer",$data);?>