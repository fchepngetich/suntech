<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php $currency = getenv('CURRENCY') ?? 'Ksh'; ?>

    <section class="shop checkout section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>

            <div class="row ml-1">
                <div class="col-lg-9 col-12 card">
                    <div class="container mt-2">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>
                    </div>


                    <div class="checkout-form p-2 ">
                        <h2>Delivery and Billing Information</h2>
                        <p>Please fill in all the required fields below</p>

                        <form method="post" class="row" id="checkoutForm"
                            action="<?= base_url($orderData ? 'checkout/updateCheckoutForm' : 'checkout/submitCheckoutForm') ?>">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fi-fullName">Full Name</label>
                                    <input type="text" class="form-control" id="fi-fullName" name="full_name"
                                        value="<?= esc($orderData['full_name'] ?? $userData['username']) ?>"
                                        placeholder="Enter your Full Name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fi-phone">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">+254</span>
                                        </div>
                                        <input type="tel" class="form-control" id="fi-phone" name="phone"
                                            value="<?= esc($orderData['phone'] ?? $userData['phone']) ?>"
                                            placeholder="Enter your Phone Number" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fi-additionalPhone">Additional Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">+254</span>
                                        </div>
                                        <input type="tel" class="form-control" id="fi-additionalPhone"
                                            name="additional_phone"
                                            value="<?= esc($orderData['additional_phone'] ?? '') ?>"
                                            placeholder="Enter your Additional Phone Number">
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fi-address">Address</label>
                                    <input type="text" class="form-control" id="fi-address" name="address"
                                        value="<?= esc($orderData['address1'] ?? '') ?>"
                                        placeholder="Enter your Address" required>
                                </div>
                            </div>

                            <!-- Additional Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fii-address">Additional Address</label>
                                    <input type="text" class="form-control" id="fii-address" name="address2"
                                        value="<?= esc($orderData['address2'] ?? '') ?>"
                                        placeholder="Enter your Additional Address">
                                </div>
                            </div>

                            <!-- Region -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fi-region">County</label>
                                    <select class="form-control" id="fi-region" name="region" required>
                                        <option value="" disabled>Select County</option>
                                        <?php foreach ($counties as $county): ?>
                                            <option value="<?= htmlspecialchars($county) ?>" <?= isset($orderData['region']) && $orderData['region'] === $county ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($county) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>


                            <!-- Delivery Method -->
                            <div class="col-md-12">
                                <h6>Please Select Delivery Method</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_method"
                                        id="standardDelivery" value="standard" <?= isset($orderData['delivery_method']) && $orderData['delivery_method'] === 'standard' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="standardDelivery">Free Delivery</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_method"
                                        id="expressDelivery" value="express" <?= isset($orderData['delivery_method']) && $orderData['delivery_method'] === 'express' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="expressDelivery">Delivery via Courier</label>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-12">
                                <h6>Please Select Payment Method</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="creditCard"
                                        value="credit_card" <?= isset($orderData['payment_method']) && $orderData['payment_method'] === 'credit_card' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="creditCard">Credit Card</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="mpesa"
                                        value="mpesa" <?= isset($orderData['payment_method']) && $orderData['payment_method'] === 'mpesa' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="mpesa">M-Pesa</label>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="col-md-12 text-left mt-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                            <!-- CSRF Token -->
                            <?= csrf_field() ?>

                        </form>
                    </div>

                </div>

                <div class="col-lg-3 col-12">
                    <section class="shop-services">
                        <div class="col-md-12">
                            <div class="total-amount card p-3">
                                <h6 class="p-2">Cart Summary</h6>
                                <hr>
                                <ul class="list-unstyled">
                                    <?php $deliveryFee = 0;
                                    $finalAmount = $total + $deliveryFee; ?>
                                    <li>Cart Subtotal - <span><?= esc($currency) ?>
                                            <?= number_format($total, 2) ?></span></li>
                                    <li>Delivery Fee - <span><?= esc($currency) ?>
                                            <?= number_format($deliveryFee, 2) ?></span></li>
                                    <li class="font-weight-bold">You Pay - <span><?= esc($currency) ?>
                                            <?= number_format($finalAmount, 2) ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <a class="btn btn-success mt-4 btn-block" href="#" data-toggle="modal"
                            data-target="#mpesaModal">
                            Proceed to Payment
                        </a>
                    </section>
                </div>
            </div>

        </div>
    </section>

    <!-- M-Pesa Payment Modal -->
    <div class="modal fade" id="mpesaModal" tabindex="-1" role="dialog" aria-labelledby="mpesaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="mpesaPaymentForm">
                        <div class="form-group">
                            <label for="mpesaPhone">Phone Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+254</span>
                                </div>
                                <input type="tel" class="form-control" id="mpesaPhone" name="phone"
                                    placeholder="Enter M-Pesa Phone Number" required>
                            </div>
                            <small class="form-text text-muted">Please enter a valid M-Pesa phone number.</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Initiate Payment</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <?= $this->section('stylesheets') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/flexslider.min.css">
    <?= $this->endSection() ?>


    <?= $this->section('scripts') ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/jquery.flexslider-min.js"></script>

    <script>
        $(document).ready(function () {
            function validatePhoneNumber(phone) {
                const regex = /^254\d{9}$/;
            }

            $('#mpesaPaymentForm').on('submit', function (e) {
                e.preventDefault();
                let callbackUrl = '<?= base_url('payments/callback') ?>';

                let phone = $('#mpesaPhone').val().replace(/^0/, '254'); // Convert 07x to 2547x
                let amount = <?= json_encode($total) ?>;

                console.log('Phone:', phone); // Log phone number to confirm correct format

                if (!validatePhoneNumber(phone)) {
                    alert('Invalid phone number format. Please enter a valid number.');
                    return;
                }

                console.log('Initiating payment with:', { phone, amount });

                $.ajax({
                    url: '<?= base_url('payments/initiate') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        phone: phone,
                        amount: amount,
                        callback_url: callbackUrl,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    success: function (response) {
                        console.log('Response:', response);
                        if (response.status === 'success') {
                            alert('Payment initiated! Please complete the payment on your phone.');
                            $('#mpesaModal').modal('hide');
                        } else {
                            alert('Payment failed: ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('XHR Response:', xhr.responseText); // Log the raw response
                        alert('An error occurred. Please try again.');
                    }

                });
            });

        });
    </script>



    <?= $this->endSection() ?>

    <?= $this->endSection() ?>