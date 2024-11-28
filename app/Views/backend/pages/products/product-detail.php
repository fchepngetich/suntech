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

        <?php if (session()->get('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->get('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

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
                                <li class="text-center" data-thumb="<?= get_image_url($product['image']); ?>">
                                    <img src="<?= get_image_url($product['image']); ?>"
                                        alt="<?= esc($product['name']) ?>">
                                </li>

                                <!-- Additional Sideview Images -->
                                <?php
                                $sideviewImages = json_decode($product['sideview_images'], true);
                                if ($sideviewImages && is_array($sideviewImages)) {
                                    foreach ($sideviewImages as $image):
                                        ?>
                                        <li class="text-center" data-thumb="<?= get_image_url(esc($image)); ?>">
                                            <img src="<?= get_image_url(esc($image)); ?>" alt="<?= esc($product['name']); ?>">
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
                    <h4 class="title product-title mb-2"><?= esc($product['name']) ?></h4>

                    <div class="features-list">
                        <?php
                        $shortDescription = substr($product['description'], 0, 300);
                        echo htmlspecialchars_decode($shortDescription) . (strlen($product['description']) > 300 ? '...' : '');
                        ?>
                    </div>

                    <?php if (strlen($product['description']) > 300): ?>
                        <div class="read-more-container mt-3">
                            <a href="#product-info" class="read-more">Read More</a>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="mb-3 mt-4 product-title">
                    <span class="h5">
                        <?= esc($currency) ?>
                        <?= number_format(
                            !empty($product['discounted_price']) && $product['discounted_price'] != 0
                            ? $product['discounted_price']
                            : $product['price'],
                            2
                        ) ?>
                    </span>
                </div>

                <p class="text-danger mt-3 mb-3">Price is inclusive of <strong><u>16%</u></strong> VAT</p>

                <hr>

                <div class="row">
                    <div class="col-md-4 col-6 mb-3">
                        <label class="mb-2 d-block">Quantity</label>
                        <div class="input-group mb-3" style="width: 170px;">
                            <button class="btn btn-white border border-secondary px-3" type="button" id="decrease-qty"
                                data-mdb-ripple-color="dark">
                                <i class="fa fa-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center border border-secondary"
                                value="<?= isset($productInCart) && is_array($productInCart) ? $productInCart['qty'] : 1 ?>"
                                id="quantity" min="1" aria-label="Quantity"
                                data-product-id="<?= isset($productInCart) && is_array($productInCart) ? $productInCart['id'] : $product['id'] ?>"
                                data-rowid="<?= isset($productInCart) && is_array($productInCart) ? $productInCart['rowid'] : '' ?>">

                            <button class="btn btn-white border border-secondary px-3" type="button" id="increase-qty"
                                data-mdb-ripple-color="dark">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <p class="mt-2 mb-2">Quotation value may vary following any additional client needs e.g <strong>
                        Installation
                        and Transportation</strong>.</p>
                <div class="product-container">
                    <?php if (!$productInCart): ?>
                        <div class="cart-buttons">
                            <a title="Add to cart" class="btn-new btn-primary shadow-0 add-to-cart"
                                data-id="<?= $product['id'] ?>" href="#"><i class="me-1 fa fa-shopping-basket"></i>Add
                                to cart</a>

                            <a title="Wishlist" class=" btn-new btn-primary add-to-wishlist" data-id="<?= $product['id'] ?>"
                                href="javascript:void(0);">
                                <i class="ti-heart"></i><span>Add to Wishlist</span>
                            </a>
                            <a title="Quote" class=" btn-new btn-primary" data-toggle="modal" data-target="#enquiryModal"
                                data-id="<?= $product['id'] ?>" href="javascript:void(0);">
                                <span>Request installation

                                    quote</span>
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
                <div id="product-info" class="product-info">
                    <div class="nav-main">
                        <!-- Tab Nav -->
                        <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description"
                                    role="tab" aria-selected="true">Description</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#specifications" role="tab"
                                    aria-selected="false">Specifications</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab"
                                    aria-selected="false">Reviews</a></li>
                        </ul>
                        <!--/ End Tab Nav -->
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <!-- Description Tab -->
                        <div class="tab-pane fade active show" id="description" role="tabpanel">
                            <div><?= htmlspecialchars_decode(esc($product['description'])) ?></div>
                        </div>

                        <!-- Specifications Tab -->
                        <div class="tab-pane fade" id="specifications" role="tabpanel">
                            <div class="single-specs">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                                <?= htmlspecialchars_decode($product['specifications'] ?? 'No specifications available.'); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="mb-3" id="review">
                                <?php if (empty($reviews)): ?>
                                    <p>There are no reviews for this product.</p>
                                <?php else: ?>
                                    <ul>
                                        <?php foreach ($reviews as $review): ?>
                                            <li>
                                                <strong><?= esc($review['name']) ?> (Rating:
                                                    <?= esc($review['rating']) ?>)</strong>
                                                <p><?= esc($review['text']) ?></p>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>

                            <h5>Write a review</h5>
                            <form class="form-horizontal form-review" id="form-review"
                                action="<?= base_url('products/submitReview') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                                    <div class="col-md-4 form-group required">
                                        <label for="input-name">Enter Full Name</label>
                                        <input type="text" name="name" id="input-name" class="form-control" required
                                            placeholder="Enter Full Name">
                                    </div>
                                    <div class="col-md-4 form-group required">
                                        <label for="input-email">Enter Email Address</label>
                                        <input type="email" name="email" id="input-email" class="form-control" required
                                            placeholder="Enter Email Address">
                                    </div>
                                    <div class="col-md-4 form-group required">
                                        <label for="input-phone">Mobile phone number</label>
                                        <input type="tel" name="phone" id="input-phone" class="form-control" required
                                            placeholder="Enter phone number e.g 254711079000">
                                    </div>
                                    <div class="col-md-8 form-group required">
                                        <label for="input-review">Your Review</label>
                                        <textarea name="text" rows="5" id="input-review" class="form-control" required
                                            placeholder="Enter Comment / Query"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group required">
                                        <label for="input-captcha">Enter the letters below:</label>
                                        <div class="captcha-display"><?= esc($captcha) ?></div>
                                        <input type="text" name="captcha" id="input-captcha" class="form-control"
                                            required placeholder="Enter the letters">
                                    </div>
                                </div>
                                <div class="buttons clearfix">
                                    <div class="pull-left">
                                        <button type="submit" class="btn btn-primary btn-lg mt-2">Submit Product
                                            Review</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enquiry Modal -->
        <div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="enquiryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content p-3"> <!-- No inline styles here -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="enquiryModalLabel">Request Installation Quotation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="enquiryForm">
                        <div class="modal-body"> <!-- No inline styles here -->
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                            <!-- Hidden product ID field -->
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Send</button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include APPPATH . 'Views/backend/pages/js.php'; ?>
<?php include APPPATH . 'Views/backend/pages/modal/cart-modal.php'; ?>

<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/flexslider.min.css">
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/jquery.flexslider-min.js"></script>

<script>
    $(document).ready(function () {
        $('#enquiryForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: '<?= base_url('products/send-enquiry') ?>',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    alert('Enquiry sent successfully!');
                    $('#enquiryModal').modal('hide');
                    $('#enquiryForm')[0].reset();
                },
                error: function () {
                    alert('Failed to send enquiry. Please try again.');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>

</div>