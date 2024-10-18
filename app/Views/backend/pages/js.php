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

            $(document).ready(function() {
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
            data: {
                product_id: productId,
                qty: quantity,
                [csrfName]: csrfHash
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    
                    $('.total-count').text(response.totalItems);
                    updateCartContent();
                   
                    $('#cartModal').modal('show');

                var productContainer = $('.add-to-cart[data-id="' + productId + '"]').closest('.product-container');
                productContainer.find('.cart-buttons').replaceWith('<p>Item already in cart. You can update the quantity.</p>');
                } else {
                    alert(response.message);
                }

                // Update CSRF token to prevent token mismatch
                updateCsrfToken(response.csrfName, response.csrfHash);
            },
            error: function (xhr, status, error) {
                alert('An error occurred while adding to cart.');
            }
        });
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
                        $('.total-amount').text('Ksh ' + response.totalAmount);
                    },
                    error: function () {
                        alert('Failed to update cart.');
                    }
                });
            }

            function updateCartQuantity(rowId, newQty) {
                $.ajax({
                    url: '<?= base_url('cart/update') ?>', 
                    type: 'POST',
                    data: {
                        rowid: rowId,
                        qty: newQty
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            console.log('Cart updated:', response.message);
                            updateCartContent();
                        } else {
                            console.log('Error:', response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Error updating cart:', error);
                    }
                });
            }

            let quantityInput = $('#quantity');
            let rowId = quantityInput.data('rowid'); 

            $('#increase-qty').click(function () {
                let currentQty = parseInt(quantityInput.val());
                quantityInput.val(currentQty + 1);
                updateCartQuantity(rowId, currentQty + 1);
            });

            $('#decrease-qty').click(function () {
                let currentQty = parseInt(quantityInput.val());
                if (currentQty > 1) {
                    quantityInput.val(currentQty - 1);
                    updateCartQuantity(rowId, currentQty - 1);
                }
            });

            $(document).on('click', '.remove-item', function (e) {
                e.preventDefault();

                var rowid = $(this).data('id');

                var csrfName = '<?= csrf_token() ?>'; 
                var csrfHash = $('input[name="' + csrfName + '"]').val(); 

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
        $(document).ready(function () {
            $('.add-to-wishlist').on('click', function (e) {
                e.preventDefault();

                var productId = $(this).data('id');

                $.ajax({
                    url: '<?= base_url('products/wishlist/add') ?>',
                    type: 'POST',
                    data: { product_id: productId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 'success') {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

    <?= $this->endSection() ?>