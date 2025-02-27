<?php $this->view("header",$data);?>

<section class="hero-section position-relative padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h1>Shop</h1>
                    <div class="breadcrumbs">
                        <span class="item">
                            <a href="index.php">Home > </a>
                        </span>
                        <span class="item text-decoration-underline">Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="shopify-grid padding-large">
    <div class="container">
        <div class="row flex-row-reverse g-md-5">
            <main class="col-md-9">
                <div class="filter-shop d-flex flex-wrap justify-content-between mb-5">
                    <div class="showing-product">
                        <p>Showing 1–9 of 55 results</p>
                    </div>
                    <div class="sort-by">
                        <select id="sorting" class="form-select" data-filter-sort="" data-filter-order="">
                            <option value="">Default sorting</option>
                            <option value="">Name (A - Z)</option>
                            <option value="">Name (Z - A)</option>
                            <option value="">Price (Low-High)</option>
                            <option value="">Price (High-Low)</option>
                            <option value="">Rating (Highest)</option>
                            <option value="">Rating (Lowest)</option>
                            <option value="">Model (A - Z)</option>
                            <option value="">Model (Z - A)</option>
                        </select>
                    </div>
                </div>
                <div class="row product-content product-store">
                    <?php
                    error_log("View data: " . print_r($data, true));
                    error_log("Books variable exists: " . (isset($data['books']) ? "yes" : "no"));
                    error_log("Books variable empty: " . (empty($data['books']) ? "yes" : "no"));
                    ?>
                    <?php if(isset($data['books']) && !empty($data['books'])): ?>
                    <?php foreach($data['books'] as $book): ?>
                    <div class="col-lg-3 col-md-4 mb-4">
                        <div class="card position-relative p-4 border rounded-3">
                            <?php if($book->StockQuantity > 0): ?>
                            <div class="position-absolute">
                                <p class="bg-primary py-1 px-3 fs-6 text-white rounded-2">In Stock</p>
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($book->Image)): ?>
                            <img src="<?=htmlspecialchars($book->Image)?>" class="img-fluid shadow-sm"
                                alt="<?=htmlspecialchars($book->Title)?>">
                            <?php else: ?>
                            <img src="<?=ASSETS?>images/product-item1.png" class="img-fluid shadow-sm"
                                alt="Default book image">
                            <?php endif; ?>
                            <h6 class="mt-4 mb-0 fw-bold">
                                <a href="<?=ROOT?>/shop/book/<?=$book->BookID?>"><?=htmlspecialchars($book->Title)?></a>
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
                            <span
                                class="price text-primary fw-bold mb-2 fs-5">$<?=number_format($book->Price, 2)?></span>
                            <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                                <?php if($book->StockQuantity > 0): ?>
                                <!-- New code -->
                                <button type="button" class="btn btn-dark add-to-cart"
                                    data-book-id="<?=htmlspecialchars($book->BookID)?>" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Add to Cart">
                                    <svg class="cart">
                                        <use xlink:href="#cart"></use>
                                    </svg>
                                </button>
                                <?php else: ?>
                                <button type="button" class="btn btn-secondary" disabled>
                                    <svg class="cart">
                                        <use xlink:href="#cart"></use>
                                    </svg>
                                </button>
                                <?php endif; ?>
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
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            No books available at this time.
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </main>

            <!-- Pagination  -->
            <!-- <nav class="py-5" aria-label="Page navigation">
            <ul class="pagination justify-content-center gap-4">
                <li class="page-item disabled">
                    <a class="page-link">Prev</a>
                </li>
                <li class="page-item active" aria-current="page">
                    <span class="page-link">1</span>
                </li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav> -->

            </main>
            <aside class="col-md-3">
                <div class="sidebar ps-lg-5">
                    <div class="widget-menu">
                        <div class="widget-search-bar">
                            <form class="d-flex border rounded-3 p-2" role="search">
                                <input class="form-control border-0 me-2 py-2" type="search" placeholder="Search"
                                    aria-label="Search">
                                <button class="btn rounded-3 p-3 d-flex align-items-center" type="submit">
                                    <svg class="search text-light" width="18" height="18">
                                        <use xlink:href="#search"></use>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="widget-product-categories pt-5">
                        <div class="section-title overflow-hidden mb-2">
                            <h3 class="d-flex flex-column mb-0">Categories</h3>
                        </div>
                        <ul class="product-categories mb-0 sidebar-list list-unstyled">
                            <li class="cat-item">
                                <a href="<?=ROOT?>/shop" class="<?=!isset($category_id) ? 'text-primary fw-bold' : ''?>">All</a>
                            </li>
                            <?php if(isset($categories) && !empty($categories)): ?>
                                <?php foreach($categories as $category): ?>
                                    <li class="cat-item">
                                        <a href="<?=ROOT?>/shop/category/<?=$category->CategoryID?>" 
                                           class="<?=(isset($category_id) && $category_id == $category->CategoryID) ? 'text-primary fw-bold' : ''?>">
                                            <?=htmlspecialchars($category->Name)?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="widget-product-tags pt-5">
                        <div class="section-title overflow-hidden mb-2">
                            <h3 class="d-flex flex-column mb-0">Tags</h3>
                        </div>
                        <ul class="product-tags mb-0 sidebar-list list-unstyled">
                            <li class="tags-item">
                                <a href="#">Sci-Fi</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">Revenge</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">Zombie</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">Vampire</a>
                            </li>
                        </ul>
                    </div>
                    <div class="widget-product-authur pt-5">
                        <div class="section-title overflow-hidden mb-2">
                            <h3 class="d-flex flex-column mb-0">authur</h3>
                        </div>
                        <ul class="product-tags mb-0 sidebar-list list-unstyled">
                            <li class="tags-item">
                                <a href="#">Hanna Clark</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">Albert E. Beth</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">D.K John</a>
                            </li>
                        </ul>
                    </div>
                    <div class="widget-price-filter pt-5">
                        <div class="section-title overflow-hidden mb-2">
                            <h3 class="d-flex flex-column mb-0">Filter by price</h3>
                        </div>
                        <ul class="product-tags mb-0 sidebar-list list-unstyled">
                            <li class="tags-item">
                                <a href="#">Less than $10</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">$10- $20</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">$20- $30</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">$30- $40</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">$40- $50</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

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
            <h3 class="mb-4">Customers reviews</h3>
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
                    five essential gadg <span><a class="text-decoration-underline text-black-50"
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