<?php $this->view("header",$data);?>

<section class="hero-section position-relative padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h1 class="text-white">Blog</h1>
                    <div class="breadcrumbs">
                        <span class="item">
                            <a class="text-white" href="index.php">Home > </a>
                        </span>
                        <span class="item text-decoration-underline text-white">Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="blog" class="padding-large">
    <div class="container">
        <div class="row flex-row-reverse g-md-5">
            <main class="col-md-9 mb-4 mb-md-0">
                <div class="filter-blog d-flex flex-wrap justify-content-between mb-4">
                    <div class="showing-product">
                        <p>Showing 1-9 of 55 results</p>
                    </div>
                    <div class="sort-by">
                        <select id="sorting" class="form-select" data-filter-sort="" data-filter-order="">
                            <option value="">Latest to oldest</option>
                            <option value="">Oldest to latest</option>
                            <option value="">Popular</option>
                            <option value="">Name (A - Z)</option>
                            <option value="">Name (Z - A)</option>
                            <option value="">Model (A - Z)</option>
                            <option value="">Model (Z - A)</option>
                        </select>
                    </div>
                </div>
                <div class="row post-contents">
                    <div class="col-lg-4 col-md-6 posts mb-5">
                        <img src="<?=ASSETS?>images/The Three-Body Problem.jpg" alt="post image"
                            class="img-fluid rounded-3">
                        <a href="blog.php" class="fs-6 text-primary">Books</a>
                        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.php">The Three-Body
                                Problem</a></h4>
                        <p class="mb-2">When Earth makes contact with an alien civilization in crisis, humanity becomes
                            divided about how to respond. This award-winning Chinese sci-fi novel offers a unique
                            perspective on first contact. <span><a class="text-decoration-underline text-black-50"
                                    href="single-post.php">Read More</a></span>
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-6 posts mb-5">
                        <img src="<?=ASSETS?>images/Project Hail Mary By Andy Weir.jpg" alt="post image"
                            class="img-fluid rounded-3">
                        <a href="blog.php" class="fs-6 text-primary">Books</a>
                        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.php">Project Hail
                                Mary by Andy Weir</a></h4>
                        <p class="mb-2">A lone astronaut with amnesia must save humanity from extinction. Written by the
                            author of "The Martian," it features problem-solving science and unexpected alien
                            friendship. <span><a class="text-decoration-underline text-black-50"
                                    href="single-post.php">Read More</a></span>
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-6 posts mb-5">
                        <img src="<?=ASSETS?>images/Blindsight.jpg" alt="post image" class="img-fluid rounded-3">
                        <a href="blog.php" class="fs-6 text-primary">Books</a>
                        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.php">Blindsight by
                                Peter Watts</a></h4>
                        <p class="mb-2">A hard sci-fi first contact story with a crew of transhuman specialists
                            including a vampire captain. Explores consciousness and what it means to be human. <span><a
                                    class="text-decoration-underline text-black-50" href="single-post.php">Read
                                    More</a></span>
                        </p>
                    </div>
                </div>
                <nav class="pt-5" aria-label="Page navigation">
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
                </nav>
            </main>
            <aside class="col-md-3">
                <div class="sidebar">
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
                                <a href="/collections/categories">All</a>
                            </li>
                            <li class="cat-item">
                                <strong>Fiction</strong>
                                <ul class="list-unstyled ps-3">
                                    <li class="cat-item"><a href="#">Literary Fiction</a></li>
                                    <li class="cat-item"><a href="#">Science Fiction</a></li>
                                    <li class="cat-item"><a href="#">Fantasy</a></li>
                                    <li class="cat-item"><a href="#">Mystery &amp; Thriller</a></li>
                                    <li class="cat-item"><a href="#">Historical Fiction</a></li>
                                    <li class="cat-item"><a href="#">Horror</a></li>
                                    <li class="cat-item"><a href="#">Romance</a></li>
                                    <li class="cat-item"><a href="#">Adventure</a></li>
                                </ul>
                            </li>
                            <li class="cat-item">
                                <strong>Non-Fiction</strong>
                                <ul class="list-unstyled ps-3">
                                    <li class="cat-item"><a href="#">Biography &amp; Autobiography</a></li>
                                    <li class="cat-item"><a href="#">Self-Help &amp; Personal Development</a></li>
                                    <li class="cat-item"><a href="#">Business &amp; Finance</a></li>
                                    <li class="cat-item"><a href="#">Science &amp; Technology</a></li>
                                    <li class="cat-item"><a href="#">History</a></li>
                                    <li class="cat-item"><a href="#">Psychology</a></li>
                                    <li class="cat-item"><a href="#">Health &amp; Wellness</a></li>
                                    <li class="cat-item"><a href="#">Philosophy</a></li>
                                    <li class="cat-item"><a href="#">Travel</a></li>
                                </ul>
                            </li>
                            <li class="cat-item">
                                <strong>Educational &amp; Academic</strong>
                                <ul class="list-unstyled ps-3">
                                    <li class="cat-item"><a href="#">Textbooks</a></li>
                                    <li class="cat-item"><a href="#">Reference Books</a></li>
                                    <li class="cat-item"><a href="#">Research Papers</a></li>
                                    <li class="cat-item"><a href="#">Language Learning</a></li>
                                </ul>
                            </li>
                            <li class="cat-item">
                                <strong>Children's Books</strong>
                                <ul class="list-unstyled ps-3">
                                    <li class="cat-item"><a href="#">Picture Books</a></li>
                                    <li class="cat-item"><a href="#">Early Readers</a></li>
                                    <li class="cat-item"><a href="#">Young Adult (YA)</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="widget-product-tags pt-5">
                        <div class="section-title overflow-hidden mb-2">
                            <h3 class="d-flex flex-column mb-0">Tags</h3>
                        </div>
                        <ul class="product-tags mb-0 sidebar-list list-unstyled">
                            <li class="tags-item">
                                <a href="#">White</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">Cheap</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">Mobile</a>
                            </li>
                            <li class="tags-item">
                                <a href="#">Modern</a>
                            </li>
                        </ul>
                    </div> -->
                    <!-- <div class="widget-social-links pt-5">
                        <div class="section-title overflow-hidden mb-2">
                            <h3 class="d-flex flex-column mb-0">Social Links</h3>
                        </div>
                        <ul class="social-links mb-0 sidebar-list list-unstyled">
                            <li class="links">
                                <a href="#">Facebook</a>
                            </li>
                            <li class="links">
                                <a href="#">Instagram</a>
                            </li>
                            <li class="links">
                                <a href="#">Twitter</a>
                            </li>
                            <li class="links">
                                <a href="#">Youtube</a>
                            </li>
                            <li class="links">
                                <a href="#">Pinterest</a>
                            </li>
                        </ul>
                    </div> -->
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

<section id="instagram">
    <div class="container padding-large pb-0">
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

<?php $this->view("footer",$data);?>