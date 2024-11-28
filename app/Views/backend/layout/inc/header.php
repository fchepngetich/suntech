<header class="header shop">
	<!-- Topbar -->
	<div class="topbar">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-12 col-12">
					<!-- Top Left -->
					<div class="top-left">
						<ul class="list-main">
							<li>Need Help? Call us 0715208282</li>
						</ul>
					</div>
					<!--/ End Top Left -->
				</div>
				<div class="col-lg-7 col-md-12 col-12">
					<!-- Top Right -->
					<div class="right-content">
						<ul class="list-main top-bar-nav">
							<li></i> <a href="<?= base_url('our-impact') ?>">Our Impact</a></li>
							<li></i> <a href="<?= base_url('about-us') ?>">About Us</a></li>
							<li> <a href="<?= base_url('track-order') ?>">Order Tracking</a></li>
							<li><a href="<?= base_url('contact') ?>">Contact Us</a></li>
							<li><a href="<?= base_url('faqs') ?>">FAQs</a></li>

						</ul>

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
								<img src="<?= get_image_url('logo-suntech.jpg') ?>" alt="logo">
							</a>
						</div>

						<!--/ End Logo -->

						<!--/ End Search Form -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-6 col-md-7 col-12">
						<div class="search-bar-top">
							<div class="search-bar">
								<form action="<?= base_url('search/suggestions'); ?>" method="POST">
									<select name="category" class="form-control category-select">
										<option value="">Select Category</option>
										<?php foreach ($categories as $cat): ?>
											<option value="<?= esc($cat['slug']); ?>" <?= (isset($category) && $cat['slug'] === $category) ? 'selected' : ''; ?>>
												<?= esc($cat['name']); ?>
											</option>
										<?php endforeach; ?>
									</select>


									<input name="search" value="<?= isset($search) ? esc($search) : ''; ?>"
										placeholder="Search Products" type="search" class="form-control mr-2">
									<button class="btnn" type="submit">
										<i class="ti-search"></i>
									</button>
								</form>


							</div>
						</div>

					</div>
					<div class="col-lg-4 col-md-3 col-12">
						<div class="right-bars d-flex justify-content-end">
							<!-- Search Form -->
							<div class="sinlge-bar">
								<a href="<?= base_url('/products/wishlist') ?>" class="single-icon"><i
										class="fa fa-heart-o" aria-hidden="true"></i> <span class="pl-1">My
										wishlist</span> </a>
							</div>
							<div class="sinlge-bar">
								<?php if (session()->has('logged_in') && session()->get('logged_in')): ?>
									<a href="<?= base_url('/logout') ?>" class="single-icon">
										<i class="fa fa-user-circle-o" aria-hidden="true"></i>
										<span class="pl-1">Logout</span>
									</a>
								<?php else: ?>
									<a href="<?= base_url('/login') ?>" class="single-icon">
										<i class="fa fa-user-circle-o" aria-hidden="true"></i>
										<span class="pl-1">My Account</span>
									</a>
								<?php endif; ?>


							</div>
							<div class="sinlge-bar shopping">
								<a href="<?= base_url('/cart') ?>" class="single-icon">
									<i class="ti-bag"></i>
									<span class="pl-1">Cart</span>
									<?php $cartService = \Config\Services::cart(); ?>
									<span class="total-count ml-3"><?= $cartService->totalItems() ?></span>

								</a>

								<?php $cart = \Config\Services::cart(); ?>
								
							</div>


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
						<ul class="nav main-menu navbar-nav">
								<li class="active">
									<a class="cat-heading" href="#"><i class="fa fa-bars" aria-hidden="true"></i>SHOP BY
										CATEGORY<i class="ti-angle-down"></i></a>
									<ul class="dropdown">
										<?php foreach ($categories as $category): ?>
											<li>
												<a
													href="<?= base_url('categories/category/' . $category['slug']) ?>"><?= esc($category['name']); ?></a>
											</li>
										<?php endforeach; ?>

									</ul>
								</li>



							</ul>
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
														<a
															href="<?= base_url('categories/category/' . $category['slug']) ?>"><?= $category['name'] ?><i
																class="ti-angle-down"></i></a>
														<ul class="level0 submenu">
															<?php if (!empty($category['subcategories'])): ?>
																<div class="row">
																	<?php foreach ($category['subcategories'] as $subcategory): ?>
																		<div class="col-md-6">
																			<li class="level1 nav-2-1">
																				<a
																					href="<?= base_url('subcategories/subcategory/' . $subcategory['slug']) ?>">
																					<strong><?= $subcategory['name'] ?></strong>
																				</a>
																				<!-- Display subsubcategories under the subcategory -->
																				<ul class="subsubcategories-list">
																					<?php if (!empty($subcategory['subsubcategories'])): ?>

																						<?php foreach ($subcategory['subsubcategories'] as $subsubcategory): ?>
																							<li class="level2 nav-2-1-1">
																								<a
																									href="<?= base_url('subsubcategories/details/' . $subsubcategory['slug']) ?>"><?= $subsubcategory['name'] ?></a>
																							</li>
																						<?php endforeach; ?>

																					<?php endif; ?>
																				</ul>
																			</li>
																		</div>
																	<?php endforeach; ?>
																</div>
															<?php endif; ?>
														</ul>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									</div>
								</nav>
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

	document.querySelector('form').addEventListener('submit', function (e) {
		console.log('Form is submitting...');
	});

	$(document).on('click', '.remove', function (e) {
		//e.preventDefault();
		var rowid = $(this).data('id');
		$.ajax({
			url: '/cart/remove/' + rowid,
			type: 'POST',
			dataType: 'json',
			success: function (response) {
				$('.total-count').text(response.totalItems);

				$('.total-amount').text('$' + parseFloat(response.totalAmount).toFixed(2));

				$(this).closest('li').remove();
			},
			error: function (xhr) {
				console.error('Error removing item from cart', xhr);
			}
		});
	});
</script>


<?= $this->endSection() ?>