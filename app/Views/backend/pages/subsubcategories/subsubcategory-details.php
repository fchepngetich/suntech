<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                <div class="shop-sidebar">
                    <!-- Category Widget -->
                    <div class="single-widget category">
                        <h3 class="title">Categories</h3>
                        <ul class="categor-list">
                            <!-- Dynamically Loop through Categories -->
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="<?= base_url('categories/category/' . $category['slug']); ?>">
                                        <?= $category['name']; ?>
                                    </a>

                                    <!-- Check for subcategories -->
                                    <?php if (!empty($category['subcategories'])): ?>
                                        <ul class="subcategory-list">
                                            <?php foreach ($category['subcategories'] as $subcategory): ?>
                                                <li>
                                                    <a href="<?= base_url('subcategories/subcategory/' . $subcategory['slug']); ?>">
                                                        <?= $subcategory['name']; ?>
                                                    </a>
                                                    
                                                    <!-- Check for subsubcategories -->
                                                    <?php if (!empty($subcategory['subsubcategories'])): ?>
                                                        <ul class="subsubcategory-list">
                                                            <?php foreach ($subcategory['subsubcategories'] as $subsubcategory): ?>
                                                                <li>
                                                                    <a href="<?= base_url('subsubcategories/details/' . $subsubcategory['slug']); ?>">
                                                                        <?= $subsubcategory['name']; ?>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop mt-3 mb-3">
                            <h4 class="title text-center"><?= esc($subsubcategory['name']) ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="<?= base_url('admin/products/details/' . $product['slug']); ?>">
                                            <img class="default-img" src="<?= base_url('backend/images/' . $product['image']); ?>" alt="<?= esc($product['name']); ?>">
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                                                <a title="Wishlist" href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a title="Add to cart" href="#">Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="<?= base_url('admin/products/details/' . $product['slug']); ?>"><?= esc($product['name']); ?></a></h3>
                                        <div class="product-price">
                                            <span>$<?= esc($product['price']); ?></span>
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

    <?= $this->endSection() ?>
</div>
