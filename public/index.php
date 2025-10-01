<?php

/**
 * My PHP Framework - Входна точка на приложението
 */

// Обработка на статични файлове
$requestUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'] ?? '';

// Ако заявката е за статичен файл, върни го директно
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/i', $path)) {
    $filePath = __DIR__ . $path;
    if (file_exists($filePath) && is_file($filePath)) {
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'ico' => 'image/x-icon',
            'svg' => 'image/svg+xml',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject'
        ];
        
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeType = $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
        
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        http_response_code(404);
        exit('File not found');
    }
}

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
