<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>

    <div class="container about-details mt-5 mb-5">
        <?php if ($item['image']): ?>
            <img src="<?= base_url('images/aboutus/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>" class="img-fluid">
        <?php endif; ?>
        <h5 class="mt-3 mb-3"><?= esc($item['name']) ?></h5>

        <p class="mb-1"><?= html_entity_decode($item['description']) ?></p>         <!-- Add any additional content or styles here -->
    </div>


<?= $this->endSection() ?>