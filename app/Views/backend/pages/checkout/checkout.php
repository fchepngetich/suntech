<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
	<section class="shop checkout section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="checkout-form">
                    <h2>Make Your Checkout Here</h2>
                    <p>Please register in order to checkout more quickly</p>
                    <form class="form" method="post" action="<?= site_url('checkout/submit') ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label>Full Name<span>*</span></label>
                                    <input type="text" name="first_name" placeholder="Enter your first name" required>
                                </div>
                            </div>
                           
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label>Email Address<span>*</span></label>
                                    <input type="email" name="email" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label>Phone Number<span>*</span></label>
                                    <input type="text" name="phone" placeholder="Enter your phone number" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label>Country<span>*</span></label>
                                    <select name="country" required>
                                        <option value="AF">Afghanistan</option>
                                        <!-- Add other country options here -->
                                        <option value="US">United States</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Checkout</button>
                    </form>
                </div>
            </div>
			<div class="col-lg-8 col-12">
			<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Free shipping</h4>
                    <p>Orders over $100</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Free Return</h4>
                    <p>Within 30 days returns</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Secure Payment</h4>
                    <p>100% secure payment</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Best Price</h4>
                    <p>Guaranteed price</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>

        <!-- Cart Details Section -->
        <div class="row">
            <div class="col-lg-12">
                <h4>Cart summary</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= esc($item['name']); ?></td>
                            <td><?= esc($item['qty']); ?></td>
                            <td><?= esc($item['price']); ?></td>
                            <td><?= esc($item['subtotal']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h4>Total: $<?= esc($total); ?></h4>
            </div>
        </div>
    </div>
</section>
<form action="<?= base_url('mpesa/initiate'); ?>" method="POST">
<?= csrf_field(); ?>
    <input type="text" name="phone_number" placeholder="Enter phone number" required>
    <input type="number" name="amount" placeholder="Enter amount" required>
    <button type="submit">Pay Now</button>
</form>

<a class="btn mt-5 mr-auto" href="<?= base_url('/checkout/process')?>">Proceed to Payment</a>
			</div>
        </div>
    </div>
</section>







	<?= $this->endSection() ?>