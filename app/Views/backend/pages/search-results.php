<h2 class="text-center mt-4">Search Results</h2>

<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php $currency = getenv('CURRENCY') ?? 'Ksh'; ?>
    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                <div class="shop-sidebar mt-5">
                    <div class="single-widget category">
                        <h3 class="title">Categories</h3>
                        <ul class="categor-list">
                            <?php foreach ($categories as $category): ?>
                                <li><a
                                        href="<?= base_url('categories/category/' . $category['slug']); ?>"><?= esc($category['name']); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="single-widget recent-post">
                        <h3 class="title">Recent Posts</h3>
                        <div class="single-post">
                            <div class="image">
                                <span>Or whatever you want on the sidebar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop mb-3">
                        <h4 class="title text-center">
                    <?php if (!empty($search) && !empty($category)): ?>
                        Search Results for "<?= esc($search); ?>"  <?= esc($categoryName); ?>
                    <?php elseif (!empty($search) && empty($category)): ?>
                        Search Results for "<?= esc($search); ?>" <!-- This line handles the case where only the search term is present -->
                    <?php elseif (!empty($category)): ?>
                        Search Results in "<?= esc($categoryName); ?>"
                    <?php else: ?>
                        Search Results
                    <?php endif; ?>
                </h4>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="row">
                    <?php if (empty($results)): ?>
                        <div class="col-12 text-center">
                            <p>No products found matching the search term.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($results as $product): ?>
                            <div class="col-lg-3 col-md-6 col-12 mb-4">
                                <div class="card">
                                    <a href="<?= base_url('products/details/' . $product['slug']); ?>" class="">
                                        <img class="card-img-top" src="<?= get_image_url($product['image']); ?>"
                                            alt="<?= esc($product['name']); ?>">
                                        <div class="card-body">
                                            <h6 class="card-title"><?= esc($product['name']); ?></h6>
                                            <span
                                                class="card-text"><?= esc($currency) . ' ' . esc($product['discounted_price']); ?><span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>
</div>
</div>