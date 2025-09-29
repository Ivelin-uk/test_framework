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
        echo "<pre>";
        var_dump('in');
        echo "</pre>";
        exit();
        $this->render('products/index');
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
        
        var_dump($products);
        echo "</pre>";

    }

}