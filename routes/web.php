<?php
/**
 * Дефиниране на уеб маршрути
 */

$router = $app->getRouter();

// Логин
$router->get('/auth/login', [
    'controller' => 'Auth\\Auth', 
    'action' => 'login'
]);

$router->get('/auth/register', [
    'controller' => 'Auth\\Auth', 
    'action' => 'register'
]);

// Продукти (GET) – работи с навигацията
$router->get('/products/list', [
    'controller' => 'User\\Products',
    'action' => 'list'
]);
