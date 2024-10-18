<?php   $currency = getenv('CURRENCY') ?? 'Ksh';?>
<div class="shopping-items">
                    <div class="dropdown-cart-header">
                        <?php $cart = \Config\Services::cart(); ?>
                        <h5 class="modal-title" id="cartModalLabel">
                            <span class="pl-4"><?= $cart->totalItems() ?> Items in the cart</span>
                        </h5>
                        <hr>
                    </div>
                    <ul class="shopping-lists">
                        <?php if ($cart->contents()): ?>
                            <?php foreach ($cart->contents() as $item): ?>
                                <li>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a class="cart-img" href="#">
                                                <img src="<?= base_url('/backend/images/' . $item['options']['image']) ?>"
                                                    alt="<?= esc($item['name']) ?>">
                                            </a>
                                        </div>
                                        <div class="col-md-5">
                                            <div>
                                                <h4><a href="#"><?= esc($item['name']) ?></a></h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div>
                                                <h4>
                                                    <a href="#"><?= esc($currency) ?><?= esc($item['price']) ?></a>
                                                    <!-- Display quantity here -->
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div>
                                                <p>
                                                    <span class="quantitys">X<?= esc($item['qty']) ?></span>
                                                    <!-- Display quantity here -->
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li style="text-align: center;">
                                <p>Your cart is empty!</p>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="bottom">
                        <div>
                            <span><?= $cart->totalItems() ?> Item(s) in the cart</span>
                        </div>
                        <div class="total">
                            <span>Total</span>
                            <span class="total-amount"><?= esc($currency) ?><?= number_format($cart->total(), 2) ?></span>
                        </div>

                    </div>
                    <div class="bottom">
                        <div class="checkout-continue">
                            <a href="<?= base_url('/checkout') ?>" class=" btn checkout-btn">Checkout</a>
                            <a href="<?= base_url('/') ?>" class="btn continue-shopping-btn">Continue Shopping</a>
                        </div>
                    </div>
                </div>