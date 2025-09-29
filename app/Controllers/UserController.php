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
        $this->view->render('auth', 'register', []);
    }

    public function save()
    {
        echo "<pre>";
        var_dump("in");
        echo "</pre>";
        exit();
        // Обработка на регистрационната форма
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