<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */




$routes->group('', static function ($routes) {
    $routes->group('', static function ($routes) {
        $routes->get('/', 'Home::index');
        $routes->get('/cart', 'CartController::viewCart');
        $routes->post('cart/add', 'CartController::addToCart');
        $routes->get('/cart/add/(:num)', 'CartController::addToCart/$1');
        // $routes->get('/cart/remove/(:num)', 'CartController::removeFromCart/$1');
        $routes->post('cart/add/(:num)', 'CartController::addToCart/$1');
        $routes->post('/cart/remove/(:segment)', 'CartController::removeFromCart/$1');
        $routes->post('cart/clear', 'CartController::clearCart');
        $routes->post('cart/update', 'CartController::update'); 

        // $routes->post('cart/add/(:num)', 'CartController::add/$1'); // For adding items to the cart
$routes->get('cart/getCartItems', 'CartController::getCartItems'); // For fetching cart items to display in the modal

        $routes->post('wishlist/add', 'WishlistController::add');
        $routes->get('logout', 'AuthController::logoutHandler');

        // $routes->get('/register', 'AuthController::register');
        // $routes->post('/register', 'AuthController::store');
        // $routes->get('/login', 'AuthController::login');
        // $routes->post('/login', 'AuthController::authenticate');
        // $routes->get('/logout', 'AuthController::logout');
    });
    $routes->group('admin/products', static function ($routes) {
        $routes->get('', 'ProductController::index', ['as' => 'products.index']); 
        $routes->get('details/(:any)', 'ProductController::details/$1');
        $routes->get('create', 'ProductController::create', ['as' => 'products.create']); // Show create form
        $routes->post('store', 'ProductController::store', ['as' => 'products.store']); // Save new product
        $routes->get('edit/(:num)', 'ProductController::edit/$1', ['as' => 'products.edit']); // Show edit form
        $routes->post('update/(:num)', 'ProductController::update/$1', ['as' => 'products.update']); // Update product
        $routes->delete('delete/(:num)', 'ProductController::delete/$1', ['as' => 'products.delete']); // Delete product
        $routes->post('wishlist/add', 'WishlistController::addToWishlist');

    });

    $routes->group('products/wishlist', ['filter' => 'cifilter:auth'],static function ($routes) {
        $routes->get('move-to-cart/(:num)', 'WishlistController::moveToCart/$1');
        // $routes->get('add/(:num)', 'WishlistController::addToWishlist/$1');
        $routes->get('', 'WishlistController::viewWishlist');
        $routes->post('remove/(:num)', 'WishlistController::removeFromWishlist/$1');
        $routes->get('move-to-cart/(:num)', 'WishlistController::moveToCart/$1');
        
    });

    $routes->group('categories', static function ($routes) {
        $routes->get('', 'CategoryController::index', ['as' => 'categories.index']); // List categories
        $routes->get('create', 'CategoryController::create', ['as' => 'categories.create']); // Show create form
        $routes->post('store', 'CategoryController::store', ['as' => 'categories.store']); // Save new category
        $routes->get('edit/(:num)', 'CategoryController::edit/$1', ['as' => 'categories.edit']); // Show edit form
        $routes->post('update/(:num)', 'CategoryController::update/$1', ['as' => 'categories.update']); // Update category
        $routes->delete('delete/(:num)', 'CategoryController::delete/$1', ['as' => 'categories.delete']);
        $routes->get('category/(:segment)', 'CategoryController::view/$1');

    });
    $routes->group('subcategories', static function ($routes) {
        $routes->get('subcategory/(:any)', 'SubcategoryController::subcategoryItems/$1');


    });

    $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {
        $routes->get('login', 'AuthController::loginForm', ['as' => 'admin.login.form']);
        $routes->get('register', 'AuthController::registerForm', ['as' => 'admin.register.form']);
        $routes->post('login', 'AuthController::loginHandler', ['as' => 'admin.login.handler']);
        $routes->post('register', 'AuthController::registerHandler', ['as' => 'admin.register.handler']);

        $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'admin.forgot.form']);
        //$routes->get('forgot-password', 'AuthController::forgotPassword', ['as' => 'admin.forgot.form']);
        $routes->post('forgot-password', 'AuthController::sendResetLink', ['as' => 'send_password_reset_link']);
        //$routes->post('send-password-reset-link','AuthController::sendPasswordResetLink',['as'=>'send_password_reset_link']);
        $routes->get('password/reset/(:any)', 'AuthController::resetPassword/$1', ['as' => 'admin.reset_password']);
        $routes->get('change-password', 'AdminController::changePassword', ['as' => 'change_password']);

    });
   

    
});
