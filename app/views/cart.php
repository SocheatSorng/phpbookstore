<?php $this->view("header",$data);?>

<section class="hero-section position-relative padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h1>Cart</h1>
                    <div class="breadcrumbs">
                        <span class="item">
                            <a href="index.html">Home > </a>
                        </span>
                        <span class="item text-decoration-underline">Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cart padding-large">
    <div class="container">
        <div class="row">
            <div class="cart-table">
                <div class="cart-header border-bottom border-top">
                    <div class="row d-flex text-capitalize">
                        <h4 class="col-lg-4 py-3 m-0">Product</h4>
                        <h4 class="col-lg-3 py-3 m-0">Quantity</h4>
                        <h4 class="col-lg-4 py-3 m-0">Subtotal</h4>
                    </div>
                </div>

                <?php if (!empty($data['cart_items'])): ?>
                <?php foreach ($data['cart_items'] as $item): ?>
                <div class="cart-item border-bottom padding-small">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-3">
                            <div class="cart-info d-flex gap-2 flex-wrap align-items-center">
                                <div class="col-lg-5">
                                    <div class="card-image">
                                        <img src="<?=ROOT?><?=htmlspecialchars($item['Image'] ?? 'uploads/products/default.png')?>"
                                            alt="<?=htmlspecialchars($item['Title'] ?? 'Product Image')?>"
                                            class="img-fluid border rounded-3">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card-detail">
                                        <h5 class="mt-2">
                                            <a href="<?=ROOT?>singleproduct/<?=htmlspecialchars($item['BookID'])?>">
                                                <?=htmlspecialchars($item['Title'])?>
                                            </a>
                                        </h5>
                                        <div class="card-price">
                                            <span class="price text-primary fw-light"
                                                data-currency-usd="$<?=number_format($item['Price'],2)?>">
                                                $<?=number_format($item['Price'],2)?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-7">
                            <div class="row d-flex">
                                <div class="col-md-6">
                                    <div class="product-quantity my-2">
                                        <div class="input-group product-qty align-items-center"
                                            style="max-width: 150px;">
                                            <span class="input-group-btn">
                                                <button type="button"
                                                    class="bg-white shadow border rounded-3 fw-light quantity-left-minus"
                                                    data-type="minus" data-field="">
                                                    <svg width="16" height="16">
                                                        <use xlink:href="#minus"></use>
                                                    </svg>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity_<?=htmlspecialchars($item['BookID'])?>"
                                                name="quantity"
                                                class="form-control bg-white shadow border rounded-3 py-2 mx-2 input-number text-center"
                                                value="<?=intval($item['Quantity'])?>" min="1" max="100" required>
                                            <span class="input-group-btn">
                                                <button type="button"
                                                    class="bg-white shadow border rounded-3 fw-light quantity-right-plus"
                                                    data-type="plus" data-field="">
                                                    <svg width="16" height="16">
                                                        <use xlink:href="#plus"></use>
                                                    </svg>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="total-price">
                                        <span class="money fs-2 fw-light text-primary">
                                            $<?=number_format($item['Price'] * $item['Quantity'], 2)?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-1 col-md-2">
                            <div class="cart-cross-outline">
                                <a href="<?=ROOT?>cart/remove?book_id=<?=htmlspecialchars($item['BookID'])?>">
                                    <svg class="cart-cross-outline" width="38" height="38">
                                        <use xlink:href="#cart-cross-outline"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="cart-item border-bottom padding-small">
                    <p>Your cart is empty.</p>
                </div>
                <?php endif; ?>
            </div>

            <?php $cart_total = $data['cart_total'] ?? 0; ?>
            <div class="cart-totals padding-medium pb-0">
                <h3 class="mb-3">Cart Totals</h3>
                <div class="total-price pb-3">
                    <table cellspacing="0" class="table text-capitalize">
                        <tbody>
                            <tr class="subtotal pt-2 pb-2 border-top border-bottom">
                                <th>Subtotal</th>
                                <td data-title="Subtotal">
                                    <span class="price-amount amount text-primary ps-5 fw-light">
                                        <bdi>
                                            <span
                                                class="price-currency-symbol">$</span><?=number_format($cart_total, 2)?>
                                        </bdi>
                                    </span>
                                </td>
                            </tr>
                            <tr class="order-total pt-2 pb-2 border-bottom">
                                <th>Total</th>
                                <td data-title="Total">
                                    <span class="price-amount amount text-primary ps-5 fw-light">
                                        <bdi>
                                            <span
                                                class="price-currency-symbol">$</span><?=number_format($cart_total, 2)?>
                                        </bdi>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="button-wrap d-flex flex-wrap gap-3">
                    <button type="button" class="btn" id="update-cart">Update Cart</button>
                    <a href="<?=ROOT?>" class="btn">Continue Shopping</a>
                    <a href="<?=ROOT?>checkout" class="btn">Proceed to checkout</a>
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

<?php $this->view("footer",$data);?>