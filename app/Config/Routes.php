<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/cart', 'CartController::viewCart');
$routes->post('cart/add', 'CartController::addToCart');
$routes->get('/cart/add/(:num)', 'CartController::addToCart/$1');
$routes->get('/cart/remove/(:num)', 'CartController::removeFromCart/$1');
$routes->post('cart/add/(:num)', 'CartController::addToCart/$1');


$routes->group('admin', static function ($routes) {
    $routes->group('products', static function ($routes) {
        $routes->get('', 'ProductController::index', ['as' => 'products.index']); // List products
        $routes->get('create', 'ProductController::create', ['as' => 'products.create']); // Show create form
        $routes->post('store', 'ProductController::store', ['as' => 'products.store']); // Save new product
        $routes->get('edit/(:num)', 'ProductController::edit/$1', ['as' => 'products.edit']); // Show edit form
        $routes->post('update/(:num)', 'ProductController::update/$1', ['as' => 'products.update']); // Update product
        $routes->delete('delete/(:num)', 'ProductController::delete/$1', ['as' => 'products.delete']); // Delete product

    });
    $routes->group('categories', static function ($routes) {
        $routes->get('', 'CategoryController::index', ['as' => 'categories.index']); // List categories
        $routes->get('create', 'CategoryController::create', ['as' => 'categories.create']); // Show create form
        $routes->post('store', 'CategoryController::store', ['as' => 'categories.store']); // Save new category
        $routes->get('edit/(:num)', 'CategoryController::edit/$1', ['as' => 'categories.edit']); // Show edit form
        $routes->post('update/(:num)', 'CategoryController::update/$1', ['as' => 'categories.update']); // Update category
        $routes->delete('delete/(:num)', 'CategoryController::delete/$1', ['as' => 'categories.delete']); // Delete category
    });

    
});
