<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php $currency = getenv('CURRENCY') ?? 'Ksh'; ?>

    <div class="container mt-3 mb-3">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $key => $breadcrumb): ?>
                    <li class="breadcrumb-item<?= $key === count($breadcrumbs) - 1 ? ' active' : ''; ?>">
                        <?php if ($key === count($breadcrumbs) - 1): ?>
                            <span><?= esc($breadcrumb['name']); ?></span>
                        <?php else: ?>
                            <a href="<?= esc($breadcrumb['url']); ?>"><?= esc($breadcrumb['name']); ?></a>
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
                <div class="row">
                    <div class="col-12">
                        <div class="shop mb-3">
                            <h4 class="title"><?= esc($subsubcategory['name']) ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="single-product card">
                                    <div class="product-img">
                                        <a href="<?= base_url('products/details/' . $product['slug']); ?>">
                                            <img class="default-img"
                                                src="<?= base_url('backend/images/' . $product['image']); ?>"
                                                alt="<?= esc($product['name']); ?>">
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
                                                href="<?= base_url('products/details/' . $product['slug']); ?>"><?= esc($product['name']); ?></a>
                                        </h3>
                                        <div class="product-price">
                                            <span><?= esc($currency) ?>
                                                <?= number_format($product['price'], 0, '.', ','); ?></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center no-items">
                            <p>No products found in this subsubcategory.</p>
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