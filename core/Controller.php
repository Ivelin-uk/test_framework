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
    /** @var \Core\Model|null */
    protected $model;
    
    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Зарежда и сетва модел по име или FQCN
     * Примери:
     *  - $this->set_model('user') => App\Models\User
     *  - $this->set_model('product') => App\Models\Product
     *  - $this->set_model(App\Models\User::class)
     *  - $this->set_model(new App\Models\User())
     * Връща инстанцията на модела и я записва в $this->model
     *
     * @param string|object $model
     * @return \Core\Model
     */
    protected function set_model($model)
    {
        if (is_object($model)) {
            if ($model instanceof Model) {
                $this->model = $model;
                return $this->model;
            }
            throw new \InvalidArgumentException('Предаденият обект не е валиден модел.');
        }

        if (!is_string($model) || $model === '') {
            throw new \InvalidArgumentException('Моделът трябва да е име на клас или низ.');
        }

        // Ако е FQCN – използвай директно, иначе конструирай от App\Models
        $class = strpos($model, '\\') !== false
            ? $model
            : 'App\\Models\\' . self::studly($model);

        if (!class_exists($class)) {
            throw new \RuntimeException("Моделният клас {$class} не съществува.");
        }

        $instance = new $class();
        if (!($instance instanceof Model)) {
            throw new \RuntimeException("Класът {$class} не наследява Core\\Model.");
        }

        $this->model = $instance;
        return $this->model;
    }

    /**
     * Връща текущия модел
     * @return \Core\Model|null
     */
    protected function get_model()
    {
        return $this->model ?? null;
    }

    /**
     * Превръща низ към StudlyCase (user_profile -> UserProfile)
     */
    private static function studly($value)
    {
        $value = str_replace(['-', '_'], ' ', strtolower($value));
        $value = ucwords($value);
        return str_replace(' ', '', $value);
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