
<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <div class="shopping-cart section"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Shopping Summary -->
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-hading">
                            <th>PRODUCT</th>
                            <th>NAME</th>
                            <th class="text-center">UNIT PRICE</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center">TOTAL</th> 
                            <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cart)) : ?>
                            <?php foreach ($cart as $item) : ?>
                                <tr>
                                    <td class="image" data-title="No">
                                        <img src="<?= base_url('writable/uploads/' . $item['options']['image']) ?>" alt="<?= esc($item['name']) ?>">
                                    </td>
                                    <td class="product-des" data-title="Description">
                                        <p class="product-name"><a href="#"><?= esc($item['name']) ?></a></p>
                                        <p class="product-des">Description of the product goes here.</p>
                                    </td>
                                    <td class="price" data-title="Price"><span>$<?= number_format($item['price'], 2) ?></span></td>
                                    <td class="qty" data-title="Qty">
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number" <?= $item['qty'] <= 1 ? 'disabled' : '' ?> data-type="minus" data-field="quant[<?= esc($item['rowid']) ?>]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="quant[<?= esc($item['rowid']) ?>]" class="input-number" data-min="1" data-max="100" value="<?= esc($item['qty']) ?>">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[<?= esc($item['rowid']) ?>]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total-amount" data-title="Total"><span>$<?= number_format($item['subtotal'], 2) ?></span></td>
                                    <td class="action" data-title="Remove">
                                        <a href="#" class="remove-item" data-id="<?= esc($item['rowid']) ?>"><i class="ti-trash remove-icon"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center"><p>Your cart is empty!</p></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!--/ End Shopping Summary -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Total Amount -->
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12">
                            <div class="left">
                                <div class="coupon">
                                    <form action="#" method="post" target="_blank">
                                        <input name="Coupon" placeholder="Enter Your Coupon">
                                        <button class="btn">Apply</button>
                                    </form>
                                </div>
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"> Shipping (+$10)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <ul>
                                    <li>Cart Subtotal<span>$<?= number_format($total, 2) ?></span></li>
                                    <li>Shipping<span>Free</span></li>
                                    <li>You Save<span>$20.00</span></li>
                                    <li class="last">You Pay<span>$<?= number_format($total, 2) ?></span></li>
                                </ul>
                                <div class="button5">
                                    <a href="<?= base_url('/checkout') ?>" class="btn">Checkout</a>
                                    <a href="<?= base_url('/') ?>" class="btn">Continue shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total Amount -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>

