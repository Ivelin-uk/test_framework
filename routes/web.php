<?php
/**
 * Дефиниране на уеб маршрути
 */

$router = $app->getRouter();

// Начало
$router->get('/', [
    'controller' => 'Home\\Home', 
    'action' => 'index'
]);

// Логин
$router->get('/auth/login', [
    'controller' => 'Auth\\Auth', 
    'action' => 'login'
]);

$router->post('/auth/login', [
    'controller' => 'Auth\\Auth', 
    'action' => 'login'
]);

// Излизане
$router->get('/auth/logout', [
    'controller' => 'Auth\\Auth', 
    'action' => 'logout'
]);

// Регистрация
$router->get('/auth/register', [
    'controller' => 'Auth\\Auth', 
    'action' => 'register'
]);

$router->post('/auth/register', [
    'controller' => 'Auth\\Auth',
    'action' => 'save'
]);

// Магазин
$router->get('/shop', [
    'controller' => 'Shop\\Shop',
    'action' => 'index'
]);

$router->get('/shop/category/{id}', [
    'controller' => 'Shop\\Shop',
    'action' => 'category'
]);

$router->get('/shop/product/{id}', [
    'controller' => 'Shop\\Shop',
    'action' => 'product'
]);

$router->get('/shop/search', [
    'controller' => 'Shop\\Shop',
    'action' => 'search'
]);

$router->get('/shop/featured', [
    'controller' => 'Shop\\Shop',
    'action' => 'featured'
]);

// Продукти (стари routes)
$router->get('/products/list', [
    'controller' => 'User\\Products',
    'action' => 'list'
]);


$router->get('/products/discount_list', [
    'controller' => 'User\\Products',
    'action' => 'discount_list'
]);