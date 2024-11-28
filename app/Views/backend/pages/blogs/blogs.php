<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="container mt-3 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blogs</li>
            </ol>
        </nav>
        <h5 class="capitalize mt-3 mb-3">Our Blogs</h5>
        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-lg-4 col-md-6 col-12 mt-3 mb-3">
                    <!-- Start Single Blog -->
                    <div class="shop-single-blog">
                        <img class="default-img" src="<?= base_url($blog['image']); ?>" alt="Blog Image">

                        <div class="content">

<h6 class="mt-1 mb-1">
    <?= esc(strlen($blog['title']) < 75 
        ? $blog['title'] 
        : substr($blog['title'], 0, 75) . '...'); ?>
</h6>

<p class="text">
    <?= esc(
        substr(
            strip_tags($blog['description']), 
            0, 
            100
        )
    ); ?>...
</p>

<a href="<?= base_url('/blogs/show/' . $blog['id']); ?>" class="btn more-btn">Continue Reading</a>

</div>
                    </div>
                    <!-- End Single Blog -->
                </div>
            <?php endforeach; ?>
        </div>

        <?= $this->endSection() ?>

    </div>