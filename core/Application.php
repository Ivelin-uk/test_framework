<?php

namespace Core;

/**
 * Основно приложение клас
 * 
 * Този клас управлява целия жизнен цикъл на приложението
 */
class Application
{
    private $config;
    private $router;
    
    /**
     * Конструктор
     * 
     * @param array $config Конфигурация на приложението
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->router = new Router();
        
        // Зареждане на маршрутите
        $this->loadRoutes();
    }
    
    /**
     * Стартира приложението
     */
    public function run()
    {
        try {
            // Получаване на текущия URL
            $url = $this->getUrl();
            $method = $_SERVER['REQUEST_METHOD'];
            
            // Намиране на маршрут
            if ($this->router->match($url, $method)) {
                $this->router->dispatch();
            } else {
                $this->show404();
            }
            
        } catch (\Exception $e) {
            $this->showError($e);
        }
    }
    
    /**
     * Извлича URL от заявката
     * 
     * @return string
     */
    private function getUrl()
    {
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Премахване на query параметрите
        if (($pos = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $pos);
        }
        
        // Премахване на базовия път /test/public
        $basePath = '/test/public';
        if (strpos($url, $basePath) === 0) {
            $url = substr($url, strlen($basePath));
            if (empty($url)) {
                $url = '/';
            }
        }
        
        return $url;
    }
    
    /**
     * Зарежда маршрутите от файла routes/web.php
     */
    private function loadRoutes()
    {
        $app = $this; // Правим $app достъпна в routes файла
        $routesFile = BASE_PATH . '/routes/web.php';
        if (file_exists($routesFile)) {
            require_once $routesFile;
        }
    }
    
    /**
     * Показва 404 грешка
     */
    private function show404()
    {
        http_response_code(404);
        echo '<h1>404 - Страницата не е намерена</h1>';
        echo '<p>Търсената от вас страница не съществува.</p>';
    }
    
    /**
     * Показва грешка
     * 
     * @param \Exception $e
     */
    private function showError(\Exception $e)
    {
        http_response_code(500);
        
        if (isset($this->config['debug']) && $this->config['debug']) {
            echo '<h1>Грешка в приложението</h1>';
            echo '<p><strong>Съобщение:</strong> ' . $e->getMessage() . '</p>';
            echo '<p><strong>Файл:</strong> ' . $e->getFile() . '</p>';
            echo '<p><strong>Ред:</strong> ' . $e->getLine() . '</p>';
            echo '<h3>Stack Trace:</h3>';
            echo '<pre>' . $e->getTraceAsString() . '</pre>';
        } else {
            echo '<h1>Възникна грешка</h1>';
            echo '<p>Съжаляваме, възникна неочаквана грешка. Моля, опитайте отново.</p>';
        }
    }
    
    /**
     * Връща инстанция на рутера
     * 
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }
}