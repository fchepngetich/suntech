<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>

    <!-- app/Views/track_order_form.php -->

<div class="container mt-5 mb-5">
    <h6>Track Your Order</h6>
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('track-order') ?>" method="post">
        <div class="form-group">
            <label for="order_number">Please Enter Your Order Number</label>
            <input type="text" name="order_number" id="order_number" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Track Order</button>
    </form>
</div>



<?= $this->endSection() ?>