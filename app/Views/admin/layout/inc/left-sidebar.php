<div class="left-side-bar">
	<div class="brand-logo">
		<a href="<?= base_url('admin') ?>">
		<img src="/backend/vendors/images/suntech-logo.jpg" alt="" class="dark-logo" />
<img src="/backend/vendors/images/suntech-logo.jpg" alt="" class="light-logo" />

		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<li>
					<a href="<?= base_url('admin') ?>" class="dropdown-toggle no-arrow">
						<span class="micon dw dw-home"></span><span class="mtext">Home</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url('/admin/products/') ?>" class="dropdown-toggle no-arrow">
						<span class="micon dw dw-add"></span><span class="mtext">Products</span>
					</a>
				</li>
				
				<li>
					    <li>
						<a href="<?= base_url('/admin/categories') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user"></span><span class="mtext">Categories</span>
						</a>
					</li>
					<li>
						<a href="<?= base_url('/admin/subcategories') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user"></span><span class="mtext">SubCategories</span>
						</a>
					</li>
				

					<li>
						<a href="<?= base_url('/admin/get-users') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-user"></span><span class="mtext">Users</span>
						</a>
					</li>

					<li>
						<a href="<?= base_url('admin/roles') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-list"></span><span class="mtext">Roles</span>
						</a>

					
					<li>
						<a href="<?= base_url('admin/logs') ?>" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-list"></span><span class="mtext">System Logs</span>
						</a>

					<li>

					<div class="dropdown-divider"></div>
				</li>
				<li>
					<div class="sidebar-small-cap">Settings</div>
				</li>
				<li>
					<a href="<?= base_url('/admin/profile') ?>" class="dropdown-toggle no-arrow">
						<span class="micon dw dw-user"></span>
						<span class="mtext">Profile
						</span>
					</a>
					
				</li>

			</ul>
		</div>
	</div>
</div>