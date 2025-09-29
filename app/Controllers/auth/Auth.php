<?php

namespace App\Controllers\Auth;

use Core\Controller;
use App\Models\User;
use App\Validation\RegisterValidator;

class Auth extends Controller
{
    public function login()
    {
        $this->view->render('auth', 'login', $this->get_data());
    }

    public function register()
    {
        $success = $this->get('success');
        $this->view->render('auth', 'register', ['success' => $success]);
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

        // Валидация чрез отделен клас
        $validator = new RegisterValidator();
        $errors = $validator->validate($input);

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
            $this->set_model('user');
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
