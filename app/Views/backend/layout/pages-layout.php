<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
    <title>Suntech.</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/favicon.png">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="backend/css/bootstrap.css">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="backend/css/magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="backend/css/font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="backend/css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="backend/css/themify-icons.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="backend/css/niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="backend/css/animate.css">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="backend/css/flex-slider.min.css">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="backend/css/owl-carousel.css">
	<!-- Slicknav -->
    <link rel="stylesheet" href="backend/css/slicknav.min.css">
	
	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="backend/css/reset.css">
	<link rel="stylesheet" href="backend/css/style.css">
    <link rel="stylesheet" href="backend/css/responsive.css">
	<?= $this->renderSection('stylesheets') ?>
</head>

<body>

	<?php include 'inc/header.php' ?>
	

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
	<!-- Jquery -->
    <script src="backend/js/jquery.min.js"></script>
    <script src="backend/js/jquery-migrate-3.0.0.js"></script>
	<script src="backend/js/jquery-ui.min.js"></script>

	<!-- Popper JS -->
	<script src="backend/js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="backend/js/bootstrap.min.js"></script>
	<!-- Slicknav JS -->
	<script src="backend/js/slicknav.min.js"></script>
	<!-- Owl Carousel JS -->
	<script src="backend/js/owl-carousel.js"></script>
	<!-- Magnific Popup JS -->
	<script src="backend/js/magnific-popup.js"></script>
	<!-- Waypoints JS -->
	<script src="backend/js/waypoints.min.js"></script>
	<!-- Countdown JS -->
	<script src="backend/js/finalcountdown.min.js"></script>
	<!-- Nice Select JS -->
	<script src="backend/js/nicesellect.js"></script>
	<!-- Flex Slider JS -->
	<script src="backend/js/flex-slider.js"></script>
	<!-- ScrollUp JS -->
	<script src="backend/js/scrollup.js"></script>
	<!-- Onepage Nav JS -->
	<script src="backend/js/onepage-nav.min.js"></script>
	<!-- Easing JS -->
	<script src="backend/js/easing.js"></script>
	<!-- Active JS -->
	<script src="backend/js/active.js"></script>

	<?= $this->renderSection('scripts') ?>
</body>

</html>