<?php

namespace App\Controllers\Auth;

use Core\Controller;
use App\Models\User;

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

    /**
     * Обработка на регистрация (POST)
     */
    public function save()
    {
       
        if (!$this->isPost()) {
            return $this->redirect($this->view->url('auth/register'));
        }

        // Вземи всички POST полета като обект
        $input = $this->request->toObject();

        $errors = [];

        // Базови валидации
        if (empty($input->username)) {
            $errors['username'] = 'Потребителското име е задължително.';
        }
        if (empty($input->email) || !filter_var($input->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Въведете валиден имейл.';
        }
        if (empty($input->password) || strlen($input->password) < 6) {
            $errors['password'] = 'Паролата трябва да е поне 6 символа.';
        }
        if (!isset($input->password_confirm) || $input->password !== $input->password_confirm) {
            $errors['password_confirm'] = 'Паролите не съвпадат.';
        }

        // Проверка за дубликати
        $this->set_model('user');
        if (empty($errors)) {
            if ($this->model->findOne(['username' => $input->username])) {
                $errors['username'] = 'Това потребителско име е заето.';
            }
            if ($this->model->findOne(['email' => $input->email])) {
                $errors['email'] = 'Този имейл вече е регистриран.';
            }
        }

        if (!empty($errors)) {
            // Върни формата с грешки и стар вход (без паролите)
            return $this->view->render('auth', 'register', [
                'errors' => $errors,
                'old' => [
                    'username' => $input->username ?? '',
                    'email' => $input->email ?? '',
                    'first_name' => $input->first_name ?? '',
                    'last_name' => $input->last_name ?? '',
                ],
            ]);
        }

        // Създай потребителя
        try {
            $hash = password_hash($input->password, PASSWORD_DEFAULT);
            $this->model->create([
                'username' => $input->username,
                'email' => $input->email,
                'password' => $hash,
                'first_name' => $input->first_name ?? null,
                'last_name' => $input->last_name ?? null,
            ]);
        } catch (\PDOException $e) {
            return $this->view->render('auth', 'register', [
                'errors' => ['general' => 'Възникна грешка при записа. Опитайте отново.'],
                'old' => [
                    'username' => $input->username ?? '',
                    'email' => $input->email ?? '',
                    'first_name' => $input->first_name ?? '',
                    'last_name' => $input->last_name ?? '',
                ],
            ]);
        }

        // Успех – пренасочване към форма с флаг за успех
        return $this->redirect($this->view->url('auth/register?success=1'));
    }
}
