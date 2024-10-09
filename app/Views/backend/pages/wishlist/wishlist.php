<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="wishlist section">
        <div class="container">
            <h5 class="text-center">My Wishlist</h5>
            <div class="row mt-2">

                <div class="col-12">
                    <!-- Wishlist Summary -->
                    <table class="table wishlist-summery">
                        <thead>
                            <tr class="main-hading">
                                <th>PRODUCT</th>
                                <th>NAME</th>
                                <th>UNIT PRICE</th>
                                <th>REMOVE</th>
                                <th>ADD TO CART</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($wishlistProducts)): ?>
                                <?php foreach ($wishlistProducts as $item): ?>
                                    <tr>
                                        <td class="image" data-title="No">
                                            <img src="<?= base_url('/backend/images/' . $item['image']) ?>"
                                                alt="<?= esc($item['name']) ?>">
                                        </td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a href="#"><?= esc($item['name']) ?></a></p>
                                            <p class="product-des">Description of the product goes here.</p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <span>$<?= number_format($item['price'], 2) ?></span>
                                        </td>
                                        <td class="action" data-title="Remove">
                                            <a href="#" class="remove-item" data-id="<?= esc($item['id']) ?>"><i
                                                    class="ti-trash remove-icon"></i></a>
                                        </td>
                                        <td class="action" data-title="Add to Cart">
                                            <a href="#" class="add-to-cart" data-id="<?= esc($item['id']) ?>"><i
                                                    class="ti-shopping-cart"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p>Your wishlist is empty!</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <!--/ End Wishlist Summary -->
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
(function($) {
    $(document).ready(function() {
        $('.flexslider').flexslider({
            animation: "slide"
        });
    });
})(jQuery);
    $(document).ready(function () {
        $(document).on('click', '.remove-item', function (e) {
    e.preventDefault();

    var productId = $(this).data('id');

    // SweetAlert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('products/wishlist/remove') ?>/' + productId,
                method: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Remove the row from the wishlist
                        $(this).closest('tr').remove();
                        // Show success toast notification
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }.bind(this), // Bind 'this' for use inside the success function
                error: function (xhr, status, error) {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
    });
});

        // Similar setup can be done for adding to cart
        $(document).on('click', '.add-to-cart', function (e) {
            e.preventDefault();

            var productId = $(this).data('id');

            $.ajax({
                url: '<?= base_url('cart/add') ?>/' + productId,
                method: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Show success toast notification
                        $('.total-count').text(response.totalItems);

                        toastr.success(response.message);

                    } else {
                        // Show error toast notification
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

    <?= $this->endSection() ?>
</div>