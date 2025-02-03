<?php $this->view("header",$data);?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://checkout.payway.com.kh/plugins/checkout2-0.js"></script>
<section class="hero-section position-relative padding-large"
    style="background-image: url(<?=ASSETS?>images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h1>Checkout</h1>
                    <div class="breadcrumbs">
                        <span class="item">
                            <a href="<?=ROOT?>">Home > </a>
                        </span>
                        <span class="item">Cart > </span>
                        <span class="item">Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="checkout-wrap padding-large">
    <div class="container">
        <?php if(isset($data['error'])): ?>
        <div class="alert alert-danger">
            <?=$data['error']?>
        </div>
        <?php endif; ?>

        <?php if(isset($data['errors']) && is_array($data['errors'])): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach($data['errors'] as $error): ?>
                <li><?=$error?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="POST" class="form-group">
            <div class="row d-flex flex-wrap">
                <div class="col-lg-6">
                    <h3 class="mb-4">Billing Details</h3>
                    <div class="billing-details">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstname">First Name*</label>
                                <input type="text" id="firstname" name="firstname" class="form-control"
                                    value="<?=$_POST['firstname'] ?? ''?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname">Last Name*</label>
                                <input type="text" id="lastname" name="lastname" class="form-control"
                                    value="<?=$_POST['lastname'] ?? ''?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email Address*</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="<?=$_POST['email'] ?? ''?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone">Phone*</label>
                            <input type="tel" id="phone" name="phone" class="form-control"
                                value="<?=$_POST['phone'] ?? ''?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="address">Street Address*</label>
                            <input type="text" id="address" name="address" class="form-control"
                                value="<?=$_POST['address'] ?? ''?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city">City*</label>
                                <input type="text" id="city" name="city" class="form-control"
                                    value="<?=$_POST['city'] ?? ''?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="country">Country*</label>
                                <select id="country" name="country" class="form-control" required>
                                    <option value="">Select Country</option>
                                    <option value="KH"
                                        <?=isset($_POST['country']) && $_POST['country'] == 'KH' ? 'selected' : ''?>>
                                        Cambodia</option>
                                    <option value="US"
                                        <?=isset($_POST['country']) && $_POST['country'] == 'US' ? 'selected' : ''?>>
                                        United States</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="zipcode">ZIP Code*</label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control"
                                value="<?=$_POST['zipcode'] ?? ''?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="cart-totals padding-medium">
                        <h3 class="mb-4">Order Summary</h3>
                        <table class="table">
                            <tbody>
                                <?php if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])): ?>
                                <?php foreach($_SESSION['cart'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?=$item['image']?>" alt="<?=$item['name']?>"
                                                style="width: 50px; margin-right: 10px;">
                                            <div>
                                                <h6 class="mb-0"><?=$item['name']?></h6>
                                                <small>Quantity: <?=$item['quantity']?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">$<?=number_format($item['price'] * $item['quantity'], 2)?></td>
                                </tr>
                                <?php endforeach; ?>

                                <tr class="border-top">
                                    <td><strong>Subtotal</strong></td>
                                    <td class="text-end"><strong>$<?=number_format($data['subtotal'] ?? 0, 2)?></strong>
                                    </td>
                                </tr>

                                <tr class="border-top">
                                    <td><strong>Total</strong></td>
                                    <td class="text-end"><strong
                                            class="text-primary fs-5">$<?=number_format($data['total'] ?? 0, 2)?></strong>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary w-100 mt-4">Place Order</button>
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
<!-- Replace PayWay modal form -->
<div id="aba_main_modal" class="aba-modal">
    <div class="aba-modal-content">
        <form method="POST" target="aba_webservice"
            action="https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase"
            id="aba_merchant_request">
            <?php if(isset($data['payway_form'])): ?>
            <?php foreach($data['payway_form'] as $key => $value): ?>
            <input type="hidden" name="<?php echo htmlspecialchars($key); ?>"
                value="<?php echo htmlspecialchars($value); ?>">
            <?php endforeach; ?>
            <?php endif; ?>
        </form>
    </div>
</div>

<style>
.aba-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow-y: auto;
}

.aba-modal-content {
    background-color: #fefefe;
    margin: 2% auto;
    padding: 20px;
    width: 90%;
    max-width: 900px;
    position: relative;
    border-radius: 8px;
}

.aba-iframe-wrapper {
    position: relative;
    width: 100%;
    min-height: 600px;
}

.aba-iframe-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>

<!-- Update JavaScript -->
<script>
$(document).ready(function() {
    const checkoutForm = document.querySelector('form.form-group');

    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(checkoutForm.action, {
                method: 'POST',
                body: new FormData(checkoutForm),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update PayWay form with received data
                    const abaForm = document.getElementById('aba_merchant_request');
                    for (const [key, value] of Object.entries(data.form_data)) {
                        let input = abaForm.querySelector(`input[name="${key}"]`);
                        if (!input) {
                            input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            abaForm.appendChild(input);
                        }
                        input.value = value;
                    }

                    // Use PayWay checkout function
                    AbaPayway.checkout();
                } else {
                    alert(data.error || 'Payment initialization failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });
});
</script>

<?php $this->view("footer",$data);?>