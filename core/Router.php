<?php

namespace Core;

/**
 * Router клас за управление на URL маршрутите
 * 
 * Този клас отговаря за анализиране на URL-то и 
 * насочване към съответния контролер и метод.
 */
class Router
{
    private $routes = [];
    private $currentRoute = [];
    
    /**
     * Добавя GET маршрут
     * 
     * @param string $route URL шаблон
     * @param array $params Контролер и метод
     */
    public function get($route, $params = [])
    {
        $this->add($route, $params, 'GET');
    }
    
    /**
     * Добавя POST маршрут
     * 
     * @param string $route URL шаблон
     * @param array $params Контролер и метод
     */
    public function post($route, $params = [])
    {
        $this->add($route, $params, 'POST');
    }
    
    /**
     * Добавя маршрут
     * 
     * @param string $route URL шаблон
     * @param array $params Контролер и метод
     * @param string $method HTTP метод
     */
    private function add($route, $params, $method)
    {
        // Конвертиране на маршрута в regex
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        
        $this->routes[$method][$route] = $params;
    }
    
    /**
     * Намира съвпадение за дадения URL
     * 
     * @param string $url URL за проверка
     * @param string $method HTTP метод
     * @return bool
     */
    public function match($url, $method = 'GET')
    {
        if (!isset($this->routes[$method])) {
            return false;
        }
        
        foreach ($this->routes[$method] as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Извличане на параметрите от URL-то
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                
                $this->currentRoute = $params;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Връща текущия маршрут
     * 
     * @return array
     */
    public function getCurrentRoute()
    {
        return $this->currentRoute;
    }
    
    /**
     * Изпълнява намерения маршрут
     * 
     * @throws \Exception
     */
    public function dispatch()
    {
        if (empty($this->currentRoute)) {
            throw new \Exception('Няма намерен маршрут');
        }
        
        $controller = $this->currentRoute['controller'];
        $action = $this->currentRoute['action'] ?? 'index';
        
        // Добавяне на namespace към контролера
        $controller = 'App\\Controllers\\' . $controller;
        
        if (!class_exists($controller)) {
            throw new \Exception("Контролерът {$controller} не съществува");
        }
        
        $controllerObject = new $controller();
        
        if (!method_exists($controllerObject, $action)) {
            throw new \Exception("Методът {$action} не съществува в контролера {$controller}");
        }
        
        // Извикване на метода с параметрите от URL (без 'controller' и 'action')
        $args = $this->currentRoute;
        unset($args['controller'], $args['action']);
        call_user_func_array([$controllerObject, $action], array_values($args));
    }
}