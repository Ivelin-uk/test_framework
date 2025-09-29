<?php

namespace App\Controllers\Auth;

use Core\Controller;

class Auth extends Controller
{
    public function login()
    {
        $this->view->render('auth', 'login', $this->get_data());
    }

    public function register()
    {
        $this->view->render('auth', 'register', $this->get_data());
    }
}
