
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
                                    <div class="inners">
                                        <!-- <h4 class="title">Mega sale up to <span>50%</span> off for all</h4> -->
                                        <h5 class="title">FAQs</h5>

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
                    <li class="breadcrumb-item active" aria-current="page">FAQs</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container mb-3 mt-3">
  
<?php if (empty($faqs)): ?>
            <div class="alert alert-warning" role="alert">
                No FAQs available. Please add some FAQs.
            </div>
        <?php else: ?>
            <div id="accordion">
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="mb-3">
                        <div class="" id="heading<?= $index ?>">
                            <h5 class="mb-0">
                                <button class="m-1 p-2" data-toggle="collapse" data-target="#collapse<?= $index ?>" aria-expanded="true" aria-controls="collapse<?= $index ?>">
                                    <?= esc($faq['name']) ?>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse<?= $index ?>" class="collapse" aria-labelledby="heading<?= $index ?>" data-parent="#accordion">
                            <div class="card-body">
                                <?= esc($faq['description']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-3 mb-3">
                <?= $pager->makeLinks($currentPage, $perPage, $totalFaqs, 'bootstrap_pagination') ?>
            </div>
        <?php endif; ?>
</div>

</div>


<?= $this->endSection() ?>




