<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php $currency = getenv('CURRENCY') ?? 'Ksh'; ?>
    <div class="container mt-3 mb-3">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb): ?>
            <li class="breadcrumb-item">
                <?php if (!empty($breadcrumb['url'])): ?>
                    <a href="<?= esc($breadcrumb['url']); ?>"><?= esc($breadcrumb['name']); ?></a>
                <?php else: ?>
                    <span><?= esc($breadcrumb['name']); ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>

        <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
            <?php include APPPATH . 'Views/backend/pages/sidebar.php'; ?>

            </div>

            <div class="col-lg-9 col-md-8 col-12">
                <h5 class="mb-3">Recommended Products</h5>

                <div class="row">
                    <?php foreach ($recommendedProducts as $product): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12 products">
                            <div class="single-product card">
                                <div class="product-img">
                                    <a href="<?= base_url('products/details/' . $product['slug']) ?>">
                                        <img class="default-img"
                                            src="<?= base_url(relativePath: '/backend/images/' . $product['image']) ?>"
                                            alt="#">
                                        <img class="hover-img"
                                            src="<?= base_url(relativePath: '/backend/images/' . $product['image']) ?>"
                                            alt="#">
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">

                                            <a title="Wishlist" class="add-to-wishlist" data-id="<?= $product['id'] ?>"
                                                href="#"><i class="ti-heart p-2"></i>
                                                <span>Add to Wishlist</span></a>

                                        </div>
                                        <div class="product-action-2">
                                            <a title="Add to cart" class="btn-sm btn-danger add-to-cart"
                                                data-id="<?= $product['id'] ?>" href="#">Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content p-2">
                                    <h3><a
                                            href="<?= base_url('products/details/' . $product['slug']) ?>"><?= esc($product['name']) ?></a>
                                    </h3>
                                    <div class="product-price">
                                        <span class="discounted-price"><?= esc($currency) ?>
                                            <?= number_format(floor($product['discounted_price']), 0, '.', ',') ?></span>
                                        <span class="original-price"><?= esc($currency) ?>
                                            <?= number_format(floor($product['price']), 0, '.', ',') ?></span>
                                    </div>
                                    <hr class="line">
                                </div>
                                <!-- <div class="product-action-2 mb-2 text-center">
                                    <a title="Add to cart" class="btn btn-danger add-to-cart"
                                        data-id="<?= esc($product['id']) ?>" href="#">Add to cart</a>
                                </div> -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include APPPATH . 'Views/backend/pages/js.php'; ?>
    <?php include APPPATH . 'Views/backend/pages/modal/cart-modal.php'; ?>


    <?= $this->endSection() ?>
</div>