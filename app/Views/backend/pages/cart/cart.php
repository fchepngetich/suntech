<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php $currency = getenv('CURRENCY') ?? 'Ksh'; ?>

    <div class="shopping-cart section mb-5">
        <div class="container mb-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>



            <?php if (!empty($cart)): ?>
                <div class="cart-items">
                    <div class="row p-3 mb-1">
                        <?php $cartService = \Config\Services::cart(); ?>
                        <h6 class="total-count mr-auto">CART( <?= $cartService->totalItems() ?>)</h6>
                        <!-- Checkout button aligned to the right -->
                        <a href="<?= base_url('/checkout') ?>" class="btn-new ml-auto">Checkout Now</a>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <!-- Shopping Summary -->
                            <table class="table shopping-summery rounded shadow">
                                <thead>
                                    <tr class="main-hading">
                                        <th>PRODUCT</th>
                                        <th></th>
                                        <th class="text-center">PRICE</th>
                                        <th class="text-center">QUANTITY</th>
                                        <th class="text-center">TOTAL</th>
                                        <th class="text-center"></th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $item): ?>
                                        <tr>
                                            <td class="image" data-title="No">
                                                <img src="<?= base_url('public/backend/images/' . $item['options']['image']) ?>"
                                                    alt="<?= esc($item['name']) ?>">
                                            </td>
                                            <td class="product-des" data-title="Description">

                                                <p class="product-name"><a href="#"><?= esc($item['name']) ?></a></p>
                                            </td>
                                            <td class="price" data-title="Price">
                                                <span><?= esc($currency) ?>         <?= number_format($item['price'], 2) ?></span>
                                            </td>
                                            <td class="qty" data-title="Qty">
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number" <?= $item['qty'] <= 1 ? 'disabled' : '' ?> data-type="minus"
                                                            data-rowid="<?= esc($item['rowid']) ?>">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="quant[<?= esc($item['rowid']) ?>]"
                                                        class="input-number" data-min="1" data-max="100"
                                                        value="<?= esc($item['qty']) ?>">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-rowid="<?= esc($item['rowid']) ?>">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </td>
                                            <td class="total-amount" data-title="Total">
                                                <span><?= esc($currency) ?>         <?= number_format($item['subtotal'], 2) ?></span>
                                            </td>
                                            <td class="action" data-title="Remove">
                                                <a href="#" class="remove-item" data-id="<?= esc($item['rowid']) ?>"><i
                                                        title="Remove from Cart" class="ti-trash remove-icon"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>

                            </table>
                            <div class="button5 mb-2">
                                <a href="<?= base_url(relativePath: '/') ?>" class="btn-new">Continue shopping</a>
                                <span><a href="#" id="clear-cart" class="btn-new btn-info">Remove All</a>
                                </span>
                            </div>

                            <!--/ End Shopping Summary -->
                        </div>

                        <span class="ml-auto">
                            <h6 class="p-3"> <span>Total :<?= esc($currency) ?>     <?= number_format($total, 2) ?></span></h6>

                        </span>
                    </div>

                <?php else: ?>
                    <tr>
                        <div class="cart-empty">
                            <td colspan="6" class="text-center">
                                <h5 class="text-center">Your cart is empty!</h5>
                            </td>
                            <a class="btn" href="<?= base_url('/') ?>">Start Shopping</a>
                        </div>
                    </tr>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?= $this->section('scripts') ?>
    <script>
        $(document).on('click', '.remove-item', function (e) {
            e.preventDefault();

            var rowid = $(this).data('id');

            $.ajax({
                url: '<?= base_url('cart/remove/') ?>' + rowid,
                method: 'POST',
                success: function (response) {
                    location.reload();
                },
                error: function (xhr) {
                    alert('Error removing item from cart.');
                }
            });
        });
        $(document).ready(function () {


            $('#clear-cart').on('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('cart/clear') ?>',
                            type: 'POST',
                            dataType: 'json',
                            success: function (response) {
                                if (response.status === 'success') {
                                    $('.total-count').text(0);

                                    $('.shopping-summery tbody').html('<tr><td colspan="6" class="text-center"><p>Your cart is empty!</p></td></tr>');

                                    $('.total-amount').find('span').each(function () {
                                        $(this).text('$0.00');
                                    });


                                    //Swal.fire('Cleared!', 'Your cart has been cleared.', 'success');
                                    updateCartToEmpty();
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX error:', status, error);
                                Swal.fire('Error!', 'An error occurred while clearing the cart.', 'error');
                            }
                        });
                    }
                });
            });
        });

        function updateCartToEmpty() {
            var emptyCartHTML = `
        <div class="cart-empty text-center">
            <h5 class='p-3'>Your cart is empty!</h5>
            <a class="btn" href="<?= base_url('/') ?>">Start Shopping</a>
        </div>
    `;

            $('.cart-items').replaceWith(emptyCartHTML);
            $('.btn-new.ml-auto').hide();
        }



        $(document).ready(function () {
            function updateQuantity(rowid, qty) {
                $.ajax({
                    url: '<?= base_url('/cart/update') ?>',

                    method: 'POST',
                    data: { rowid: rowid, qty: qty },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error updating item quantity.');
                    }
                });
            }

            // Handle plus button click
            $(document).on('click', '.btn-number[data-type="plus"]', function () {
                var rowid = $(this).data('rowid');
                var input = $(this).closest('.input-group').find('.input-number');
                var currentVal = parseInt(input.val());
                var newQty = currentVal + 1;

                input.val(newQty);
                updateQuantity(rowid, newQty);
            });

            // Handle minus button click
            $(document).on('click', '.btn-number[data-type="minus"]', function () {
                var rowid = $(this).data('rowid');
                var input = $(this).closest('.input-group').find('.input-number');
                var currentVal = parseInt(input.val());

                if (currentVal > 1) {
                    var newQty = currentVal - 1;
                    input.val(newQty);
                    updateQuantity(rowid, newQty);
                }
            });
        });


    </script>
    <?= $this->endSection() ?>
    <?= $this->endSection() ?>