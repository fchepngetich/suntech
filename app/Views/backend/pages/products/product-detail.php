<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php $currency = getenv('CURRENCY') ?? 'Ksh'; ?>

    <div class="container shop-single mb-5 mt-2">
<!-- breadcrumbs.php -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php foreach ($breadcrumbs as $key => $breadcrumb): ?>
            <?php if ($key === array_key_last($breadcrumbs)): ?>
                
                <li class="breadcrumb-item active last-breadcrumb" aria-current="page">
                    <?= esc($breadcrumb['name']); ?>
                </li>
            <?php else: ?>
                
                <li class="breadcrumb-item">
                    <a href="<?= esc($breadcrumb['url']); ?>"><?= esc($breadcrumb['name']); ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>


        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfToken">

        <div class="row gx-5">
            <aside class="col-lg-6">
           

                <!-- Product Slider -->
                <div class="product-gallery">
                    <!-- Images slider -->
                    <div class="flexslider-thumbnails">
                        <div class="flex-viewport" style="overflow: hidden; position: relative;">
                            <ul class="slides">
                                <!-- Main Product Image -->
                                <li class="text-center"
                                    data-thumb="<?= base_url('/backend/images/' . esc($product['image'])) ?>">
                                    <img src="<?= base_url('/backend/images/' . esc($product['image'])) ?>"
                                        alt="<?= esc($product['name']) ?>">
                                </li>

                                <!-- Additional Sideview Images -->
                                <?php
                                $sideviewImages = json_decode($product['sideview_images'], true);
                                if ($sideviewImages && is_array($sideviewImages)) {
                                    foreach ($sideviewImages as $image):
                                        ?>
                                        <li class="text-center" data-thumb="<?= base_url('/backend/images/' . esc($image)) ?>">
                                            <img src="<?= base_url('/backend/images/' . esc($image)) ?>"
                                                alt="<?= esc($product['name']) ?>">
                                        </li>
                                    <?php endforeach;
                                } ?>
                            </ul>
                        </div>

                        <!-- Thumbnails -->

                        <!-- Navigation Arrows -->
                        <ul class="flex-direction-nav">
                            <li><a class="flex-prev" href="#"></a></li>
                            <li><a class="flex-next" href="#"></a></li>
                        </ul>
                    </div>
                    <!-- End Images slider -->
                </div>
                <!-- End Product slider -->

            </aside>


            <main class="col-lg-6">
                <div class="ps-lg-3">
                    <h4 class="title text-dark"><?= esc($product['name']) ?></h4>
                    <div class="mb-3 mt-2">
                        <span class="h5"><?= esc($currency) ?> <?= number_format($product['price'], 2) ?></span>
                    </div>
                    <h6 class="capitalize p-2">Features</h6>
                    <div class="features-list">
            <?= htmlspecialchars_decode($product['features']);?>
        </div>
                    
                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-4 col-6 mb-3">
                            <label class="mb-2 d-block">Quantity</label>
                            <div class="input-group mb-3" style="width: 170px;">
                                <button class="btn btn-white border border-secondary px-3" type="button"
                                    id="decrease-qty" data-mdb-ripple-color="dark">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="number" class="form-control text-center border border-secondary"
                                 value="<?= isset($productInCart) && is_array($productInCart) ? $productInCart['qty'] : 1 ?>" 
                                 id="quantity" min="1" aria-label="Quantity" 
                                 data-product-id="<?= isset($productInCart) && is_array($productInCart) ? $productInCart['id'] : $product['id'] ?>" 
                                 data-rowid="<?= isset($productInCart) && is_array($productInCart) ? $productInCart['rowid'] : '' ?>">

                                <button class="btn btn-white border border-secondary px-3" type="button"
                                    id="increase-qty" data-mdb-ripple-color="dark">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="product-container">
                    <?php if (!$productInCart): ?>
                        <div class="cart-buttons">
                        <a title="Add to cart" class="btn-new btn-primary shadow-0 add-to-cart" data-id="<?= $product['id'] ?>"
                            href="#"><i class="me-1 fa fa-shopping-basket"></i>Add to cart</a>

                            <a title="Wishlist" class=" btn-new btn-primary add-to-wishlist" data-id="<?= $product['id'] ?>"
                                        href="javascript:void(0);">
                                        <i class="ti-heart"></i><span>Add to Wishlist</span>
                                    </a>
                                    </div>
                    <?php endif; ?>                

                    <?php if ($productInCart): ?>
                        <p>Item already in cart. You can update the quantity.</p>
                    <?php endif; ?>
                    </div>

                </div>
            </main>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="nav-main">
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description"
                                        role="tab" aria-selected="true">Description</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab"
                                        aria-selected="false">Reviews</a></li> -->
                            </ul>
                            <!--/ End Tab Nav -->
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <!-- Description Tab -->
                            <div class="tab-pane fade active show" id="description" role="tabpanel">
                                <div class="tab-single">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="single-des">
                                                <p>
                                                    <?= $product['description'] ?>
                                                </p>
                                            </div>

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include APPPATH . 'Views/backend/pages/js.php'; ?> 
    <?php include APPPATH . 'Views/backend/pages/modal/cart-modal.php'; ?> 

    <?= $this->endSection() ?>

</div>