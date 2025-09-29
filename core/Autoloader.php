<?php

namespace Core;

/**
 * Автолоудър за автоматично зареждане на класове
 * 
 * Този клас отговаря за автоматичното зареждане на файлове
 * на базата на namespace-а и името на класа.
 */
class Autoloader
{
    /**
     * Зарежда клас на базата на неговото име
     * 
     * @param string $className Пълното име на класа с namespace
     * @return bool
     */
    public static function load($className)
    {
        // PSR-4 подобно картографиране: Core -> CORE_PATH, App -> APP_PATH
        $className = ltrim($className, '\\');
        $parts = explode('\\', $className);
        $top = array_shift($parts);
        $relative = implode(DIRECTORY_SEPARATOR, $parts) . '.php';

        $candidates = [];
        if ($top === 'Core') {
            $candidates[] = CORE_PATH . DIRECTORY_SEPARATOR . $relative;
        } elseif ($top === 'App') {
            $candidates[] = APP_PATH . DIRECTORY_SEPARATOR . $relative;
        }
        // Фолбек: от корена
        $candidates[] = BASE_PATH . DIRECTORY_SEPARATOR . $top . DIRECTORY_SEPARATOR . $relative;

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
        }

        return false;
    }
}