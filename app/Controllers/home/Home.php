<?php

namespace App\Controllers\Home;

use Core\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->view->render('home', 'index', $this->get_data());
    }
}
