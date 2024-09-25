<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <section class="hero-area3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="big-content">
                        <div class="inner">
                            <!-- <h4 class="title">Mega sale up to <span>50%</span> off for all</h4>
                            <p class="des">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste
                                laborum deleniti nam in quos qui nemo ipsum numquam.</p>-->
                            <div class="button">
                                <a href="#" class="btn">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small-content first">
                                <div class="inner">
                                    <!-- <h4 class="title">Awesome Bag <br> 2020</h4> -->
                                    <div class="button">
                                        <a href="#" class="btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small-content secound">
                                <div class="inner">
                                    <!-- <h4 class="title">Awesome Bag <br> 2020</h4> -->
                                    <div class="button">
                                        <a href="#" class="btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small-content third">
                                <div class="inner">
                                    <!-- <h4 class="title">Summer travel <br> collection</h4> -->
                                    <div class="button">
                                        <a href="#" class="btn">Discover Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small-content fourth">
                                <div class="inner">
                                    <!-- <h4 class="title">Summer travel <br> collection</h4> -->
                                    <div class="button">
                                        <a href="#" class="btn">Discover Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section class="introduction">
        <div class="container mt-3 mb-1">
            <div class="row">
                <div class="content p-3">
                    <h4 class="title mb-2">Solar Power Equipment Supplier In Kenya</h4>
                    <p class="des">
                        Suntech Power Limited is a supplier of solar power and lighting solutions in Kenya. Registered
                        by Energy and Petroleum Regulatory Authority (EPRA), Suntech Power supplies and installs high
                        quality solar and energy-related equipment in Kenya and the East African region. We supply,
                        install and maintain solar water heating systems, solar inverters, solar batteries, solar power
                        systems, solar pumping solutions, backup systems, and solar installation accessories. Suntech
                        has a team of qualified solar experts including engineers, solar technicians and installers who
                        are licensed by EPRA.</p>

                </div>

            </div>
        </div>
</div>
</section>
<!-- Start Recommended -->


<section>
    <div class="container mt-5 mb-5">
        <div class="row">
            <h4 class="title pl-3">Recommended Products</h4>
            <span class="ml-auto"> <a class="btn btn-sm btn-info" href="">View All</a> </span>
        </div>
        <div class="row">
            <?php foreach ($recommendedProducts as $product): ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-12">
                    <div class="single-product">
                        <div class="product-img">
                        <a href="product-details.html">
                                <img class="default-img" src="<?= base_url(relativePath: '/backend/' . $product['image']) ?>"
                                    alt="#">
                                <img class="hover-img" src="<?= base_url(relativePath: '/backend/' . $product['image']) ?>" alt="#">
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i
                                            class="ti-eye"></i><span>Quick Shop</span></a>
                                    <a title="Wishlist" href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                </div>
                                <div class="product-action-2">
                                    <a title="Add to cart" href="#">Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="product-details.html"><?= $product['name'] ?></a></h3>
                            <div class="product-price">
                                <span class="discounted-price">$00</span>
                                <span class="original-price">$<?= $product['price'] ?></span>
                            </div>
                        </div>
                        <div class="product-action-2 m-2">
                            <a title="Add to cart" class="btn-sm btn-danger" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End Reccommended -->


<!-- Start Sustainability  -->

<div class="section-inner mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="image">

                    <img src="backend/images/sustainability-banner.png" alt="#">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Sustainability  -->

<!-- Top Deals  -->


<section>
    <div class="container mt-5 mb-5">
        <div class="row">
            <h4 class="title pl-3">Top Deals</h4>
            <span class="ml-auto"> <a class="btn btn-sm btn-info" href="">View All</a> </span>
        </div>
        <div class="row">
            <?php foreach ($topDeals as $product): ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-12">
                    <div class="single-product">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img class="default-img" src="<?= base_url(relativePath: '/backend/' . $product['image']) ?>"
                                    alt="#">
                                <img class="hover-img" src="<?= base_url(relativePath: '/backend/' . $product['image']) ?>" alt="#">
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i
                                            class="ti-eye"></i><span>Quick Shop</span></a>
                                    <a title="Wishlist" href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                </div>
                                <div class="product-action-2">
                                    <a title="Add to cart" href="#">Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="product-details.html"><?= $product['name'] ?></a></h3>
                            <div class="product-price">
                                <span class="discounted-price">$00</span>
                                <span class="original-price">$<?= $product['price'] ?></span>
                            </div>
                        </div>
                        <div class="product-action-2 m-2">
                        <a title="Add to cart" class="btn-sm btn-danger add-to-cart" data-id="<?= $product['id'] ?>" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>




<!-- end Top Deals  -->



<!-- Start Shop Blog  -->
<section class="shop-blog sections">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-titles mb-3 mt-3">
                    <h4>Latest Insights</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <!-- Start Single Blog  -->
                <div class="shop-single-blog">
                    <img class="default-img" src="backend/images/insights1.png" alt="#">

                    <!-- <img src="https://via.placeholder.com/370x300" alt="#"> -->
                    <div class="content">
                        <p class="date">22 July , 2020. Monday</p>
                        <a href="#" class="text">Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue,
                            magna eros eu erat. Aliquam er</a>
                        <a href="#" class="more-btn">Continue Reading</a>
                    </div>
                </div>
                <!-- End Single Blog  -->
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <!-- Start Single Blog  -->
                <div class="shop-single-blog">
                    <img class="default-img" src="backend/images/insights2.png" alt="#">
                    <div class="content">
                        <p class="date">22 July, 2020. Monday</p>
                        <a href="#" class="text">Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue,
                            magna eros eu erat. Aliquam er</a>
                        <a href="#" class="more-btn">Continue Reading</a>
                    </div>
                </div>
                <!-- End Single Blog  -->
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <!-- Start Single Blog  -->
                <div class="shop-single-blog">
                    <img class="default-img" src="backend/images/insights3.png" alt="#">
                    <div class="content">
                        <p class="date">22 July, 2020. Monday</p>
                        <a href="#" class="text">Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue,
                            magna eros eu erat. Aliquam er</a>
                        <a href="#" class="more-btn">Continue Reading</a>
                    </div>
                </div>
                <!-- End Single Blog  -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Blog  -->


<?= $this->section('scripts') ?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- FlexSlider CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/flexslider.min.css">
<!-- FlexSlider JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/jquery.flexslider-min.js"></script>
<script>
    jQuery.noConflict();
(function($) {
    $(document).ready(function() {
        $('.flexslider').flexslider({
            animation: "slide"
        });
    });
})(jQuery);
$(document).ready(function () {
    // Bind the click event to the 'add-to-cart' button
    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();  // Prevent the default link behavior

        // Get the product ID from the data attribute
        var productId = $(this).data('id');

        // Check if the productId is being captured correctly
        console.log('Button clicked. Product ID:', productId);

        // Make sure the productId is not undefined or empty
        if (!productId) {
            console.log('Error: Product ID is missing.');
            alert('Error: Product ID is missing.');
            return;
        }

        // Make the AJAX request to add the product to the cart
        $.ajax({
            url: '<?= base_url('cart/add') ?>/' + productId, // Ensure the URL is constructed correctly

    type: 'POST',
    data: { product_id: productId },
    dataType: 'json',
    success: function (response) {
        console.log('AJAX success response:', response);
        if (response.status === 'success') {
            // Update the cart count in the HTML
            $('.total-count').text(response.totalItems);
            console.log('Cart updated. Total items:', response.totalItems);
            
            // Optional: Provide user feedback
            alert('Success: ' + response.message); // Simple alert
        } else {
            console.log('Error from server:', response.message);
            alert(response.message);
        }
    },
    error: function (xhr, status, error) {
        console.error('AJAX error:', status, error);
        alert('An error occurred while adding to cart.');
    }
});

    });
});

    

</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>