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
                <!-- Dynamically Loop through Categories/Subcategories -->
                <?php foreach ($categories as $category): ?>
                    <li><a href="<?= base_url('categories/category/' . $category['slug']); ?>"><?= $category['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- Shop by Price Widget -->
        <div class="single-widget range">
            <h3 class="title">Shop by Price</h3>
            <div class="price-filter">
                <!-- Add slider and price filters here -->
            </div>
        </div>
        <!-- Recent Posts -->
        <div class="single-widget recent-post">
            <h3 class="title">Recent Posts</h3>
            <div class="single-post">
                <div class="image">
                    <img src="path_to_recent_product_image" alt="#">
                </div>
                <div class="content">
                    <h5><a href="#">Recent Product Name</a></h5>
                    <p class="price">$99.50</p>
                </div>
            </div>
            <!-- Repeat for more posts -->
        </div>
    </div>
</div>


<div class="col-lg-9 col-md-8 col-12">
    <div class="row">
        <!-- Shop Top Controls -->
        <div class="col-12">
            <div class="shop mt-3 mb-3">
            <!-- <h4 class="title text-center"><?= esc($category['name']) ?></h4> -->

            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row">
    <?php if (!empty($products)):?>
        <?php foreach ($products as $product): ?>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="single-product">
                <div class="product-img">
                    <a href="<?= base_url('admin/products/details/' . $product['slug']); ?>">
                    <img class="default-img" src="<?= base_url(relativePath: '/backend/' . $product['image']) ?>">
                    </a>
                    <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3><a href="<?= base_url('admin/products/details/' . $product['slug']); ?>"><?= $product['name']; ?></a></h3>
                    <div class="product-price">
                        <span>$<?= $product['price']; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="col-12 text-center no-items">
            <p>No products found in this subcategory.</p>
        </div>
    <?php endif; ?>
    </div>
</div>
</div>


<?= $this->endSection() ?>

</div>