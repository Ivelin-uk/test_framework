<?php

namespace App\Controllers\User;

use Core\Controller;

class Products extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    
    public function list()
    {
        // Съвместимост с линка products/list – ползвай същия изглед като index
        return $this->view->render('products', 'list', $this->get_data());
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