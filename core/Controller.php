<?php

namespace Core;

/**
 * Базов контролер клас
 * 
 * Всички контролери трябва да наследяват този клас
 * за да получат основната функционалност
 */
abstract class Controller
{
    protected $view;
    
    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->view = new View();
    }
    
    /**
     * Рендерира изглед
     * 
     * @param string $template Име на шаблона
     * @param array $data Данни за предаване към изгледа
     */
    protected function render($template, $data = [])
    {
        $this->view->render($template, $data);
    }
    
    /**
     * Рендерира JSON отговор
     * 
     * @param array $data Данни за конвертиране в JSON
     * @param int $httpCode HTTP статус код
     */
    protected function json($data, $httpCode = 200)
    {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Пренасочва към друг URL
     * 
     * @param string $url URL за пренасочване
     */
    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Получава стойност от POST заявката
     * 
     * @param string $key Ключ
     * @param mixed $default Стойност по подразбиране
     * @return mixed
     */
    protected function post($key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Получава стойност от GET заявката
     * 
     * @param string $key Ключ
     * @param mixed $default Стойност по подразбиране
     * @return mixed
     */
    protected function get($key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Проверява дали заявката е POST
     * 
     * @return bool
     */
    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Проверява дали заявката е GET
     * 
     * @return bool
     */
    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    /**
     * Проверява дали заявката е AJAX
     * 
     * @return bool
     */
    protected function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}