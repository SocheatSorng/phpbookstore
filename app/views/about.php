<?php $this->view("header",$data);?>

<section class="hero-section position-relative padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h1>About Us</h1>
                    <div class="breadcrumbs">
                        <span class="item">
                            <a href="index.php">Home > </a>
                        </span>
                        <span class="item text-decoration-underline">About Us</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="company-services" class="padding-large">
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
                        <p>Consectetur adipi elit lorem ipsum dolor sit amet.</p>
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
                        <p>Dolor sit amet orem ipsu mcons ectetur adipi elit.</p>
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
                        <p>Amet consectetur adipi elit loreme ipsum dolor sit.</p>
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
                        <p>Rem Lopsum dolor sit amet, consectetur adipi elit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about-us" class="padding-large pt-0">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="image-holder position-relative mb-4 d-flex align-items-center justify-content-center">
                    <a type="button" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/l4MOE3hZATA"
                        data-bs-target="#myModal" class="play-btn position-absolute">
                        <div class="play-icon border border-2 border-dark rounded-pill p-5">
                            <svg class="search" width="40" height="40">
                                <use xlink:href="#play"></use>
                            </svg>
                        </div>
                    </a>
                    <div class="image">
                        <img src="<?=ASSETS?>images/Don Quixote.jpg" alt="single"
                            class="img-fluid rounded-3 single-image">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail ps-md-5 mt-5">
                    <div class="display-header">
                        <h3 class="mb-3">Recommend Fiction Book Story</h3>
                        <h2 class="mb-3">Don Quixote</h2>
                        <p class="pb-1">This book is about a man named **Alonso Quixano** who reads so many adventure
                            stories that he starts to believe he is a real knight. He calls himself **Don Quixote** and
                            sets out on a journey to do brave and noble deeds. With his loyal friend, **Sancho Panza**,
                            he goes on silly adventures, thinking windmills are giant monsters and small inns are
                            castles. The story is funny but also makes us think about dreams, reality, and how people
                            see the world differently.
                        <p></p>
                        <a href="shop" class="btn mt-3">Go to shop</a>
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

<?php $this->view("footer",$data);?>