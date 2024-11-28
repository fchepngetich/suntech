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

            <div class="row">
                <!-- Main Content: Tabs for Delivery, Billing, and Payment -->
                <div class="col-lg-9 col-12 card p-4">
                    <ul class="nav nav-tabs" id="checkoutTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="delivery-tab" data-toggle="tab" href="#delivery" role="tab"
                                aria-controls="delivery" aria-selected="true">
                                Delivery Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="billing-tab" data-toggle="tab" href="#billing" role="tab"
                                aria-controls="billing" aria-selected="false">
                                Billing Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab"
                                aria-controls="payment" aria-selected="false">
                                Payment
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="checkoutTabsContent">
                        <!-- Delivery Details Tab -->
                        <div class="tab-pane fade show active" id="delivery" role="tabpanel"
                            aria-labelledby="delivery-tab">
                            <h6>Delivery Details</h6>

                            <div class="container mt-4">
                                <?php if (!empty($userData['address1']) && !empty($userData['region'])): ?>
                                    <div id="user-details">
                                        <span>
                                            <strong>Name:</strong> <?= esc($userData['username'] ?? '') ?>,
                                            <strong>Phone:</strong> <?= esc($userData['phone'] ?? '') ?>,
                                            <strong>Additional Phone:</strong>
                                            <?= esc($userData['additionalPhone'] ?? '') ?>,
                                            <strong>Address:</strong> <?= esc($userData['address1']) ?>,
                                            <?= !empty($userData['address2']) ? esc($userData['address2']) . ', ' : '' ?>
                                            <strong>Region:</strong> <?= esc($userData['region']) ?>
                                            <a href="#" class="ml-2" onclick="showEditForm()" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                        </span>
                                    </div>


                                <?php endif; ?>

                                <form id="user-form" action="<?= base_url('checkout/save-details') ?>" method="post"
                                    style="<?= (!empty($userData['address1']) && !empty($userData['region'])) ? 'display: none;' : '' ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="full_name">Full Name</label>
                                                <input type="text" class="form-control" id="full_name" name="full_name"
                                                    value="<?= isset($userData['username']) ? esc($userData['username']) : '' ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="<?= isset($userData['phone']) ? esc($userData['phone']) : '' ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="additional_phone">Additional Phone</label>
                                                <input type="text" class="form-control" id="additional_phone"
                                                    name="additional_phone"
                                                    value="<?= isset($userData['additionalPhone']) ? esc($userData['additionalPhone']) : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="region">Region</label>
                                                <select class="form-control" id="region" name="region">
                                                    <?php foreach ($counties as $county): ?>
                                                        <option value="<?= esc($county) ?>" <?= (isset($userData['region']) && $userData['region'] == $county) ? 'selected' : '' ?>>
                                                            <?= esc($county) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="<?= isset($userData['address1']) ? esc($userData['address1']) : '' ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address2">Address 2</label>
                                                <input type="text" class="form-control" id="address2" name="address2"
                                                    value="<?= isset($userData['address2']) ? esc($userData['address2']) : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>

                            <!-- <form action="/checkout/delivery" method="POST">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="region">Region</label>
                                    <input type="text" id="region" name="region" class="form-control" required>
                                </div>
                                <button type="button" class="btn btn-primary mt-3" onclick="nextTab('billing')">Next:
                                    Billing Details</button>
                            </form> -->
                        </div>

                        <!-- Billing Details Tab -->
                        <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
                            <h6>Billing Details</h6>

                            <div class="container mt-4">
                                <!-- Display existing billing details if available -->
                                <?php if (!empty($userData['billing_address']) && !empty($userData['billing_phone'])): ?>
                                    <div id="billing-details">
                                        <span>
                                            <strong>Billing Address:</strong> <?= esc($userData['billing_address']) ?>,
                                            <strong>Billing Phone:</strong> <?= esc($userData['billing_phone']) ?>
                                            <a href="#" class="ml-2" onclick="showBillingForm()" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- Form for entering or editing billing details -->
                                <form id="billing-form" action="<?= base_url('/checkout/billing') ?>" method="post"
                                    style="<?= (!empty($userData['billing_address']) && !empty($userData['billing_phone'])) ? 'display: none;' : '' ?>">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label for="billing_address">Billing Address</label>
                                        <input type="text" id="billing_address" name="billing_address"
                                            class="form-control"
                                            value="<?= isset($userData['billing_address']) ? esc($userData['billing_address']) : '' ?>"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_phone">Billing Phone</label>
                                        <input type="text" id="billing_phone" name="billing_phone" class="form-control"
                                            value="<?= isset($userData['billing_phone']) ? esc($userData['billing_phone']) : '' ?>"
                                            required>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" id="sameAsDelivery" name="same_as_delivery"
                                            class="form-check-input" onclick="copyDeliveryDetails()">
                                        <label for="sameAsDelivery" class="form-check-label">Same as delivery
                                            details</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                                </form>
                            </div>
                        </div>


                        <!-- Payment Tab -->
                        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                            <h6>Choose a Payment Method</h6>

                            <!-- Payment Method Selection -->
                            <div class="form-group">
                                <label for="paymentMethod">Payment Method</label>
                                <select id="paymentMethod" class="form-control" onchange="togglePaymentForms()">
                                    <option value="" disabled selected>Select Payment Method</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="bank">Bank</option>
                                </select>
                            </div>

                            <!-- M-Pesa Payment Form -->
                            <div id="mpesaForm" class="payment-form" style="display: none;">
                                <h6>M-Pesa Payment</h6>
                                <!-- <form action="<?= base_url('payment/process') ?>" method="post">
                                    <label for="amount">Amount:</label>
                                    <input type="number" name="amount" id="amount" required>
                                    <br><br>

                                    <label for="phone">Phone Number (254xxxxxxxxx):</label>
                                    <input type="text" name="phone" id="phone" required>
                                    <br><br>

                                    <button type="submit">Pay Now</button>
                                </form> -->
                                <form id="mpesaPaymentForm" method="post" action="<?= base_url('payments/initiate') ?>">
                                    <div class="form-group">
                                        <label for="mpesaPhone">Phone Number</label>
                                        <input type="tel" class="form-control" id="mpesaPhone" name="phone" placeholder="e.g., 254712345678" required>
                                    </div>
                                    <input type="hidden" name="amount" value="<?= $total ?>"> <!-- Assuming you have the amount available -->
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                    <button type="submit" class="btn btn-primary mt-4">Confirm to Payment</button>
                                </form>

                            </div>

                            <!-- Bank Payment Form -->
                            <div id="bankForm" class="payment-form" style="display: none;">
                                <h6>Bank Payment</h6>
                                <form id="bankPaymentForm" method="post">
                                    <div class="form-group">
                                        <label for="bankAccount">Bank Account Number</label>
                                        <input type="text" class="form-control" id="bankAccount" name="account"
                                            placeholder="e.g., 123456789" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="bankName">Bank Name</label>
                                        <input type="text" class="form-control" id="bankName" name="bank_name"
                                            placeholder="e.g., ABC Bank" required>
                                    </div>
                                    <button type="button" class="btn btn-primary mt-4"
                                        onclick="submitBankPayment()">Confirm Order</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <section class="shop-services">
                        <div class="total-amount card p-3">
                            <h6 class="p-2">Cart Summary</h6>
                            <hr>
                            <ul class="list-unstyled">
                                <?php $deliveryFee = 0;
                                $finalAmount = $total + $deliveryFee; ?>
                                <li>Cart Subtotal - <span><?= esc($currency) ?> <?= number_format($total, 2) ?></span>
                                </li>
                                <li>Delivery Fee - <span><?= esc($currency) ?>
                                        <?= number_format($deliveryFee, 2) ?></span></li>
                                <li class="font-weight-bold">You Pay - <span><?= esc($currency) ?>
                                        <?= number_format($finalAmount, 2) ?></span></li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
</div>
</section>




<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/flexslider.min.css">
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/jquery.flexslider-min.js"></script>

<script>
    function showBillingForm() {
        document.getElementById('billing-details').style.display = 'none';
        document.getElementById('billing-form').style.display = 'block';
    }

    function copyDeliveryDetails() {
        const sameAsDelivery = document.getElementById('sameAsDelivery').checked;
        if (sameAsDelivery) {
            const deliveryAddress = document.getElementById('address').value;
            const deliveryPhone = document.getElementById('phone').value;

            document.getElementById('billing_address').value = deliveryAddress;
            document.getElementById('billing_phone').value = deliveryPhone;
        } else {
            document.getElementById('billing_address').value = '';
            document.getElementById('billing_phone').value = '';
        }
    }

    function togglePaymentForms() {
        const paymentMethod = document.getElementById('paymentMethod').value;
        const mpesaForm = document.getElementById('mpesaForm');
        const bankForm = document.getElementById('bankForm');

        if (paymentMethod === 'mpesa') {
            mpesaForm.style.display = 'block';
            bankForm.style.display = 'none';
        } else if (paymentMethod === 'bank') {
            mpesaForm.style.display = 'none';
            bankForm.style.display = 'block';
        } else {
            mpesaForm.style.display = 'none';
            bankForm.style.display = 'none';
        }
    }

    function nextTab(tabId) {
        $(`[href="#${tabId}"]`).tab('show');
    }

    function showEditForm() {
        document.getElementById('user-details').style.display = 'none';
        document.getElementById('user-form').style.display = 'block';
    }

    $(document).ready(function () {
        function validatePhoneNumber(phone) {
            const regex = /^254\d{9}$/;
            return regex.test(phone);
        }

        window.submitPayment = function () {
            const phone = $('#mpesaPhone').val().replace(/^0/, '254');
            const amount = <?= json_encode($total) ?>;
            const callbackUrl = '<?= base_url('payments/callback') ?>';

            if (!validatePhoneNumber(phone)) {
                alert('Invalid phone number format. Please enter a valid number.');
                return;
            }

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
                    if (response.status === 'success') {
                        alert('Payment initiated successfully! Please complete the payment on M-Pesa.');
                    } else {
                        alert('Payment failed: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred. Please try again.');
                }
            });
        };
    });
    function showPaymentForm(paymentMethod) {
        $('.payment-form').hide();
        $('#' + paymentMethod + 'Form').show(); rm
    }

    function submitPayment() {
        const selectedPaymentMethod = $('input[name="paymentMethod"]:checked').val();
        if (selectedPaymentMethod === 'mpesa') {
            $('#mpesaPaymentForm').submit();
        } else if (selectedPaymentMethod === 'card') {
            $('#cardPaymentForm').submit();
        } else if (selectedPaymentMethod === 'bank') {
            alert("Please transfer to the provided bank details.");
        }
    }
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>
</div>