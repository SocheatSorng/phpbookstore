<?php $this->view("header",$data);?>

    <section class="hero-section position-relative padding-large"
      style="background-image: url(<?=ASSETS?>images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
      <div class="hero-content">
        <div class="container">
          <div class="row">
            <div class="text-center">
              <h1>Checkout</h1>
              <div class="breadcrumbs">
                <span class="item">
                  <a href="index.html">Home > </a>
                </span>
                <span class="item text-decoration-underline">Checkout</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="checkout-wrap padding-large">
      <div class="container">
        <form class="form-group">
          <div class="row d-flex flex-wrap">
            <div class="col-lg-6">
              <h3 class="mb-3">Billing Details</h3>
              <div class="billing-details">
                <label for="fname">First Name*</label>
                <input type="text" id="fname" name="firstname" class="form-control mt-2 mb-4 ps-3">
                <label for="lname">Last Name*</label>
                <input type="text" id="lname" name="lastname" class="form-control mt-2 mb-4 ps-3">
                <label for="cname">Company Name(optional)*</label>
                <input type="text" id="cname" name="companyname" class="form-control mt-2 mb-4">
                <label for="cname">Country / Region*</label>
                <select class="form-select form-control mt-2 mb-4" aria-label="Default select example">
                  <option selected="" hidden="">United States</option>
                  <option value="1">UK</option>
                  <option value="2">Australia</option>
                  <option value="3">Canada</option>
                </select>
                <label for="address">Street Address*</label>
                <input type="text" id="adr" name="address" placeholder="House number and street name"
                  class="form-control mt-3 ps-3 mb-3">
                <input type="text" id="adr" name="address" placeholder="Appartments, suite, etc."
                  class="form-control ps-3 mb-4">
                <label for="city">Town / City *</label>
                <input type="text" id="city" name="city" class="form-control mt-3 ps-3 mb-4">
                <label for="state">State *</label>
                <select class="form-select form-control mt-2 mb-4" aria-label="Default select example">
                  <option selected="" hidden="">Florida</option>
                  <option value="1">New York</option>
                  <option value="2">Chicago</option>
                  <option value="3">Texas</option>
                  <option value="3">San Jose</option>
                  <option value="3">Houston</option>
                </select>
                <label for="zip">Zip Code *</label>
                <input type="text" id="zip" name="zip" class="form-control mt-2 mb-4 ps-3">
                <label for="email">Phone *</label>
                <input type="text" id="phone" name="phone" class="form-control mt-2 mb-4 ps-3">
                <label for="email">Email address *</label>
                <input type="text" id="email" name="email" class="form-control mt-2 mb-4 ps-3">
              </div>
            </div>
            <div class="col-lg-6">
              <div>
                <h3 class="mb-3">Additional Information</h3>
                <div class="billing-details">
                  <label for="fname">Order notes (optional)</label>
                  <textarea class="form-control pt-3 pb-3 ps-3 mt-2"
                    placeholder="Notes about your order. Like special notes for delivery."></textarea>
                </div>
              </div>

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
                              <span class="price-currency-symbol">$</span>2,400.00
                            </bdi>
                          </span>
                        </td>
                      </tr>
                      <tr class="order-total pt-2 pb-2 border-bottom">
                        <th>Total</th>
                        <td data-title="Total">
                          <span class="price-amount amount text-primary ps-5 fw-light">
                            <bdi>
                              <span class="price-currency-symbol">$</span>2,400.00</bdi>
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="list-group">
                  <label class="list-group-item d-flex gap-2 border-0">
                    <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios"
                      id="listGroupRadios1" value="" checked>
                    <span>
                      <p class="mb-1">Direct bank transfer</p>
                      <small>Make your payment directly into our bank account. Please use your Order ID. Your order will
                        shipped after funds have cleared in our account.</small>
                    </span>
                  </label>
                  <label class="list-group-item d-flex gap-2 border-0">
                    <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios"
                      id="listGroupRadios2" value="">
                    <span>
                      <p class="mb-1">Check payments</p>
                      <small>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store
                        Postcode.</small>
                    </span>
                  </label>
                  <label class="list-group-item d-flex gap-2 border-0">
                    <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios"
                      id="listGroupRadios3" value="">
                    <span>
                      <p class="mb-1">Cash on delivery</p>
                      <small>Pay with cash upon delivery.</small>
                    </span>
                  </label>
                  <label class="list-group-item d-flex gap-2 border-0">
                    <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios"
                      id="listGroupRadios3" value="">
                    <span>
                      <p class="mb-1">Paypal</p>
                      <small>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</small>
                    </span>
                  </label>
                </div>
                <div class="button-wrap mt-3">
                  <button type="submit" name="submit" class="btn">Place an order</button>
                </div>
              </div>

            </div>

          </div>
        </form>
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