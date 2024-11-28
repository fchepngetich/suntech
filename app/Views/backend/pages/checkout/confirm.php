<div class="container mt-5 mb-5">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    
    <h6>Payment Confirmation</h6>

    <?php if (isset($paymentStatus['status'])): ?>
        <?php if ($paymentStatus['status'] === 'SUCCESS'): ?>
            <h6>Payment Successful!</h6>
            <p>Receipt Number: <?= esc($paymentStatus['receipt']) ?></p>
            <p>Amount: KES <?= number_format($paymentStatus['amount'], 2) ?></p>
            <!-- Provide a button to go to the orders view page -->
            <a href="/orders/view/<?= esc($checkoutRequestID) ?>" class="btn btn-success">View Order</a>
        <?php else: ?>
            <h6>Payment Failed</h6>
            <p>Error: <?= esc($paymentStatus['error']) ?></p>
            <!-- Optionally, provide a retry button or redirect option -->
            <a href="/checkout/retry" class="btn btn-danger">Retry Payment</a>
        <?php endif; ?>
    <?php else: ?>
        <h6>Error: Payment status not available</h6>
    <?php endif; ?>
    
    <?= $this->endSection() ?>
</div>
