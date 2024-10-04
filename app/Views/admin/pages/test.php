<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<title>Change Management System</title>
	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="/public/backend/vendors/images/favicon.ico" />
	<link rel="icon" type="image/png" sizes="32x32" href="/public/backend/vendors/images/favicon.ico" />
	<link rel="icon" type="image/png" sizes="16x16" href="/public/backend/vendors/images/favicon.ico" />
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/public/backend/vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="/public/backend/vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="/public/backend/vendors/styles/style.css" />

	<?= $this->renderSection('stylesheets') ?>
</head>

<body>

	<?php include 'inc/header.php' ?>
	<?php include 'inc/right-sidebar.php' ?>
	<?php include 'inc/left-sidebar.php' ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">

				<div>
					<?= $this->renderSection('content') ?>
				</div>
			</div>
			<?php include 'inc/footer.php' ?>
		</div>
	</div>

	<!-- js -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="/public/backend/vendors/scripts/core.js"></script>
	<script src="/public/backend/vendors/scripts/script.min.js"></script>
	<script src="/public/backend/vendors/scripts/process.js"></script>
	<script src="/public/backend/vendors/scripts/layout-settings.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<?= $this->renderSection('scripts') ?>
</body>

</html>