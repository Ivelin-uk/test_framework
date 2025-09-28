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
        // Конвертиране на namespace в път до файла
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        
        // Опит за зареждане от различни директории
        $paths = [
            BASE_PATH . DIRECTORY_SEPARATOR . $fileName,
            CORE_PATH . DIRECTORY_SEPARATOR . $fileName,
            APP_PATH . DIRECTORY_SEPARATOR . $fileName,
        ];
        
        foreach ($paths as $path) {
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
        }
        
        return false;
    }
}