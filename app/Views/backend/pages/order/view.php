<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>

<div class="container">
    <h2>Order Details</h2>

    <p>Order ID: <?= esc($order['id']) ?></p>
    <p>Checkout Request ID: <?= esc($order['checkout_request_id']) ?></p>
    <p>Status: <?= esc($order['status']) ?></p>
    <p>Amount: KES <?= number_format($order['amount'], 2) ?></p>
    <p>Receipt Number: <?= esc($order['receipt_number']) ?></p>
    <!-- Add more order details as needed -->
</div>
