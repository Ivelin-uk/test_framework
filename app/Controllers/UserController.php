<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

/**
 * Потребителски контролер
 */
class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function products()
    {
    // Зареждане на потребител и продукти и рендер на изглед
        var_dump('in');
        echo "</pre>";
        exit();
        $this->render('products/index');
    }

    /**
     * Показва страница за регистрация (само форма)
     */
    public function register()
    {
        $this->view->render('auth', 'register', $this->get_data());
    }

    public function save()
    {
        // Обработка на регистрационната форма
        if (!$this->isPost()) {
            return $this->redirect($this->view->url('users/register'));
        }
        // Събиране на всички POST данни като обект автоматично
        $input = $this->request->toObject();

        echo "<pre>";
        var_dump($input);
        echo "</pre>";
        exit();

        // ...тук продължава обработката: валидация, създаване на потребител, redirect/рендер

    }

    /**
     * Показва конкретен потребител
     */
    public function show($id = null)
    {
        echo "<pre>";

        $this->set_model('user');
        $rows = $this->model->find(['id' => 1]);
        $user = $rows[0] ?? null;

        var_dump($user);

        $this->set_model('product');
        $products = $this->model->all();
        

        $this->set_data('user', $user);
        $this->set_data('products', $products);
        $this->view->render('users', 'show', $this->get_data());

         echo "<pre>";

    }

}