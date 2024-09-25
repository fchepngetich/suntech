<header class="header shop">
		<!-- Topbar -->
		<div class="topbar">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-12 col-12">
						<!-- Top Left -->
						<div class="top-left">
							<ul class="list-main">
								<li><i class="ti-headphone-alt"></i> Need Help? Call us  0715208282</li>
							</ul>
						</div>
						<!--/ End Top Left -->
					</div>
					<div class="col-lg-7 col-md-12 col-12">
						<!-- Top Right -->
						<div class="right-content">
							<ul class="list-main">
                            <li></i> <a href="#">Our Impact</a></li>
                            <li></i> <a href="#">About Us</a></li>
								<li> <a href="#">Order Tracking</a></li>
								<li><a href="#">Contact Us</a></li>
                                <li><a href="#">FAQs</a></li>

							</ul>
						</div>
						<!-- End Top Right -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Topbar -->
		<div class="middle-inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-12">
						<!-- Logo -->
						<div class="logo">
							<a href=""><img src="backend/images/logo-suntech.jpg" alt="logo"></a>
						</div>
						<!--/ End Logo -->
						<!-- Search Form -->
						<div class="search-top">
							<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
							<!-- Search Form -->
							<div class="search-top">
								<form class="search-form">
									<input type="text" placeholder="Search here..." name="search">
									<button value="search" type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
							<!--/ End Search Form -->
						</div>
						<!--/ End Search Form -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-5 col-md-7 col-12">
						<div class="search-bar-top">
							<div class="search-bar">
								<select>
									<option selected="selected">All Category</option>
									<option>watch</option>
									<option>mobile</option>
									<option>kid’s item</option>
								</select>
								<form>
									<input name="search" placeholder="Search Products Here....." type="search">
									<button class="btnn"><i class="ti-search"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-md-3 col-12">
						<div class="right-bar">
							<!-- Search Form -->
							<div class="sinlge-bar">
								<a href="#" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i> <span class="pl-1">My wishlist</span> </a>
							</div>
							<div class="sinlge-bar">
								<a href="#" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="pl-1">My Account</span></a>
							</div>
							<div class="sinlge-bar shopping">
    <a href="#" class="single-icon">
        <i class="ti-bag"></i> 
        <span class="pl-1">Cart</span> 
        <span class="total-count ml-3"><?= isset(session()->get('cart')['total_items']) ? session()->get('cart')['total_items'] : 0 ?></span>
    </a>

    <!-- Shopping Item -->
    <?php $cart = \Config\Services::cart(); ?>
<div class="shopping-item">
    <div class="dropdown-cart-header">
        <span><?= $cart->totalItems() ?> Items</span>
        <a href="<?= base_url('/cart') ?>">View Cart</a>
    </div>
    <ul class="shopping-list">
        <?php if ($cart->contents()) : ?>
            <?php foreach ($cart->contents() as $item) : ?>
                <li>
                    <a href="#" class="remove" title="Remove this item" data-id="<?= $item['rowid'] ?>"><i class="fa fa-remove"></i></a>
                    <a class="cart-img" href="#"><img src="<?= base_url('writable/uploads/' . $item['options']['image']) ?>" alt="#"></a>
                    <h4><a href="#"><?= $item['name'] ?></a></h4>
                    <p class="quantity"><?= $item['qty'] ?>x - <span class="amount">$<?= number_format($item['price'], 2) ?></span></p>
                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <li><p>Your cart is empty!</p></li>
        <?php endif; ?>
    </ul>

    <div class="bottom">
        <div class="total">
            <span>Total</span>
            <span class="total-amount">$<?= number_format($cart->total(), 2) ?></span>
        </div>
        <a href="<?= base_url('/checkout') ?>" class="btn animate">Checkout</a>
    </div>
</div>

    <!--/ End Shopping Item -->
</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Header Inner -->
		<div class="header-inner">
			<div class="container">
				<div class="cat-nav-head">
					<div class="row">
						<div class="col-lg-4">
							<div class="all-category">
								<h3 class="cat-heading"><i class="fa fa-bars" aria-hidden="true"></i>SHOP BY CATEGORY</h3>
								<!-- <ul class="main-category">
									<li><a href="#">New Arrivals <i class="fa fa-angle-right" aria-hidden="true"></i></a>
										<ul class="sub-category">
											<li><a href="#">accessories</a></li>
											<li><a href="#">best selling</a></li>
											<li><a href="#">top 100 offer</a></li>
										</ul>
									</li>
									<li class="main-mega"><a href="#">best selling <i class="fa fa-angle-right" aria-hidden="true"></i></a>
										<ul class="mega-menu">
											<li class="single-menu">
												<a href="#" class="title-link">Shop Kid's</a>
												<div class="image">
													<img src="https://via.placeholder.com/225x155" alt="#">
												</div>
												<div class="inner-link">
													<a href="#">Kids Toys</a>
													<a href="#">Kids Travel Car</a>
													<a href="#">Kids Color Shape</a>
													<a href="#">Kids Tent</a>
												</div>
											</li>
											<li class="single-menu">
												<a href="#" class="title-link">Shop Men's</a>
												<div class="image">
													<img src="https://via.placeholder.com/225x155" alt="#">
												</div>
												<div class="inner-link">
													<a href="#">Watch</a>
													<a href="#">T-shirt</a>
													<a href="#">Hoodies</a>
													<a href="#">Formal Pant</a>
												</div>
											</li>
											<li class="single-menu">
												<a href="#" class="title-link">Shop Women's</a>
												<div class="image">
													<img src="https://via.placeholder.com/225x155" alt="#">
												</div>
												<div class="inner-link">
													<a href="#">Ladies Shirt</a>
													<a href="#">Ladies Frog</a>
													<a href="#">Ladies Sun Glass</a>
													<a href="#">Ladies Watch</a>
												</div>
											</li>
										</ul>
									</li>
								
									
								</ul> -->
							</div>
						</div>
						<div class="col-lg-8 col-12">
							<div class="menu-area">
								<!-- Main Menu -->
								<nav class="navbar navbar-expand-lg">
									<div class="navbar-collapse">	
										<div class="nav-inner">	
											<ul class="nav main-menu menu navbar-nav">
                                            <li><a href="#">Water Heating<i class="ti-angle-down"></i></a>
														<ul class="dropdown">
															<li><a href="cart.html">Cart</a></li>
															<li><a href="checkout.html">Checkout</a></li>
														</ul>
													</li>													
													<li><a href="#">Solar Energy<i class="ti-angle-down"></i></a>
														<ul class="dropdown">
															<li><a href="cart.html">Cart</a></li>
															<li><a href="checkout.html">Checkout</a></li>
														</ul>
													</li>
													<li><a href="#">Solar Pumps<i class="ti-angle-down"></i></a>
														<ul class="dropdown">
															<li><a href="blog-single-sidebar.html">Blog Single Sidebar</a></li>
														</ul>
													</li>
												</ul>
										</div>
									</div>
								</nav>
								<!--/ End Main Menu -->	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Header Inner -->
	</header>