<?php $this->view("header",$data);?>

<section class="hero-section position-relative padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg-3.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h1 class="text-white">Contact</h1>
                    <div class="breadcrumbs">
                        <span class="item">
                            <a class="text-white" href="index.php">Home > </a>
                        </span>
                        <span class="item text-decoration-underline text-white">Contact</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="contact-us padding-large">
    <div class="container">
        <div class="row">
            <div class="contact-info col-lg-6 pb-3">
                <h3>Contact info</h3>
                <p class="mb-5">Contact us @</p>
                <div class="page-content d-flex flex-wrap">
                    <div class="col-lg-6 col-sm-12">
                        <div class="content-box text-dark pe-4 mb-5">
                            <h5 class="fw-bold">Office</h5>
                            <div class="contact-address pt-3">
                                <p>Phnom Penh, Cambodia</p>
                            </div>
                            <div class="contact-number">
                                <p>
                                    <a href="#">+855 12345678</a>
                                </p>
                                <p>
                                    <a href="#">+855 12345678</a>
                                </p>
                            </div>
                            <div class="email-address">
                                <p>
                                    <a href="#">sastra@gmail.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="content-box">
                            <h5 class="fw-bold">Management</h5>
                            <div class="contact-address pt-3">
                                <p>Phnom Penh, Cambodia</p>
                            </div>
                            <div class="contact-number">
                                <p>
                                    <a href="#">+855 12345678</a>
                                </p>
                                <p>
                                    <a href="#">+855 12345678</a>
                                </p>
                            </div>
                            <div class="email-address">
                                <p>
                                    <a href="#">socheat@gmail.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inquiry-item col-lg-6">
                <h3>Any questions?</h3>
                <p class="mb-5">Use the form below to get in touch with us.</p>

                <form id="form" class="d-flex gap-3 flex-wrap">
                    <div class="w-100 d-flex gap-3">
                        <div class="w-50">
                            <input type="text" name="name" placeholder="Write your name here *"
                                class="form-control w-100">
                        </div>
                        <div class="w-50">
                            <input type="text" name="email" placeholder="Write your email here *"
                                class="form-control w-100">
                        </div>
                    </div>
                    <div class="w-100">
                        <input type="text" name="phone" placeholder="Phone number" class="form-control w-100">
                    </div>
                    <div class="w-100">
                        <input type="text" name="subject" placeholder="Write your subject here"
                            class="form-control w-100">
                    </div>
                    <div class="w-100">
                        <textarea placeholder="Write your message here *" class="form-control w-100"></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn my-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<section id="our-store" class="padding-large pt-0">
    <div class="container">
        <div class="row d-flex flex-wrap align-items-center">
            <div class="col-lg-6">
                <div class="image-holder mb-5">
                    <img src="<?=ASSETS?>images/single-image2.jpg" alt="our-store" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="locations-wrap ms-lg-5">
                    <div class="display-header">
                        <h3>Our stores</h3>
                        <p class="mb-5">You can also directly buy products from our stores.</p>
                    </div>
                    <div class="location-content d-flex flex-wrap">
                        <div class="col-lg-6 col-sm-12">
                            <div class="content-box text-dark pe-4 mb-5">
                                <h5 class="fw-bold">Cambodia</h5>
                                <div class="contact-address pt-3">
                                    <p>Phnom Penh, Cambodia</p>
                                </div>
                                <div class="contact-number">
                                    <p>
                                        <a href="#">+855 12345678</a>
                                    </p>
                                </div>
                                <div class="email-address">
                                    <p>
                                        <a href="#"></a>
                                    </p>
                                </div>
                            </div>
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

<?php $this->view("footer",$data);?>