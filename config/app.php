<?php

/**
 * Основна конфигурация на приложението
 */

return [
    // Режим на дебъгване
    'debug' => true,
    
    // Име на приложението
    'app_name' => 'Моят PHP Framework',
    
    // Версия на приложението
    'version' => '1.0.0',
    
    // Часова зона
    'timezone' => 'Europe/Sofia',
    
    // Език по подразбиране
    'locale' => 'bg',
    
    // Кодировка
    'charset' => 'UTF-8',
    
    // Настройки за сесията
    'session' => [
        'name' => 'my_framework_session',
        'lifetime' => 7200, // 2 часа
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => true,
    ],
    
    // Настройки за cookies
    'cookie' => [
        'prefix' => 'mf_',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ],
    
    // Лимити
    'limits' => [
        'memory' => '256M',
        'execution_time' => 30,
    ],
];