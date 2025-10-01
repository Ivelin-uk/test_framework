<?php

namespace App\Controllers\Auth;

use Core\Controller;
use App\Models\User;
use App\Validation\RegisterValidator;



class Auth extends Controller
{
    public function login()
    {
        if ($this->isPost()) {
            // Обработка на логин POST
            $input = $this->request->toObject();
            
            // Валидации
            if (empty($input->email) || empty($input->password)) {
                \Core\Flash::set('status', 'Моля въведете имейл и парола.', 'danger');
                return $this->view->render('auth', 'login', []);
            }
            
            // Намери потребителя
            $this->set_model('user');
            $user = $this->model->findOne(['email' => $input->email]);
            
            if (!$user || !password_verify($input->password, $user->password)) {
                \Core\Flash::set('status', 'Грешен имейл или парола.', 'danger');
                return $this->view->render('auth', 'login', ['old' => ['email' => $input->email]]);
            }
            
            // Успешен логин
            \Core\Auth::login($user);
            \Core\Flash::set('status', 'Добре дошли, ' . $user->username . '!', 'success');
            return $this->redirect($this->view->url('products/list'));
        }
        
        // GET заявка - покажи формата
        $this->view->render('auth', 'login', $this->get_data());
    }

    public function logout()
    {
        \Core\Auth::logout();
        \Core\Flash::set('status', 'Излязохте успешно от системата.', 'info');
        return $this->redirect($this->view->url('auth/login'));
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
            $userId = $this->model->create([
                'username' => $input->username,
                'email' => $input->email,
                'password' => $hash,
                'first_name' => $input->first_name ?? null,
                'last_name' => $input->last_name ?? null,
            ]);
            
            // Успешно създаване - пренасочи към логин страницата
            \Core\Flash::set('status', 'Акаунтът е създаден успешно! Моля влезте с вашите данни.', 'success');
            return $this->redirect($this->view->url('auth/login'));
            
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

        // Fallback успех
        \Core\Flash::set('status', 'Акаунтът е създаден успешно! Моля влезте с вашите данни.', 'success');
        return $this->redirect($this->view->url('auth/login'));
    }
}
