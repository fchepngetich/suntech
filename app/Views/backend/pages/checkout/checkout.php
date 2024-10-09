<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <section class="shop checkout section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
    <div class="checkout-form">
        <h2>Make Your Checkout Here</h2>
        <p>Please register in order to checkout more quickly</p>
        <div class="container">
            <!-- Checkout Steps as Tabs -->
            <ul class="nav nav-tabs" id="checkoutTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="address-tab" data-toggle="tab" href="#address"
                       role="tab" aria-controls="address" aria-selected="true">Delivery Address</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="delivery-tab" data-toggle="tab" href="#delivery" role="tab"
                       aria-controls="delivery" aria-selected="false">Delivery Method</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="payment-tab" data-toggle="tab" href="#payment" role="tab"
                       aria-controls="payment" aria-selected="false">Payment Method</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" id="confirmation-tab" data-toggle="tab" href="#confirmation"
                       role="tab" aria-controls="confirmation" aria-selected="false">Order Confirmation</a>
                </li>
            </ul>

            <div class="tab-content" id="checkoutTabContent">
                <!-- Step 1: Delivery Address -->
                <div class="tab-pane fade show active" id="address" role="tabpanel"
                     aria-labelledby="address-tab">
                    <form method="post" class="row" id="addressForm" action="<?= base_url('checkout/submitCheckoutForm') ?>">
                        <!-- First and Last Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fi-firstName">Full Name</label>
                                <input type="text" class="form-control" id="fi-firstName" name="firstName" placeholder="Enter your First Name" value="<?= esc($user['username'] ?? '') ?>" required>
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fi-phone">Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+254</span>
                                    </div>
                                    <input type="tel" class="form-control" id="fi-phone" name="phone" placeholder="Enter your Phone Number" value="<?= esc($user['phone'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Phone Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fi-additionalPhone">Additional Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+254</span>
                                    </div>
                                    <input type="tel" class="form-control" id="fi-additionalPhone" name="additionalPhone" placeholder="Enter your Additional Phone Number" value="<?= esc($user['additional_phone'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fi-address1">Address</label>
                                <input type="text" class="form-control" id="fi-address1" name="address1" placeholder="Enter your Address" value="<?= esc($user['address1'] ?? '') ?>" required>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fi-address2">Additional Information</label>
                                <input type="text" class="form-control" id="fi-address2" name="address2" placeholder="Enter Additional Information" value="<?= esc($user['address2'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Region -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fi-regionId">Region</label>
                                <select class="form-control" id="fi-regionId" name="regionId" required>
                                    <option value="" disabled <?= empty($user['region']) ? 'selected' : '' ?>>Please select</option>
                                    <option value="381" <?= $user['region'] == '381' ? 'selected' : '' ?>>Baringo</option>
                                    <option value="373" <?= $user['region'] == '373' ? 'selected' : '' ?>>Kiambu</option>
                                    <!-- Add other regions as needed -->
                                </select>
                            </div>
                        </div>

                        <!-- City -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fi-cityId">City</label>
                                <select class="form-control" id="fi-cityId" name="cityId" required>
                                    <option value="" disabled <?= empty($user['city']) ? 'selected' : '' ?>>Please select</option>
                                    <option value="1480" <?= $user['city'] == '1480' ? 'selected' : '' ?>>Ruiru-Kihunguro/Bypass/Membley</option>
                                    <!-- Add other cities as needed -->
                                </select>
                            </div>
                        </div>

                        <!-- Save and Cancel Buttons -->
                        <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-secondary" href="/checkout/addresses/">Cancel</a>
                        </div>

                        <!-- CSRF Token -->
                        <?= csrf_field() ?>
                    </form>
                </div>

                <!-- Step 2: Delivery Method -->
                <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                    <form method="post" id="deliveryMethodForm" action="<?= base_url('checkout/saveDeliveryMethod') ?>">
                    <?= csrf_field() ?>

                        <h3>Select Delivery Method</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deliveryMethod" id="standardDelivery" value="standard" required>
                            <label class="form-check-label" for="standardDelivery">Free Delivery</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deliveryMethod" id="expressDelivery" value="express" required>
                            <label class="form-check-label" for="expressDelivery">Delivery via Courier</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save and Continue</button>
                    </form>
                </div>

                <!-- Step 3: Payment Method -->
                <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                    <form method="post" id="paymentMethodForm" action="<?= base_url('checkout/savePaymentMethod') ?>">
                    <?= csrf_field() ?>

                    <h3>Select Payment Method</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" value="credit_card" required>
                            <label class="form-check-label" for="creditCard">Credit Card</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="mpesa" value="mpesa" required>
                            <label class="form-check-label" for="mpesa">M-Pesa</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save and Continue</button>
                    </form>
                </div>

                <!-- Step 4: Order Confirmation -->
                <div class="tab-pane fade" id="confirmation" role="tabpanel" aria-labelledby="confirmation-tab">
                    <h3>Order Confirmation</h3>
                    <p>Review your order details and confirm your purchase.</p>
                    <form id="confirmationForm" method="post" action="<?= base_url('checkout/confirmOrder') ?>">
                        <button type="submit" class="btn btn-primary">Confirm Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

                    <div class="col-lg-3 col-12">
                        <section class="shop-services section home">
                            <div class="col-md-12">
                                <!-- Total Amount -->
                                <div class="total-amount">
                                    <div class="row">

                                        <div class="col-lg-12 col-md-6 col-12 card">
                                            <h6 class="p-2">Cart Summary</h6>
                                            <hr>
                                            <div class="right">
                                                <ul>
                                                    <li>Cart Subtotal<span>$<?= number_format($total, 2) ?></span></li>
                                                    <li>Delivery fees not included yet.</li>
                                                    <li class="last">You
                                                        Pay<span>$<?= number_format($total, 2) ?></span>
                                                    </li>
                                                </ul>
                                                <div class="button5 mb-2">
                                                    <a href="<?= base_url('/checkout') ?>" class="btn">Checkout</a>
                                                    <!-- <a href="<?= base_url(relativePath: '/') ?>" class="btn">Continue shopping</a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Total Amount -->
                            </div>

                        </section>
                        <form action="<?= base_url('mpesa/initiate'); ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="text" name="phone_number" placeholder="Enter phone number" required>
                            <input type="number" name="amount" placeholder="Enter amount" required>
                            <button type="submit">Pay Now</button>
                        </form>

                        <a class="btn mt-5 mr-auto" href="<?= base_url('/checkout/process') ?>">Proceed to Payment</a>
                    </div>
                </div>
            </div>
    </section>

    <?= $this->section('scripts') ?>
    <!-- Add JavaScript to handle tab navigation -->
<script>
$(document).ready(function() {
    // Handle form submission for address form
    $('#addressForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Send data via AJAX
        $.ajax({
            type: 'POST',
            url: '<?= base_url("checkout/submitCheckoutForm") ?>',
            data: $(this).serialize(),
            success: function(response) {
                // Switch to the delivery method tab after successful form submission
                $('#delivery-tab').removeClass('disabled').trigger('click');
            }
        });
    });

    // Handle form submission for delivery method form
    $('#deliveryMethodForm').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: '<?= base_url("checkout/saveDeliveryMethod") ?>',
            data: $(this).serialize(),
            success: function(response) {
                // Switch to the payment method tab
                $('#payment-tab').removeClass('disabled').trigger('click');
            }
        });
    });

    // Handle form submission for payment method form
    $('#paymentMethodForm').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: '<?= base_url("checkout/savePaymentMethod") ?>',
            data: $(this).serialize(),
            success: function(response) {
                // Switch to the confirmation tab
                $('#confirmation-tab').removeClass('disabled').trigger('click');
            }
        });
    });

    // Handle order confirmation
    $('#confirmationForm').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: '<?= base_url("checkout/confirmOrder") ?>',
            data: $(this).serialize(),
            success: function(response) {
                // Handle successful confirmation (e.g., redirect to a success page)
                window.location.href = '<?= base_url("checkout/success") ?>';
            }
        });
    });
});
</script>
    <?= $this->endSection() ?>
    <?= $this->endSection() ?>