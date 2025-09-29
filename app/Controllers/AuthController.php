<?php

namespace App\Controllers;

use Core\Controller;

class AuthController extends Controller
{
    public function login()
    {
        $this->view->render('auth/login', ['title' => 'Вход']);
    }
}
