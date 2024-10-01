<header class="header shop">
	<!-- Topbar -->
	<div class="topbar">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-12 col-12">
					<!-- Top Left -->
					<div class="top-left">
						<ul class="list-main">
							<li><i class="ti-headphone-alt"></i> Need Help? Call us 0715208282</li>
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
						<a href="<?= base_url('/') ?>">
							<img src="<?= base_url('backend/images/logo-suntech.jpg') ?>" alt="logo">
						</a>
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
        <form action="<?= base_url('search'); ?>" method="GET"> <!-- Add action and method for form submission -->
            <select name="category"> <!-- Add name attribute for the select -->
                <option value="">Select Category</option> <!-- Placeholder option -->
                <!-- Dynamically Loop through Categories -->
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['slug']; ?>"><?= esc($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <input name="search" placeholder="Search Products Here....." type="search">
            <button class="btnn" type="submit"><i class="ti-search"></i></button> <!-- Added type="submit" -->
        </form>
    </div>
</div>

				</div>
				<div class="col-lg-5 col-md-3 col-12">
					<div class="right-bar">
						<!-- Search Form -->
						<div class="sinlge-bar">
							<a href="<?= base_url('/products/wishlist') ?>" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i> <span
									class="pl-1">My wishlist</span> </a>
						</div>
						<div class="sinlge-bar">
							<?php if (App\Libraries\CIAuth::id()): ?>
								<a href="<?= base_url('/logout') ?>" class="single-icon"><i class="fa fa-user-circle-o"
										aria-hidden="true"></i> <span class="pl-1">Logout</span></a>
							<?php else: ?>
								<a href="<?= base_url('/login') ?>" class="single-icon"><i class="fa fa-user-circle-o"
										aria-hidden="true"></i> <span class="pl-1">My Account</span></a>
							<?php endif ?>

						</div>
						<div class="sinlge-bar shopping">
							<a href="<?= base_url('/cart') ?>" class="single-icon">
								<i class="ti-bag"></i>
								<span class="pl-1">Cart</span>
								<?php $cartService = \Config\Services::cart(); ?>
								<span class="total-count ml-3"><?= $cartService->totalItems() ?></span>

							</a>

							<!-- Shopping Item -->
							<?php $cart = \Config\Services::cart(); ?>
							<div class="shopping-item">
								<div class="dropdown-cart-header">
									<span><?= $cart->totalItems() ?> Items</span>
									<a href="<?= base_url('/cart') ?>">View Cart</a>
								</div>
								<ul class="shopping-list">
									<?php if ($cart->contents()): ?>
										<?php foreach ($cart->contents() as $item): ?>
											<li>
												<a href="#" class="remove" title="Remove this item"
													data-id="<?= esc($item['rowid']) ?>"><i class="fa fa-remove"></i></a>

												<a class="cart-img" href="#"><img
														src="<?= base_url('/backend/' . $item['options']['image']) ?>"
														alt="<?= esc($item['name']) ?>"></a>
												<h4><a href="#"><?= $item['name'] ?></a></h4>
												<p class="quantity"><?= $item['qty'] ?>x - <span
														class="amount">$<?= number_format($item['price'], 2) ?></span></p>
											</li>
										<?php endforeach; ?>
									<?php else: ?>
										<li>
											<p>Your cart is empty!</p>
										</li>
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
											<?php foreach ($categories as $category): ?>
												<li class="level0 nav-2 level-top parent">
													<a href="<?= base_url('categories/category/' . $category['slug']) ?>"><?= $category['name'] ?><i
															class="ti-angle-down"></i></a>

													<ul class="level0 submenu">
														<?php if (!empty($category['subcategories'])): ?>
															<!-- If there are subcategories, display them -->
															<!-- <li class="subcategory-title"><?= $category['name'] ?></li> -->
															<div class="row">
																<?php foreach ($category['subcategories'] as $subcategory): ?>
																	<div class="col-md-6">
																		<li class="level1 nav-2-1">
																			<a
																				href="<?= base_url('subcategories/subcategory/' . $subcategory['slug']) ?>">
																				<strong><?= $subcategory['name'] ?></strong>
																			</a>
																			<!-- Subcategory Name -->
																			<ul class="products-list">
																				<!-- Display products under the subcategory -->
																				<?php foreach ($subcategory['products'] as $product): ?>
																					<li class="level2 nav-2-1-1">
																						<a
																							href="<?= base_url('admin/products/details/' . $product['slug']) ?>"><?= $product['name'] ?></a>
																					</li>
																				<?php endforeach; ?>
																				<hr>
																			</ul>
																		</li>
																	</div>
																<?php endforeach; ?>
															</div>

														<?php else: ?>
															<!-- If no subcategories, display products directly under the category -->
															<?php foreach ($category['products'] as $product): ?>
																<li class="level1 nav-2-2"><a href="#"><?= $product['name'] ?></a>
																</li>
															<?php endforeach; ?>
														<?php endif; ?>
													</ul>
												</li>
											<?php endforeach; ?>
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
<?= $this->section('scripts') ?>
<script>

	$(document).on('click', '.remove', function (e) {
		e.preventDefault();
		var rowid = $(this).data('id');
		$.ajax({
			url: '/cart/remove/' + rowid,
			type: 'POST',
			dataType: 'json',
			success: function (response) {
				$('.total-count').text(response.totalItems);
				$('.total-amount').text('$' + parseFloat(response.totalAmount).toFixed(2));

				// Optionally, remove the item from the cart UI
				$(this).closest('li').remove();
			},
			error: function (xhr) {
				console.error('Error removing item from cart', xhr);
			}
		});
	});
</script>

</script>

<?= $this->endSection() ?>