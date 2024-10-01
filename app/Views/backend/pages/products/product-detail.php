<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>

    <div class="container mb-5 mt-5">
    <div class="row gx-5">
        <aside class="col-lg-6">
            <div class="border rounded-4 mb-3 d-flex justify-content-center">
                <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="<?= base_url('/backend/' . $product['image']) ?>">
                    <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="<?= base_url('/backend/' . $product['image']) ?>" alt="<?= $product['name'] ?>">
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
                        <button class="btn btn-white border border-secondary px-3" type="button" id="decrease-qty" data-mdb-ripple-color="dark">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center border border-secondary" value="1" id="quantity" min="1" aria-label="Quantity">
                            <button class="btn btn-white border border-secondary px-3" type="button" id="increase-qty" data-mdb-ripple-color="dark">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-warning shadow-0"> Buy now </a>
                <a title="Add to cart" class="btn btn-primary shadow-0 add-to-cart" data-id="<?= $product['id'] ?>" href="#"><i class="me-1 fa fa-shopping-basket"></i>Add to cart</a>
                <a href="#" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i class="me-1 fa fa-heart fa-lg"></i> Add to Wishlist </a>
            </div>
        </main>
    </div>
</div>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function () {
    // Handle "Add to Cart" button click
    $('.add-to-cart').on('click', function (e) {
        e.preventDefault(); 

        var productId = $(this).data('id');
        var quantity = $('#quantity').val(); // Get the quantity from the input field

        if (!productId) {
            alert('Error: Product ID is missing.');
            return;
        }

        $.ajax({
            url: '<?= base_url('cart/add') ?>/' + productId, 
            type: 'POST',
            data: { product_id: productId, qty: quantity }, // Send quantity as well
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('.total-count').text(response.totalItems); // Update the cart count
                    alert('Success: ' + response.message); 
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred while adding to cart.');
            }
        });
    });

    // Function to update the cart quantity via AJAX
    function updateCartQuantity(rowid, qty) {
    console.log('Sending update request. Row ID:', rowid, 'Quantity:', qty);
    
    $.ajax({
        url: '<?= base_url('cart/update') ?>',  // Ensure this URL is correct
        type: 'POST',
        data: { rowid: rowid, qty: qty },
        dataType: 'json',  // Expecting a JSON response
        success: function (response) {
            console.log('Update response:', response);
            if (response.status === 'success') {
                alert(response.message);
                location.reload();
            } else {
                console.error('Error from server:', response.message);
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
            console.error('Response:', xhr.responseText);  // Log the full response text
            alert('An error occurred while updating the cart.');
        }
    });
}


    // Handle Plus button click (Increase quantity)
    $('#increase-qty').on('click', function () {
        var currentVal = parseInt($('#quantity').val());
        var newQty = currentVal + 1;
        $('#quantity').val(newQty);
        
        // Optionally, update cart immediately if the item is already in the cart
        var productId = $('.add-to-cart').data('id');
        updateCartQuantity(productId, newQty);
    });

    // Handle Minus button click (Decrease quantity)
    $('#decrease-qty').on('click', function () {
        var currentVal = parseInt($('#quantity').val());
        if (currentVal > 1) {
            var newQty = currentVal - 1;
            $('#quantity').val(newQty);

            // Optionally, update cart immediately if the item is already in the cart
            var productId = $('.add-to-cart').data('id');
            updateCartQuantity(productId, newQty);
        }
    });

    // Handle removing an item from the cart
    $(document).on('click', '.remove-item', function (e) {
        e.preventDefault();

        var rowid = $(this).data('id');

        $.ajax({
            url: '/cart/remove/' + rowid,
            method: 'POST',
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