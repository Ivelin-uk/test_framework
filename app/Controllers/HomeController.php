<?php

namespace App\Controllers;

use Core\Controller;

/**
 * Начален контролер
 * 
 * Контролер за основните страници на сайта
 */
class HomeController extends Controller
{
    /**
     * Начална страница
     */
    public function index()
    {
        $data = [
            'title' => 'Добре дошли в Моят PHP Framework',
            'message' => 'Това е примерна начална страница',
            'features' => [
                'MVC архитектура',
                'Маршрутизация на URL-и',
                'Шаблонна система',
                'Работа с бази данни',
                'Автоматично зареждане на класове'
            ]
        ];
        
        $this->render('home/index', $data);
    }
    
    /**
     * За страница
     */
    public function about()
    {
        $data = [
            'title' => 'За Моят PHP Framework',
            'version' => '1.0.0',
            'description' => 'Лек и бърз PHP framework, построен на MVC архитектура.'
        ];
        
        $this->render('home/about', $data);
    }
    
    /**
     * Контакти страница
     */
    public function contact()
    {
        $data = [
            'title' => 'Свържете се с нас',
            'email' => 'contact@example.com',
            'phone' => '+359 888 123 456'
        ];
        
        $this->render('home/contact', $data);
    }
    
    /**
     * Обработка на контактна форма
     */
    public function contactSubmit()
    {
        if (!$this->isPost()) {
            $this->redirect('/contact');
            return;
        }
        
        $name = $this->post('name');
        $email = $this->post('email');
        $message = $this->post('message');
        
        // Основна валидация
        if (empty($name) || empty($email) || empty($message)) {
            $this->json([
                'success' => false,
                'message' => 'Всички полета са задължителни!'
            ], 400);
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json([
                'success' => false,
                'message' => 'Невалиден имейл адрес!'
            ], 400);
            return;
        }
        
        // Тук може да се запише в база данни или изпрати имейл
        // За демо цели просто връщаме успех
        
        if ($this->isAjax()) {
            $this->json([
                'success' => true,
                'message' => 'Съобщението ви беше изпратено успешно!'
            ]);
        } else {
            // Пренасочване при не-AJAX заявка
            $this->redirect('/contact?success=1');
        }
    }
}