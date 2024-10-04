<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


 $routes->group('admin', static function ($routes) {
    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
        //$routes->view('example-page','example-page');
        $routes->get('', 'AdminController::index', ['as' => 'admin.home']);
        $routes->get('logout', 'AdminController::logoutHandler', ['as' => 'admin.logout']);
        $routes->get('dashboard', 'AdminController::dashboard', ['as' => 'admin.dashboard']);
        $routes->get('get-users', 'AdminController::getUsers', ['as' => 'get-users']);
        $routes->get('new-user', 'AdminController::addUser', ['as' => 'new-user']);
        $routes->post('create-user', 'AdminController::createUser', ['as' => 'create-user']);
        //$routes->get('users/edit/(:num)', 'AdminController::editUser/$1', ['as' => 'admin.users.edit']);
        //$routes->post('users\delete/(:num)', 'AdminController::deleteUser/$1', ['as' => 'admin.users.delete']);
        //$routes->get('users/get/(:num)', 'AdminController::getUser/$1', ['as' => 'admin.users.get']);
        $routes->post('get-users', 'AdminController::getUser', ['as' => 'admin.users.get']);
        $routes->get('user/edit', 'AdminController::edit', ['as' => 'user.edit']);
        $routes->post('user/update', 'AdminController::update', ['as' => 'user.update']);
        $routes->post('user/delete', 'AdminController::delete', ['as' => 'user.delete']);
        $routes->get('profile', 'AdminController::profile', ['as' => 'profile']);
        $routes->get('logs', 'LogsController::index');
         $routes->get('change-password', 'AdminController::changePassword', ['as' => 'change_password']);
        $routes->post('change-password', 'AdminController::updatePassword');
        

    });
    $routes->group('products', ['filter' => 'cifilter:auth'], static function ($routes) {
    $routes->get('', 'ProductController::index', ['as' => 'products.index']); 
    $routes->get('add-product', 'ProductController::create', ['as' => 'products.create']);
    $routes->post('store', 'ProductController::store', ['as' => 'products.store']);
    $routes->get('getSubcategoriesByCategory/(:num)', 'ProductController::getSubcategoriesByCategory/$1');
    $routes->get('getSubcategories/(:num)', 'ProductController::getSubcategoriesByCategory/$1');

    $routes->get('categories', 'CategoryController::index');
    $routes->get('categories/create', 'CategoryController::create');
    $routes->post('categories/store', 'CategoryController::store');
    $routes->get('categories/edit/(:num)', 'CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'CategoryController::update/$1');
    $routes->post('categories/delete/(:num)', 'CategoryController::delete/$1');
    
});
$routes->group('categories', ['filter' => 'cifilter:auth'], static function ($routes) {
    
    $routes->get('', 'CategoryController::index');
    $routes->get('add-category', 'CategoryController::create');
    $routes->post('store', 'CategoryController::store');
    $routes->get('edit/(:any)', 'CategoryController::edit/$1');
    $routes->post('update/(:num)', 'CategoryController::update/$1');
    $routes->post('delete/(:num)', 'CategoryController::delete/$1');
    
});

$routes->group('subcategories', ['filter' => 'cifilter:auth'], static function ($routes) {

$routes->get('', 'SubcategoryController::index');
$routes->get('add-subcategory', 'SubcategoryController::create');
$routes->post('store', 'SubcategoryController::store');
$routes->get('edit/(:any)', 'SubcategoryController::edit/$1');
$routes->post('update/(:any)', 'SubcategoryController::update/$1');
$routes->get('delete/(:any)', 'SubcategoryController::delete/$1');

});
});


$routes->group('', static function ($routes) {
    $routes->group('', static function ($routes) {
        $routes->get('/', 'Home::index');
        $routes->get('cart', 'CartController::viewCart');
        // $routes->post('cart/add', 'CartController::addToCart');
        $routes->get('cart/add/(:num)', 'CartController::addToCart/$1');
        // $routes->get('/cart/remove/(:num)', 'CartController::removeFromCart/$1');
        $routes->post('cart/add/(:num)', 'CartController::addToCart/$1');
        $routes->post('cart/remove/(:segment)', 'CartController::removeFromCart/$1');
        $routes->post('cart/clear', 'CartController::clearCart');
        $routes->post('cart/update', 'CartController::update'); 
        $routes->get('cart/info', 'CartController::cartInfo');
        $routes->get('/checkout', 'CheckoutController::startCheckout');
        $routes->post('/checkout/process', 'CheckoutController::processOrder');
        $routes->get('/order/confirm/(:num)', 'CheckoutController::confirmOrder/$1'); 
        $routes->post('mpesa/initiate', 'MpesaController::initiatePayment');  // To initiate payment
        $routes->post('mpesa/callback', 'MpesaController::handleMpesaCallback');
        $routes->get('test', 'MpesaController::getAccessToken');

        // To handle callback
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
        $routes->get('details/(:any)', 'ProductController::details/$1');
         // Save new product
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
