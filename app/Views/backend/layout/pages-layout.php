<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Tag  -->
    <title>Suntech</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('backend/images/suntechsvg.ico') ?>">
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    
    <!-- StyleSheet -->
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('backend/css/bootstrap.css') ?>">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="<?= base_url('backend/css/magnific-popup.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('backend/css/font-awesome.css') ?>">
    <!-- Fancybox -->
    <link rel="stylesheet" href="<?= base_url('backend/css/jquery.fancybox.min.css') ?>">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="<?= base_url('backend/css/themify-icons.css') ?>">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="<?= base_url('backend/css/niceselect.css') ?>">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?= base_url('backend/css/animate.css') ?>">
    <!-- Flex Slider CSS -->
    <link rel="stylesheet" href="<?= base_url('backend/css/flex-slider.min.css') ?>">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="<?= base_url('backend/css/owl-carousel.css') ?>">
    <!-- Slicknav -->
    <link rel="stylesheet" href="<?= base_url('backend/css/slicknav.min.css') ?>">
    <!-- Include SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Eshop StyleSheet -->
    <link rel="stylesheet" href="<?= base_url('backend/css/reset.css') ?>">
    <link rel="stylesheet" href="<?= base_url('backend/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('backend/css/responsive.css') ?>">
    <?= $this->renderSection('stylesheets') ?>
</head>

<body>

    <?php //include 'inc/header.php' ?>

<?php
$categoryModel = new \App\Models\CategoryModel();
$categories = $categoryModel->getCategoriesWithSubcategoriesAndProducts();
echo view('backend/layout/inc/header', ['categories' => $categories]);
?>

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
    <script src="<?= base_url('backend/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('backend/js/jquery-migrate-3.0.0.js') ?>"></script>
    <script src="<?= base_url('backend/js/jquery-ui.min.js') ?>"></script>

    <!-- Popper JS -->
    <script src="<?= base_url('backend/js/popper.min.js') ?>"></script>
    <!-- Bootstrap JS -->
    <script src="<?= base_url('backend/js/bootstrap.min.js') ?>"></script>
    <!-- Slicknav JS -->
    <script src="<?= base_url('backend/js/slicknav.min.js') ?>"></script>
    <!-- Owl Carousel JS -->
    <script src="<?= base_url('backend/js/owl-carousel.js') ?>"></script>
    <!-- Magnific Popup JS -->
    <script src="<?= base_url('backend/js/magnific-popup.js') ?>"></script>
    <!-- Waypoints JS -->
    <script src="<?= base_url('backend/js/waypoints.min.js') ?>"></script>
    <!-- Countdown JS -->
    <script src="<?= base_url('backend/js/finalcountdown.min.js') ?>"></script>
    <!-- Nice Select JS -->
    <script src="<?= base_url('backend/js/nicesellect.js') ?>"></script>
    <!-- Flex Slider JS -->
    <script src="<?= base_url('backend/js/flex-slider.js') ?>"></script>
    <!-- ScrollUp JS -->
    <script src="<?= base_url('backend/js/scrollup.js') ?>"></script>
    <!-- Onepage Nav JS -->
    <script src="<?= base_url('backend/js/onepage-nav.min.js') ?>"></script>
    <!-- Easing JS -->
    <script src="<?= base_url('backend/js/easing.js') ?>"></script>
    <!-- Active JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- jQuery and Bootstrap JS -->

    <script src="<?= base_url('backend/js/active.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>
