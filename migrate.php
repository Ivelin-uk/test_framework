#!/usr/bin/env php
<?php

/**
 * Console команда за SQL миграции
 * 
 * Използване: php migrate.php [опция]
 * 
 * Опции:
 *   --tables     Изпълнява само таблиците
 *   --data       Изпълнява само данните  
 *   --all        Изпълнява всичко (по подразбиране)
 *   --status     Показва статуса на миграциите
 */

// Дефиниране на основни константи
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('CORE_PATH', BASE_PATH . '/core');

// Включване на автолоудъра
require_once BASE_PATH . '/core/Autoloader.php';
spl_autoload_register(['\Core\Autoloader', 'load']);

// Проверка дали се изпълнява от командния ред
if (php_sapi_name() !== 'cli') {
    die('Тази команда може да се изпълнява само от командния ред.');
}

try {
    $migration = new \Core\SqlMigration();
    
    // Получаване на аргументите
    $args = $argv ?? [];
    $option = $args[1] ?? '--all';
    
    switch ($option) {
        case '--tables':
            echo "📋 Създаване на таблици...\n";
            $results = $migration->runSqlFiles(BASE_PATH . '/sql/tables');
            printResults($results);
            break;
            
        case '--data':
            echo "📊 Вмъкване на данни...\n";
            $results = $migration->runSqlFiles(BASE_PATH . '/sql/data');
            printResults($results);
            break;
            
        case '--status':
            echo "📋 Статус на миграциите:\n\n";
            $executed = $migration->getExecutedMigrations();
            if (empty($executed)) {
                echo "Няма изпълнени миграции.\n";
            } else {
                foreach ($executed as $migration) {
                    echo "✅ {$migration['filename']} - {$migration['executed_at']}\n";
                }
            }
            break;
            
        case '--all':
        default:
            $migration->runAll();
            break;
    }
    
} catch (Exception $e) {
    echo "❌ Грешка: " . $e->getMessage() . "\n";
    exit(1);
}

/**
 * Помощна функция за отпечатване на резултатите
 */
function printResults($results) {
    foreach ($results as $result) {
        $icon = match($result['status']) {
            'success' => '✅',
            'skipped' => '⏭️', 
            'error' => '❌',
            default => '❓'
        };
        
        echo "{$icon} {$result['file']} - {$result['message']}\n";
    }
}

echo "\n🎉 Готово!\n";