<?php $this->view("header", $data); ?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<section id="billboard" class="position-relative d-flex align-items-center py-5 bg-light-gray"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 800px;">
    <div class="position-absolute end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next main-slider-button-next">
        <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
            <use xlink:href="#alt-arrow-right-outline"></use>
        </svg>
    </div>
    <div class="position-absolute start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev main-slider-button-prev">
        <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
            <use xlink:href="#alt-arrow-left-outline"></use>
        </svg>
    </div>
    <div class="swiper main-swiper">
        <div class="swiper-wrapper d-flex align-items-center">
            <?php if(isset($data['banner_books']) && !empty($data['banner_books'])): ?>
            <?php foreach($data['banner_books'] as $book): ?>
            <div class="swiper-slide">
                <div class="container">
                    <div class="row d-flex flex-column-reverse flex-md-row align-items-center">
                        <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
                            <div class="banner-content">
                                <h2><?=htmlspecialchars($book->Title)?></h2>
                                <p>Special Offer - 30% Off!</p>
                                <a href="<?=ROOT?>shop" class="btn mt-3">Shop Now</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="image-holder">
                                <?php if(!empty($book->Image)): ?>
                                <img src="<?=ROOT . '/' . htmlspecialchars($book->Image)?>" class="img-fluid"
                                    alt="<?=htmlspecialchars($book->Title)?>">
                                <?php else: ?>
                                <img src="<?=ASSETS?>images/banner-image2.png" class="img-fluid" alt="Default banner">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <!-- Fallback banner if no books are found -->
            <div class="swiper-slide">
                <div class="container">
                    <div class="row d-flex flex-column-reverse flex-md-row align-items-center">
                        <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
                            <div class="banner-content">
                                <h2 class="text-white">Welcome to Our Bookstore</h2>
                                <p class="text-white">Discover Amazing Books Today!</p>
                                <a href="<?=ROOT?>shop" class="btn mt-3">Shop Collection</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="image-holder">
                                <img src="<?=ASSETS?>images/banner-image2.png" class="img-fluid" alt="banner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="company-services" class="padding-large pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
                <div class="icon-box d-flex">
                    <div class="icon-box-icon pe-3 pb-3">
                        <svg class="cart-outline">
                            <use xlink:href="#cart-outline" />
                        </svg>
                    </div>
                    <div class="icon-box-content">
                        <h4 class="card-title mb-1 text-capitalize text-dark">Free delivery</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
                <div class="icon-box d-flex">
                    <div class="icon-box-icon pe-3 pb-3">
                        <svg class="quality">
                            <use xlink:href="#quality" />
                        </svg>
                    </div>
                    <div class="icon-box-content">
                        <h4 class="card-title mb-1 text-capitalize text-dark">Quality guarantee</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
                <div class="icon-box d-flex">
                    <div class="icon-box-icon pe-3 pb-3">
                        <svg class="price-tag">
                            <use xlink:href="#price-tag" />
                        </svg>
                    </div>
                    <div class="icon-box-content">
                        <h4 class="card-title mb-1 text-capitalize text-dark">Daily offers</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
                <div class="icon-box d-flex">
                    <div class="icon-box-icon pe-3 pb-3">
                        <svg class="shield-plus">
                            <use xlink:href="#shield-plus" />
                        </svg>
                    </div>
                    <div class="icon-box-content">
                        <h4 class="card-title mb-1 text-capitalize text-dark">100% secure payment</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="best-selling-items" class="position-relative padding-large">
    <div class="container">
        <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
            <h3 class="d-flex align-items-center">Best Selling Books</h3>
        </div>

        <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next product-slider-button-next">
            <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80"
                height="80">
                <use xlink:href="#alt-arrow-right-outline"></use>
            </svg>
        </div>
        <div
            class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev product-slider-button-prev">
            <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80"
                height="80">
                <use xlink:href="#alt-arrow-left-outline"></use>
            </svg>
        </div>

        <?php if(isset($data['best_selling_books']) && !empty($data['best_selling_books'])): ?>
        <div class="swiper product-swiper">
            <div class="swiper-wrapper">
                <?php foreach($data['best_selling_books'] as $book): ?>
                <div class="swiper-slide">
                    <div class="card position-relative p-4 border rounded-3">
                        <?php if(!empty($book->Image)): ?>
                        <img src="<?= ROOT . '/' . htmlspecialchars($book->Image) ?>" class="img-fluid shadow-sm"
                            alt="<?=htmlspecialchars($book->Title)?>">
                        <?php else: ?>
                        <img src="<?=ASSETS?>images/default-book.jpg" class="img-fluid shadow-sm"
                            alt="Default book image">
                        <?php endif; ?>

                        <h6 class="mt-4 mb-0 fw-bold">
                            <a
                                href="single-product.php?id=<?=htmlspecialchars($book->BookID)?>"><?=htmlspecialchars($book->Title)?></a>
                        </h6>
                        <div class="review-content d-flex">
                            <p class="my-2 me-2 fs-6 text-black-50"><?=htmlspecialchars($book->Author)?></p>
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
                        <span class="price text-primary fw-bold mb-2 fs-5">$<?=number_format($book->Price, 2)?></span>
                        <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                            <button type="button" class="btn btn-dark add-to-cart"
                                data-book-id="<?=htmlspecialchars($book->BookID)?>" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-title="Add to Cart">
                                <svg class="cart">
                                    <use xlink:href="#cart"></use>
                                </svg>
                            </button>
                            <a href="#" class="btn btn-dark add-to-wishlist"
                                data-book-id="<?=htmlspecialchars($book->BookID)?>">
                                <span>
                                    <svg class="wishlist">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info">No books available at this time.</div>
        <?php endif; ?>
    </div>
</section>

<section id="limited-offer" class="padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 800px;">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-md-6 text-center">
                <div class="image-holder">
                    <img src="<?=ASSETS?>images/banner-image3.png" class="img-fluid" alt="banner">
                </div>
            </div>
            <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
                <h2 class="text-white">30% Discount on all items. Hurry Up !!!</h2>
                <div id="countdown-clock" class="text-dark d-flex align-items-center my-3 text-white">
                    <div class="time d-grid pe-3">
                        <span class="days fs-1 fw-normal"></span>
                        <small>Days</small>
                    </div>
                    <span class="fs-1 text-primary">:</span>
                    <div class="time d-grid pe-3 ps-3">
                        <span class="hours fs-1 fw-normal"></span>
                        <small>Hrs</small>
                    </div>
                    <span class="fs-1 text-primary">:</span>
                    <div class="time d-grid pe-3 ps-3">
                        <span class="minutes fs-1 fw-normal"></span>
                        <small>Min</small>
                    </div>
                    <span class="fs-1 text-primary">:</span>
                    <div class="time d-grid ps-3">
                        <span class="seconds fs-1 fw-normal"></span>
                        <small>Sec</small>
                    </div>
                </div>
                <a href="shop.php" class="btn mt-3">Shop Collection</a>
            </div>
        </div>
    </div>
    </div>
</section>
<section id="categories" class="padding-large">
    <div class="container">
        <div class="section-title overflow-hidden mb-4">
            <h3 class="d-flex align-items-center">Categories</h3>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4 border-0 rounded-3 position-relative">
                    <a href="shop.php">
                        <img src="<?=ASSETS?>images/category1.jpg" class="img-fluid rounded-3" alt="cart item">
                        <h6 class=" position-absolute bottom-0 bg-primary m-4 py-2 px-3 rounded-3"><a href="shop.php"
                                class="text-white">Romance</a></h6>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center mb-4 border-0 rounded-3">
                    <a href="shop.php">
                        <img src="<?=ASSETS?>images/category2.jpg" class="img-fluid rounded-3" alt="cart item">
                        <h6 class=" position-absolute bottom-0 bg-primary m-4 py-2 px-3 rounded-3"><a href="shop.php"
                                class="text-white">Lifestyle</a></h6>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center mb-4 border-0 rounded-3">
                    <a href="shop.php">
                        <img src="<?=ASSETS?>images/category3.jpg" class="img-fluid rounded-3" alt="cart item">
                        <h6 class=" position-absolute bottom-0 bg-primary m-4 py-2 px-3 rounded-3"><a href="shop.php"
                                class="text-white">Recipe</a></h6>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="customers-reviews" class="position-relative padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 600px;">
    <div class="container offset-md-3 col-md-6 ">
        <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next testimonial-button-next">
            <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80"
                height="80">
                <use xlink:href="#alt-arrow-right-outline"></use>
            </svg>
        </div>
        <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev testimonial-button-prev">
            <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80"
                height="80">
                <use xlink:href="#alt-arrow-left-outline"></use>
            </svg>
        </div>
        <div class="section-title mb-4 text-center">
            <h3 class="mb-4 text-white">Customers reviews</h3>
        </div>
        <div class="swiper testimonial-swiper ">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="card position-relative text-left p-5 border rounded-3">
                        <blockquote>"I stumbled upon this bookstore while visiting the city, and it instantly became my
                            favorite spot. The cozy atmosphere, friendly staff, and wide selection of books make every
                            visit a delight!"</blockquote>
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
                        <blockquote>"As an avid reader, I'm always on the lookout for new releases, and this bookstore
                            never disappoints. They always have the latest titles, and their recommendations have
                            introduced me to some incredible reads!"</blockquote>
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
                        <blockquote>"I ordered a few books online from this store, and I was impressed by the quick
                            delivery and careful packaging. It's clear that they prioritize customer satisfaction, and
                            I'll definitely be shopping here again!"</blockquote>
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
                        <blockquote>“I stumbled upon this tech store while searching for a new laptop, and I couldn't be
                            happier
                            with my experience! The staff was incredibly knowledgeable and guided me through the process
                            of choosing
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
                        <blockquote>“I stumbled upon this tech store while searching for a new laptop, and I couldn't be
                            happier
                            with my experience! The staff was incredibly knowledgeable and guided me through the process
                            of choosing
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
            <a href="shop.php" class="btn">View All</a>
        </div>
        <div class="row">
            <div class="col-md-3 posts mb-4">
                <img src="<?=ASSETS?>images/post-item1.jpg" alt="post image" class="img-fluid rounded-3">
                <a href="blog.php" class="fs-6 text-primary">Books</a>
                <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.php">10 Must-Read Books of
                        the Year: Our Top Picks!</a></h4>
                <p class="mb-2">Dive into the world of cutting-edge technology with our latest blog post, where we
                    highlight
                    five essential gadge. <span><a class="text-decoration-underline text-black-50"
                            href="single-post.php">Read More</a></span>
                </p>
            </div>
            <div class="col-md-3 posts mb-4">
                <img src="<?=ASSETS?>images/post-item2.jpg" alt="post image" class="img-fluid rounded-3">
                <a href="blog.php" class="fs-6 text-primary">Books</a>
                <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.php">The Fascinating Realm of
                        Science Fiction</a></h4>
                <p class="mb-2">Explore the intersection of technology and sustainability in our latest blog post. Learn
                    about
                    the innovative <span><a class="text-decoration-underline text-black-50" href="single-post.php">Read
                            More</a></span> </p>
            </div>
            <div class="col-md-3 posts mb-4">
                <img src="<?=ASSETS?>images/post-item3.jpg" alt="post image" class="img-fluid rounded-3">
                <a href="blog.php" class="fs-6 text-primary">Books</a>
                <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.php">Finding Love in the
                        Pages of a Book</a></h4>
                <p class="mb-2">Stay ahead of the curve with our insightful look into the rapidly evolving landscape of
                    wearable technology. <span><a class="text-decoration-underline text-black-50"
                            href="single-post.php">Read More</a></span>
                </p>
            </div>
            <div class="col-md-3 posts mb-4">
                <img src="<?=ASSETS?>images/post-item4.jpg" alt="post image" class="img-fluid rounded-3">
                <a href="blog.php" class="fs-6 text-primary">Books</a>
                <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.php">Reading for Mental
                        Health: How Books Can Heal and Inspire</a></h4>
                <p class="mb-2">In today's remote work environment, productivity is key. Discover the top apps and tools
                    that
                    can help you stay <span><a class="text-decoration-underline text-black-50"
                            href="single-post.php">Read More</a></span>
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
                        <img src="<?=ASSETS?>images/insta-item1.jpg" alt="instagram"
                            class="img-fluid rounded-3 insta-image">
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
                        <img src="<?=ASSETS?>images/insta-item2.jpg" alt="instagram"
                            class="img-fluid rounded-3 insta-image">
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
                        <img src="<?=ASSETS?>images/insta-item3.jpg" alt="instagram"
                            class="img-fluid rounded-3 insta-image">
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
                        <img src="<?=ASSETS?>images/insta-item4.jpg" alt="instagram"
                            class="img-fluid rounded-3 insta-image">
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
                        <img src="<?=ASSETS?>images/insta-item5.jpg" alt="instagram"
                            class="img-fluid rounded-3 insta-image">
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
                        <img src="<?=ASSETS?>images/insta-item6.jpg" alt="instagram"
                            class="img-fluid rounded-3 insta-image">
                    </a>
                </figure>
            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper
    const productSwiper = new Swiper('.product-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
            nextEl: '.product-slider-button-next',
            prevEl: '.product-slider-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
        }
    });

    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
        tooltipTriggerEl));
});
</script>
<?php $this->view("footer",$data);?>