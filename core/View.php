<?php

namespace Core;

/**
 * View клас за рендериране на изгледи
 * 
 * Този клас отговаря за зареждането и рендерирането на
 * HTML шаблони с данни.
 */
class View
{
    private $viewsPath;
    private $data = [];
    private $layout = 'layouts/main';
    
    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->viewsPath = VIEW_PATH;
    }
    
    /**
     * Рендерира изглед
     * 
     * @param string $template Име на шаблона
     * @param array $data Данни за предаване към изгледа
     */
    public function render($template, $data = [])
    {
        // Поддръжка на стария подпис: render('dir','view', data)
        if (is_string($template) && is_string($data)) {
            $template = trim($template, '.\/') . '/' . trim($data, '.\/');
            $data = func_num_args() >= 3 ? func_get_arg(2) : [];
        }

        $this->data = array_merge($this->data, is_array($data) ? $data : []);

        $templatePath = $this->getTemplatePath($template);
        
        if (!file_exists($templatePath)) {
            throw new \Exception("Изгледът '{$template}' не съществува в {$templatePath}");
        }
        
        // Извличане на променливите в локалния scope
        extract($this->data);
        
        // Започване на output buffering
        ob_start();
        
        // Включване на шаблона
        include $templatePath;
        
        // Получаване на съдържанието на изгледа
        $content = ob_get_clean();

        // Ако има зададен layout – включваме го и подаваме $content вътре
        if (!empty($this->layout)) {
            $layoutPath = $this->getTemplatePath($this->layout);
            if (!file_exists($layoutPath)) {
                throw new \Exception("Layout '{$this->layout}' не съществува в {$layoutPath}");
            }

            // $content и всички извлечени променливи са налични тук
            include $layoutPath;
        } else {
            echo $content;
        }
    }
    
    /**
     * Рендерира изглед и връща резултата като string
     * 
     * @param string $template Име на шаблона
     * @param array $data Данни за предаване към изгледа
     * @return string
     */
    public function renderToString($template, $data = [])
    {
        $this->data = array_merge($this->data, $data);
        
        $templatePath = $this->getTemplatePath($template);
        
        if (!file_exists($templatePath)) {
            throw new \Exception("Изгледът '{$template}' не съществува в {$templatePath}");
        }
        
        // Извличане на променливите в локалния scope
        extract($this->data);
        
        // Започване на output buffering
        ob_start();
        
        // Включване на шаблона
        include $templatePath;
        
        // Получаване на съдържанието
        $content = ob_get_clean();
        return $content;
    }

    /**
     * Задава или изключва layout. Пример: setLayout('layouts/main') или setLayout(null) за изключване
     */
    public function setLayout(?string $layout): void
    {
        $this->layout = $layout;
    }
    
    /**
     * Добавя данни към изгледа
     * 
     * @param string|array $key Ключ или масив с данни
     * @param mixed $value Стойност (ако $key е string)
     */
    public function assign($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
    }
    
    /**
     * Включва частичен изглед (partial)
     * 
     * @param string $partial Име на частичния изглед
     * @param array $data Данни за частичния изглед
     * @return string
     */
    public function partial($partial, $data = [])
    {
        return $this->renderToString($partial, $data);
    }
    
    /**
     * Escape на HTML символи
     * 
     * @param string $value Стойност за escape
     * @return string
     */
    public function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Генерира URL
     * 
     * @param string $path Път
     * @return string
     */
    public function url($path = '')
    {
        $baseUrl = $this->getBaseUrl();
        return $baseUrl . '/' . ltrim($path, '/');
    }
    
    /**
     * Получава базовия URL
     * 
     * @return string
     */
    private function getBaseUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['SCRIPT_NAME']);
        
        return $protocol . '://' . $host . rtrim($path, '/');
    }
    
    /**
     * Получава пълния път до шаблона
     * 
     * @param string $template Име на шаблона
     * @return string
     */
    private function getTemplatePath($template)
    {
        // Замяна на точки с директории
        $template = str_replace('.', DIRECTORY_SEPARATOR, $template);
        
        // Добавяне на .php разширение ако липсва
        if (!pathinfo($template, PATHINFO_EXTENSION)) {
            $template .= '.php';
        }
        
        return $this->viewsPath . DIRECTORY_SEPARATOR . $template;
    }
}