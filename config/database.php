<?php

/**
 * Конфигурация за база данни
 */

return [
    // Тип на драйвера за база данни
    'driver' => 'mysql',
    
    // Хост на базата данни
    'host' => 'localhost',
    
    // Порт
    'port' => 3306,
    
    // Име на базата данни
    'database' => 'my_php_framework',
    
    // Потребителско име
    'username' => 'root',
    
    // Парола
    'password' => '',
    
    // Кодировка
    'charset' => 'utf8mb4',
    
    // Collation
    'collation' => 'utf8mb4_unicode_ci',
    
    // Префикс на таблиците
    'prefix' => '',
    
    // PDO опции
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ],
];