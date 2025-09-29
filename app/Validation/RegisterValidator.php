<?php

namespace App\Validation;

use App\Models\User;

class RegisterValidator
{
    private User $users;

    public function __construct()
    {
        $this->users = new User();
    }

    /**
     * Валидира входа и връща масив от грешки (празен ако няма)
     * @param object $input stdClass с полета от формата
     * @return array
     */
    public function validate(object $input): array
    {
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

        // Уникалност (ако базови са минали)
        if (empty($errors)) {
            if ($this->users->findOne(['username' => $input->username])) {
                $errors['username'] = 'Това потребителско име е заето.';
            }
            if ($this->users->findOne(['email' => $input->email])) {
                $errors['email'] = 'Този имейл вече е регистриран.';
            }
        }

        return $errors;
    }
}
