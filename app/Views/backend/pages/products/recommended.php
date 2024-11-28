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

                <div class="row ">
                    <?php if (!empty($recommendedProducts)): ?>
                        <?php foreach ($recommendedProducts as $product): ?>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card mb-4">
                                    <div class="row no-gutters">
                                        <!-- Product Image -->
                                        <div class="col-12 col-sm-4">
                                            <a href="<?= base_url('products/details/' . $product['slug']); ?>">
                                                <img src="<?= get_image_url($product['image']); ?>" class="card-img"
                                                    alt="<?= $product['name']; ?>">
                                            </a>
                                        </div>

                                        <!-- Product Info -->
                                        <div class="col-12 col-sm-8">
                                            <div class="card-body">
                                                <h5 class="card-title product-title">
                                                    <a
                                                        href="<?= base_url('products/details/' . $product['slug']); ?>"><?= $product['name']; ?></a>
                                                </h5>
                                                <p class="mt-2 mb-2"><?= substr($product['description'], 0, 100); ?>...</p>



                                                <div class="product-price mb-2">
                                                    <strong>
                                                        <?= esc($currency) ?>
                                                        <?= number_format(
                                                            !empty($product['discounted_price']) && $product['discounted_price'] != 0
                                                            ? $product['discounted_price']
                                                            : $product['price'],
                                                            0,
                                                            '.',
                                                            ','
                                                        ); ?>
                                                    </strong>
                                                </div>


                                                <p class="text-danger mt-3 mb-3">Price is inclusive of
                                                    <strong><u>16%</u></strong> VAT</p>

                                                <!-- Action Buttons -->
                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn-primary btn-sm add-to-cart"
                                                        data-id="<?= $product['id'] ?>">Add to Cart <i
                                                            class="fa fa-shopping-cart"></i></button>
                                                    <button type="button" class="btn-outline-secondary btn-sm add-to-wishlist"
                                                        data-id="<?= $product['id'] ?>">Wishlist <i
                                                            class="fa fa-heart"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Manufacturer Info -->

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>No products found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include APPPATH . 'Views/backend/pages/js.php'; ?>
    <?php include APPPATH . 'Views/backend/pages/modal/cart-modal.php'; ?>


    <?= $this->endSection() ?>
</div>