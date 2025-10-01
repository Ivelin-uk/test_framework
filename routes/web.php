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

// Продукти
$router->get('/products/list', [
    'controller' => 'User\\Products',
    'action' => 'list'
]);


$router->get('/products/discount_list', [
    'controller' => 'User\\Products',
    'action' => 'discount_list'
]);