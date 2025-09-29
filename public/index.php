<?php

/**
 * My PHP Framework - Входна точка на приложението
 */

// Временно дебъгване
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Дефиниране на основни константи
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('CORE_PATH', BASE_PATH . '/core');
define('VIEW_PATH', APP_PATH . '/Views');

// Включване на автолоудъра
require_once BASE_PATH . '/core/Autoloader.php';

// Регистриране на автолоудъра
spl_autoload_register(['\Core\Autoloader', 'load']);

try {
    // Зареждане на конфигурацията
    $config = require CONFIG_PATH . '/app.php';
    
    // Създаване и стартиrane на приложението
    $app = new \Core\Application($config);
    $app->run();
    
} catch (Exception $e) {
    // Обработка на грешки
    error_log($e->getMessage());
    
    if (isset($config['debug']) && $config['debug']) {
        echo '<h1>Грешка в приложението</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        echo '<h1>Съжаляваме, възникна грешка</h1>';
        echo '<p>Моля, опитайте отново по-късно.</p>';
    }
}
