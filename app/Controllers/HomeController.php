<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view->render('home/index', ['title' => 'Начало']);
    }
}
