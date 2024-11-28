<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="container mt-3 mb-3">
        <div class="container blogs">
    <h4 class="mb-3"><?= esc($blog['title']); ?></h4>

    <div class="row">
        <div class="col-md-12">
            <img class="img-fluid" src="<?= base_url($blog['image']); ?>" alt="Blog Image" style="float: left; margin-right: 15px;">
<p><?= nl2br(html_entity_decode(strip_tags($blog['description']))); ?></p>
            <a href="<?= base_url('/blogs'); ?>" class="btn btn-primary mt-3">Back to Blogs</a>
        </div>
    </div>
</div>
        <?= $this->endSection() ?>

    </div>