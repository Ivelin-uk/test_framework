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

$router->get('/users/show', [
    'controller' => 'UserController',
    'action' => 'show'
]);

// Страница за регистрация
$router->get('/users/register', [
    'controller' => 'UserController',
    'action' => 'register'
]);

// Обработка на регистрационната форма (POST)
$router->post('/users/save', [
    'controller' => 'UserController',
    'action' => 'save'
]);