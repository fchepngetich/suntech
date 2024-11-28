<div class="container">

    <?= $this->extend('backend/layout/pages-layout') ?>

    <?= $this->section('content') ?>

    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger">

            <?= session()->getFlashdata('error'); ?>

        </div>

    <?php endif; ?>



    <section class="hero-area3">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-7">
                    <div id="heroCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            <!-- Slide 1 -->
                            <div class="carousel-item active">
                                <div class="big-content">
                                    <img src="images/banners/SuntechSolutions-06.png" class="" alt="Slide 1">
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                            </div>
                            <!-- Slide 2 -->
                            <div class="carousel-item">
                                <div class="big-content">
                                    <img src="images/banners/SuntechSolutions-04.png" class="d-block w-100"
                                        alt="Slide 2">
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                            </div>
                            <!-- Slide 3 -->
                            <div class="carousel-item">
                                <div class="big-content">

                                    <img src="images/banners/SolarWaterheating.png" class="d-block w-100" alt="Slide 3">
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="big-content">

                                    <img src="images/banners/BF.png" class="d-block w-100" alt="Slide 4">
                                    <div class="carousel-caption">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carousel Controls -->
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

                                    <a href="<?= base_url('subsubcategories/details/hybrid-solar-inverters') ?>">
                                        <img src="images/banners/LiveBanners-01.png" class="" alt="Slide 1">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small-content secound">
                                <div class="inner">

                                    <a href="<?= base_url('subcategories/subcategory/solar-pump-inverters') ?>">

                                        <img src="images/banners/LiveBanners-02.png" class="" alt="Slide 1">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small-content third">
                                <div class="inner">
                                    <a href="<?= base_url('categories/category/water-heating-solution') ?>">

                                        <img src="images/banners/LiveBanners-03.png" class="" alt="Slide 1">
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small-content fourth">
                                <div class="inner">

                                    <a href="<?= base_url('categories/category/solar-pumps-solutions') ?>">

                                        <img src="images/banners/LiveBanners-04.png" class="" alt="Slide 1">
                                    </a>
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

            <p class="ml-5 btn btn-sm btn-info">UNBEATABLE PRICES(GUARANTEED)</p>

            <span class="ml-auto p-1"> <a class="btn btn-sm btn-info"
                    href="<?= base_url('products/recommended/') ?>">View All</a> </span>

        </div>

        <div class="row recommended-row">



            <?php foreach ($recommendedProducts as $product): ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-12 products">
                    <div class="single-product card">
                        <div class="product-img">
                            <a href="<?= base_url('products/details/' . $product['slug']) ?>">
                                <img class="default-img" src="<?= get_image_url($product['image']); ?>" alt="#">
                            </a>

                        </div>
                        <div class="product-content p-2">
                            <h3>
                                <?php
                                $name = strlen($product['name']) > 45 ? substr($product['name'], 0, 45) . '...' : str_pad($product['name'], 45);
                                $displayName = str_replace(' ', '&nbsp;', $name); // Replace spaces with non-breaking spaces
                                ?>

                                <a href="<?= base_url('products/details/' . $product['slug']) ?>">
                                    <?= $displayName ?>
                                </a>



                            </h3>
                            <div class="product-price">
                                <?php if (!empty($product['discounted_price']) && $product['discounted_price'] != 0): ?>
                                    <span class="discounted-price">
                                        <?= esc($currency) ?>
                                        <?= number_format(floor($product['discounted_price']), 0, '.', ',') ?>
                                    </span>
                                    <span class="original-price" style="text-decoration: line-through;">
                                        <?= esc($currency) ?>
                                        <?= number_format(floor($product['price']), 0, '.', ',') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="original-prices">
                                        <?= esc($currency) ?>
                                        <?= number_format(floor($product['price']), 0, '.', ',') ?>
                                    </span>
                                <?php endif; ?>
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



                    <img src="images/banners/Sustainability-banner-01.png" alt="#">

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

            <span class="ml-auto"> <a class="btn btn-sm btn-info" href="<?= base_url('products/top-deals/') ?>">View
                    All</a> </span>

        </div>

        <div class="row recommended-row">

            <?php foreach ($topDeals as $product): ?>

                <div class="col-xl-2 col-lg-3 col-md-4 col-12 products topdeals">

                    <div class="single-product card">

                        <div class="product-img">

                            <a href="<?= base_url('products/details/' . $product['slug']) ?>">

                                <img class="default-img" src="<?= base_url('/backend/images/' . $product['image']) ?>"
                                    alt="#">


                            </a>



                        </div>

                        <div class="product-content p-2">

                            <h3>
                                <?php
                                $name = strlen($product['name']) > 45 ? substr($product['name'], 0, 45) . '...' : str_pad($product['name'], 45);
                                $displayName = str_replace(' ', '&nbsp;', $name); // Replace spaces with non-breaking spaces
                                ?>

                                <a href="<?= base_url('products/details/' . $product['slug']) ?>">
                                    <?= $displayName ?>
                                </a>



                            </h3>

                            <div class="product-price">
                                <?php if (!empty($product['discounted_price']) && $product['discounted_price'] != 0): ?>
                                    <span class="discounted-price">
                                        <?= esc($currency) ?>
                                        <?= number_format(floor($product['discounted_price']), 0, '.', ',') ?>
                                    </span>
                                    <span class="original-price" style="text-decoration: line-through;">
                                        <?= esc($currency) ?>
                                        <?= number_format(floor($product['price']), 0, '.', ',') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="original-prices">
                                        <?= esc($currency) ?>
                                        <?= number_format(floor($product['price']), 0, '.', ',') ?>
                                    </span>
                                <?php endif; ?>
                            </div>



                            <hr class="line">



                        </div>



                    </div>

                </div>

            <?php endforeach; ?>

        </div>



    </div>

</section>


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

                        <img class="default-img" src="<?= base_url('' . $blog['image']); ?>" alt="Blog Image">



                        <div class="content">

                            <h6 class="mt-1 mb-1">
                                <?= esc(strlen($blog['title']) < 75
                                    ? $blog['title']
                                    : substr($blog['title'], 0, 75) . '...'); ?>
                            </h6>

                            <p class="text">
                                <?= html_entity_decode(substr(strip_tags($blog['description']), 0, 100)); ?>...
                            </p>
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