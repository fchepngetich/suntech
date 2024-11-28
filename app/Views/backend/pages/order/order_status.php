<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php $currency = getenv('CURRENCY') ?? 'Ksh'; ?>


<div class="container">
    <h2>Order Status</h2>
    <p><strong>Order Number:</strong> <?= esc($order['order_number']) ?></p>
    <p><strong>Status:</strong> <?= esc($order['order_status']) ?></p>
    <p><strong>Payment Status:</strong> <?= esc($order['payment_status']) ?></p>
    <p><strong>Amount:</strong> <?= esc($currency) ?> <?= number_format($order['amount'], 2) ?></p>
    <p><strong>Order Date:</strong> <?= esc($order['created_at']) ?></p>
</div>

<?= $this->endSection() ?>