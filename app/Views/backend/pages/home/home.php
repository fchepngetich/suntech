<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

    <section class="hero-area3">
        <div class="containers">
            <div class="row">
                <div class="col-md-7">
                    <div id="heroCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="big-content">
                                    <div class="inner">
                                        <!-- <h4 class="title">Mega sale up to <span>50%</span> off for all</h4> -->
                                        <p class="des">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                            Mollitia iste
                                            laborum deleniti nam in quos qui nemo ipsum numquam.</p>
                                        <div class="button">
                                            <a href="#" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="big-content">
                                    <div class="inner">
                                        <!-- <h4 class="title">Limited Time Offer <span>30%</span> off selected items</h4> -->
                                        <p class="des">Discover our new collection and enjoy exclusive discounts.</p>
                                        <div class="button">
                                            <a href="#" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="big-content">
                                    <div class="inner">
                                        <!-- <h4 class="title">New Arrivals! <span>20%</span> off</h4> -->
                                        <p class="des">Explore our latest arrivals and get the best deals!</p>
                                        <div class="button">
                                            <a href="#" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small-content first">
                                <div class="inner">
                                    <!-- <h4 class="title">Awesome Bag <br> 2020</h4> -->
                                    <div class="button">
                                        <a href="#" class="btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small-content secound">
                                <div class="inner">
                                    <!-- <h4 class="title">Awesome Bag <br> 2020</h4> -->
                                    <div class="button">
                                        <a href="#" class="btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small-content third">
                                <div class="inner">
                                    <!-- <h4 class="title">Summer travel <br> collection</h4> -->
                                    <div class="button">
                                        <a href="#" class="btn">Discover Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small-content fourth">
                                <div class="inner">
                                    <!-- <h4 class="title">Summer travel <br> collection</h4> -->
                                    <div class="button">
                                        <a href="#" class="btn">Discover Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>


    <section class="introduction">
        <div class="container mt-3 mb-1">
            <div class="row">
                <div class="content p-3 d-flex flex-column align-items-center text-center">
                    <h4 class="title mb-2">Solar Power Equipment Supplier In Kenya</h4>
                    <p class="des">
                        Suntech Power Limited is a supplier of solar power and lighting solutions in Kenya. Registered
                        by Energy and Petroleum Regulatory Authority (EPRA), Suntech Power supplies and installs high
                        quality solar and energy-related equipment in Kenya and the East African region. We supply,
                        install and maintain solar water heating systems, solar inverters, solar batteries, solar power
                        systems, solar pumping solutions, backup systems, and solar installation accessories. Suntech
                        has a team of qualified solar experts including engineers, solar technicians and installers who
                        are licensed by EPRA.
                    </p>
                </div>


            </div>
        </div>
</div>
</section>
<!-- Start Recommended -->


<section class="recommended">
    <div class="container mt-5 mb-5">
        <div class="row row-title mb-3">
            <h4 class="title">Recommended For You</h4>
            <p class="ml-5 btn btn-sm btn-info">UNBEATABLE PRICES(QUARANTEED)</p>
            <span class="ml-auto p-1"> <a class="btn btn-sm btn-info" 
            href="<?= base_url('products/recommended/')?>">View All</a> </span>
        </div>
        <div class="row recommended-row">

            <?php foreach ($recommendedProducts as $product): ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-12 products">
                    <div class="single-product card">
                        <div class="product-img">
                            <a href="<?= base_url('products/details/' . $product['slug']) ?>">
                                <img class="default-img"
                                    src="<?= base_url(relativePath: '/backend/images/' . $product['image']) ?>" alt="#">
                                <img class="hover-img"
                                    src="<?= base_url(relativePath: '/backend/images/' . $product['image']) ?>" alt="#">
                            </a>
                            <!-- <div class="button-head">
                                <div class="product-action">
                                    <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i
                                            class="ti-eye"></i><span>Quick Shop</span></a>
                                    <a title="Wishlist" class="add-to-wishlist" data-id="<?= $product['id'] ?>"
                                        href="javascript:void(0);">
                                        <i class="ti-heart"></i><span>Add to Wishlist</span>
                                    </a>
                                </div>
                                <div class="product-action-2">
                                    <a title="Add to cart" class="btn-sm btn-danger add-to-cart"
                                        data-id="<?= $product['id'] ?>" href="#">Add to cart</a>
                                </div>

                            </div> -->
                        </div>
                        <div class="product-content p-2">
                            <h3><a
                                    href="<?= base_url('products/details/' . $product['slug']) ?>"><?= $product['name'] ?></a>
                            </h3>
                            <div class="product-price">
                            <span class="discounted-price"><?= esc($currency) ?> <?= number_format(floor($product['discounted_price']), 0, '.', ',') ?></span>
                            <span class="original-price"><?= esc($currency) ?> <?= number_format(floor($product['price']), 0, '.', ',') ?></span>


                            </div>
                            <hr class="line">

                        </div>
                        <div class="product-action-2 mb-2 text-center">
                            <a title="Add to cart" class="btn btn-danger add-to-cart" data-id="<?= $product['id'] ?>"
                                href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End Reccommended -->


<!-- Start Sustainability  -->

<div class="section-inner mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="image">

                    <img src="backend/images/sustainability-banner.png" alt="#">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Sustainability  -->

<!-- Top Deals  -->


<section>
    <div class="container mt-5 mb-4">
        <div class="row row-title">
            <h4 class="title">Top Deals Of The Month</h4>
            <span class="ml-auto"> <a class="btn btn-sm btn-info" href="<?= base_url('products/top-deals/')?>">View All</a> </span>
        </div>
        <div class="row recommended-row">
            <?php foreach ($topDeals as $product): ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-12 products">
                    <div class="single-product card">
                        <div class="product-img">
                        <a href="<?= base_url('products/details/' . $product['slug']) ?>">
                                <img class="default-img"
                                    src="<?= base_url(relativePath: '/backend/images/' . $product['image']) ?>" alt="#">
                                <img class="hover-img" src="<?= base_url(relativePath: '/backend/images/' . $product['image']) ?>"
                                    alt="#">
                            </a>


                            <div class="button-heaad">
                                <!-- <div class="product-action">
                                    
                                    <a title="Wishlist" class="add-to-wishlist" data-id="<?= $product['id'] ?>" href="#"><i
                                            class="ti-heart"></i><span>Add to Wishlist</span></a>
                                </div>
                                <div class="product-action-2">
                                    <a title="Add to cart" class="btn-sm btn-danger add-to-cart"
                                        data-id="<?= $product['id'] ?>" href="#">Add to cart</a>
                                </div> -->
                            </div>
                        </div>
                        <div class="product-content p-2">
                            <h3><a
                                    href="<?= base_url('products/details/' . $product['slug']) ?>"><?= $product['name'] ?></a>
                            </h3>
                            <div class="product-price">
                            <span class="discounted-price"><?= esc($currency) ?> <?= number_format(floor($product['discounted_price']), 0, '.', ',') ?></span>
                            <span class="original-price"><?= esc($currency) ?> <?= number_format(floor($product['price']), 0, '.', ',') ?></span>

                            </div>
                            <hr class="line">

                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>




<!-- end Top Deals  -->



<!-- Start Shop Blog  -->
<section class="shop-blog sections">
    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <div class="section-titles mb-3 mt-3">
                    <h4>Latest Insights</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Blog -->
                    <div class="shop-single-blog">
                        <img class="default-img" src="<?= base_url($blog['image']); ?>" alt="Blog Image">

                        <div class="content">
                            <h6 class="mt-1 mb-1">
                                <?= esc(substr($blog['title'], 0, 40)); ?>    <?= strlen($blog['title']) > 40 ? '...' : ''; ?>
                            </h6>
                            <p class="text"><?= esc(substr($blog['description'], 0, 100)); ?>...</p>
                            <a href="<?= base_url('/blogs/show/' . $blog['id']); ?>" class="btn more-btn">Continue
                                Reading</a>
                        </div>
                    </div>
                    <!-- End Single Blog -->
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<!-- End Shop Blog  -->

<?php include APPPATH . 'Views/backend/pages/js.php'; ?> 
<?php include APPPATH . 'Views/backend/pages/modal/cart-modal.php'; ?> 


<?= $this->endSection() ?>