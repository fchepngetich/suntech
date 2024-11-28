<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>
<div class="about-us">

    <section class="hero-area3">
        <div class="containers">
            <div class="row">
                <div class="col-md-12">
                    <div id="heroCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="big-content">
                                    <div class="inner">
                                       

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
    </section>
    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Our Impact</li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="introduction">
        <div class="container mt-3 mb-1">
            <div class="row">
                <div class="content">
                    <h6 class="title mb-2 pl-3"> Suntech Power - Improving Lives</h6>
                    <p class="pl-3">
                        Suntech Power products are more than just a solar product; they are use as catalysts for change.
                        Our mission is to empower communities by reducing reliance on expensive electricity and
                        enhancing quality
                        of life through innovative solar solutions. From solar-powered water pumps that revolutionize
                        irrigation
                        for farmers to sustainable energy solutions that light up rural schools, we are committed to
                        making a
                        difference.

                    </p>
                    <p class="pl-3 mt-1">
                        We support pastoralist communities with reliable solar pumping systems for livestock, ensuring
                        access
                        to vital water sources. Our integration of solar technology into food processing—like cold
                        storage and
                        meat drying—preserves quality and boosts agricultural value. By providing solar water heating
                        solutions
                        for homes and businesses, we help lower living costs and promote sustainability. Together, we
                        are
                        building a brighter future, one solar panel at a time.
                    </p>
                </div>


            </div>
        </div>
</div>
</section>

<!-- Start Shop Blog  -->
<section class="shop-blog sections">
    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <div class="section-titles mb-3 mt-3">
                    <h6>Improving Lives Projects</h6>
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
                                <?= esc(substr($blog['title'], 0, 40)); ?>     <?= strlen($blog['title']) > 40 ? '...' : ''; ?>
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

        <!-- Pagination links -->
        <div class="row">
            <div class="col-12">
                <?= $pager->makeLinks($currentPage, $perPage, $totalBlogs, 'bootstrap_pagination') ?>
            </div>
        </div>
    </div>
</section>
</div>


<?= $this->endSection() ?>