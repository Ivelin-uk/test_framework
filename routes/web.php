<?php
/**
 * Дефиниране на уеб маршрути
 */

$router = $app->getRouter();

// Начална страница
$router->get('/users/products', [
    'controller' => 'UserController',
    'action' => 'products'
]);