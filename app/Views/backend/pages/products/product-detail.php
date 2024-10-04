<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>

    <div class="container shop-single mb-5 mt-5">
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfToken">

        <div class="row gx-5">
            <aside class="col-lg-6">
                <div class="border rounded-4 mb-3 d-flex justify-content-center">
                    <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image"
                        href="<?= base_url('/backend/' . $product['image']) ?>">
                        <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit"
                            src="<?= base_url('/backend/' . $product['image']) ?>" alt="<?= $product['name'] ?>">
                    </a>
                </div>
            </aside>
            <main class="col-lg-6">
                <div class="ps-lg-3">
                    <h4 class="title text-dark"><?= $product['name'] ?></h4>
                    <div class="mb-3">
                        <span class="h5">$<?= number_format($product['price'], 2) ?></span>
                        <span class="text-muted">/per item</span>
                    </div>
                    <p><?= $product['description'] ?></p>
                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-4 col-6 mb-3">
                            <label class="mb-2 d-block">Quantity</label>
                            <div class="input-group mb-3" style="width: 170px;">
                                <button class="btn btn-white border border-secondary px-3" type="button"
                                    id="decrease-qty" data-mdb-ripple-color="dark">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="form-control text-center border border-secondary" value="1"
                                    id="quantity" min="1" aria-label="Quantity">
                                <button class="btn btn-white border border-secondary px-3" type="button"
                                    id="increase-qty" data-mdb-ripple-color="dark">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-warning shadow-0"> Buy now </a>
                    <a title="Add to cart" class="btn btn-primary shadow-0 add-to-cart" data-id="<?= $product['id'] ?>"
                        href="#"><i class="me-1 fa fa-shopping-basket"></i>Add to cart</a>
                    <a href="#" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i
                            class="me-1 fa fa-heart fa-lg"></i> Add to Wishlist </a>
                </div>
            </main>
        </div>

        <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="cart-content">

                            <div class="shopping-items">
                                <div class="dropdown-cart-header">
                                    <?php $cart = \Config\Services::cart(); ?>
                                    <h5 class="modal-title" id="cartModalLabel">
                                        <span class="pl-4"><?= $cart->totalItems() ?> Items in the cart</span>
                                    </h5>
                                </div>
                                <ul class="shopping-lists">
                                    <?php if ($cart->contents()): ?>
                                        <?php foreach ($cart->contents() as $item): ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <a class="cart-img" href="#">
                                                            <img src="<?= base_url('/backend/' . $item['options']['image']) ?>"
                                                                alt="<?= esc($item['name']) ?>">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div>
                                                            <h4><a href="#"><?= esc($item['name']) ?></a></h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div>
                                                            <h4>
                                                                <a href="#">$<?= esc($item['price']) ?></a>
                                                                <!-- Display quantity here -->
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div>
                                                            <p>
                                                                <span class="quantitys">X<?= esc($item['qty']) ?></span>
                                                                <!-- Display quantity here -->
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li style="text-align: center;">
                                            <p>Your cart is empty!</p>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="bottom">
                                    <div>
                                        <span><?= $cart->totalItems() ?> Item(s) in the cart</span>
                                    </div>
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">$<?= number_format($cart->total(), 2) ?></span>
                                    </div>

                                </div>
                                <div class="bottom">
                                    <div class="checkout-continue">
                                        <a href="<?= base_url('/checkout') ?>" class=" btn checkout-btn">Checkout</a>
                                        <a href="<?= base_url('/') ?>" class="btn continue-shopping-btn">Continue
                                            Shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    jQuery.noConflict();
    (function ($) {
        $(document).ready(function () {
            $('.flexslider').flexslider({
                animation: "slide"
            });
        });
    })(jQuery);

    $(document).ready(function () {
        function updateCsrfToken(csrfName, csrfHash) {
            $('input[name="' + csrfName + '"]').val(csrfHash);
        }

        $('.add-to-cart').on('click', function (e) {
            e.preventDefault();

            var productId = $(this).data('id');
            var quantity = $('#quantity').val();

            if (!productId) {
                alert('Error: Product ID is missing.');
                return;
            }

            var csrfName = '<?= csrf_token() ?>'; 
            var csrfHash = $('input[name="' + csrfName + '"]').val();

            $.ajax({
                url: '<?= base_url('cart/add') ?>/' + productId,
                type: 'POST',
                data: { product_id: productId, qty: quantity, [csrfName]: csrfHash },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $('.total-count').text(response.totalItems);
                        updateCartContent();
                        $('#cartModal').modal('show');
                    } else {
                        alert(response.message);
                    }

                    updateCsrfToken(response.csrfName, response.csrfHash);
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while adding to cart.');
                }
            });
        });

        function updateCartContent() {
            $.ajax({
                url: '<?= base_url("/cart/info") ?>',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('#cart-content').html(response.cartItems);
                    $('.total-count').text(response.totalItems);
                    $('.total-amount').text('$' + response.totalAmount);
                },
                error: function () {
                    alert('Failed to update cart.');
                }
            });
        }

        // Update cart quantity
        function updateCartQuantity(rowid, qty) {
            console.log('Sending update request. Row ID:', rowid, 'Quantity:', qty);

            // Retrieve CSRF token values
            var csrfName = '<?= csrf_token() ?>'; // CSRF Token Name
            var csrfHash = $('input[name="' + csrfName + '"]').val(); // CSRF Hash from hidden input

            $.ajax({
                url: '<?= base_url('cart/update') ?>',
                type: 'POST',
                data: { 
                    rowid: rowid, 
                    qty: qty, 
                    [csrfName]: csrfHash 
                },
                dataType: 'json',
                success: function (response) {
                    console.log('Update response:', response);
                    if (response.status === 'success') {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }

                    // Update CSRF token after each successful request
                    updateCsrfToken(response.csrfName, response.csrfHash);
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while updating the cart.');
                }
            });
        }

        // Increase and decrease quantity handlers
        $('#increase-qty').on('click', function () {
            var currentVal = parseInt($('#quantity').val());
            var newQty = currentVal + 1;
            $('#quantity').val(newQty);

            var productId = $('.add-to-cart').data('id');
            updateCartQuantity(productId, newQty);
        });

        $('#decrease-qty').on('click', function () {
            var currentVal = parseInt($('#quantity').val());
            if (currentVal > 1) {
                var newQty = currentVal - 1;
                $('#quantity').val(newQty);

                var productId = $('.add-to-cart').data('id');
                updateCartQuantity(productId, newQty);
            }
        });

        // Handle item removal from cart
        $(document).on('click', '.remove-item', function (e) {
            e.preventDefault();

            var rowid = $(this).data('id');

            // Retrieve CSRF token values
            var csrfName = '<?= csrf_token() ?>'; // CSRF Token Name
            var csrfHash = $('input[name="' + csrfName + '"]').val(); // CSRF Hash from hidden input

            $.ajax({
                url: '/cart/remove/' + rowid,
                method: 'POST',
                data: { [csrfName]: csrfHash },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr) {
                    alert('Error removing item from cart.');
                }
            });
        });
    });
</script>

    <?= $this->endSection() ?>

    <?= $this->endSection() ?>

</div>