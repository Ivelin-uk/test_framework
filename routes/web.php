<?php

/**
 * Дефиниране на уеб маршрути
 * 
 * Тук се дефинират всички HTTP маршрути за приложението.
 * Маршрутите се обработват от Router класа.
 */

// Достъп до router инстанцията
$router = $app->getRouter();

// Начална страница
$router->get('/', [
    'controller' => 'HomeController',
    'action' => 'index'
]);

// За страница
$router->get('/about', [
    'controller' => 'HomeController', 
    'action' => 'about'
]);

// Контакти
$router->get('/contact', [
    'controller' => 'HomeController',
    'action' => 'contact'
]);

// POST заявка за контакти
$router->post('/contact', [
    'controller' => 'HomeController',
    'action' => 'contactSubmit'
]);

// Потребители - примерни REST маршрути
$router->get('/users', [
    'controller' => 'UserController',
    'action' => 'index'
]);

$router->get('/users/{id}', [
    'controller' => 'UserController',
    'action' => 'show'
]);

$router->post('/users', [
    'controller' => 'UserController',
    'action' => 'store'
]);

// API маршрути
$router->get('/api/users', [
    'controller' => 'Api\\UserController',
    'action' => 'index'
]);

$router->get('/api/users/{id}', [
    'controller' => 'Api\\UserController',
    'action' => 'show'
]);