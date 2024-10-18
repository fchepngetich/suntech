

$(document).ready(function () {

    // Update CSRF Token Function
    function updateCsrfToken(csrfName, csrfHash) {
        $('input[name="' + csrfName + '"]').val(csrfHash);
    }

    // Add to Cart Event
    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();

        var productId = $(this).data('id');
        var quantity = $('#quantity').val();

        if (!productId) {
            alert('Error: Product ID is missing.');
            return;
        }

        $.ajax({
            url: baseUrl + '/cart/add/' + productId,
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

    // Update Cart Content
    function updateCartContent() {
        $.ajax({
            url: baseUrl + '/cart/info',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#cart-content').html(response.cartItems);
                $('.total-count').text(response.totalItems);
                $('.total-amount').text(csrfHash + response.totalAmount);
            },
            error: function () {
                alert('Failed to update cart.');
            }
        });
    }

    // Update Cart Quantity
    function updateCartQuantity(rowid, qty) {
        $.ajax({
            url: baseUrl + '/cart/update',
            type: 'POST',
            data: {
                rowid: rowid,
                qty: qty,
                [csrfName]: csrfHash
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
                updateCsrfToken(response.csrfName, response.csrfHash);
            },
            error: function (xhr, status, error) {
                alert('An error occurred while updating the cart.');
            }
        });
    }

    // Increase/Decrease Quantity Handlers
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

    // Remove Item from Cart
    $(document).on('click', '.remove-item', function (e) {
        e.preventDefault();

        var rowid = $(this).data('id');

        $.ajax({
            url: baseUrl + '/cart/remove/' + rowid,
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

    // Add to Wishlist
    $('.add-to-wishlist').on('click', function (e) {
        e.preventDefault();

        var productId = $(this).data('id');

        $.ajax({
            url: baseUrl + '/admin/products/wishlist/add',
            type: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
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
