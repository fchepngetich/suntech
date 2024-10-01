<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>

<section>
    <div class="container mt-5 mb-5">
        <h4 class="title">Your Wishlist</h4>
        <div class="row">
            <?php foreach ($wishlistProducts as $product): ?>
                <div class="col-md-3">
                    <div class="product-item">
                        <img src="<?= base_url('writable/uploads/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>">
                        <h5><?= esc($product['name']) ?></h5>
                        <span>$<?= number_format($product['price'], 2) ?></span>
                        <a href="#" class="remove-from-wishlist" data-id="<?= $product['id'] ?>">Remove</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
$(document).on('click', '.remove-from-wishlist', function (e) {
    e.preventDefault();

    var productId = $(this).data('id');

    $.ajax({
        url: '/wishlist/remove/' + productId,
        method: 'POST',
        success: function (response) {
            var res = JSON.parse(response);
            alert(res.message);
            location.reload(); // Refresh the page to see updated wishlist
        },
        error: function (xhr) {
            alert('Error removing from wishlist.');
        }
    });
});
</script>
<?= $this->endSection() ?>