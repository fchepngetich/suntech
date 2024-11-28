<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="container mt-3 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Success</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12">
            <p>Your order has been placed successfully. Please confirm your payment.</p>
         
            </div>
        </div>
        </div>

        <?= $this->endSection() ?>

    </div>