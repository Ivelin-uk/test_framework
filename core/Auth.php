<?php

namespace Core;

use App\Models\User;

class Auth
{
    /**
     * Влизане на потребител в системата
     */
    public static function login(object $user): void
    {
        Session::regenerate();
        Session::set('user_id', $user->id);
        Session::set('username', $user->username);
    }

    /**
     * Излизане от системата
     */
    public static function logout(): void
    {
        Session::remove('user_id');
        Session::remove('username');
        Session::destroy();
    }

    /**
     * Проверява дали потребител е влязъл
     */
    public static function check(): bool
    {
        return Session::has('user_id');
    }

    /**
     * Връща ID на текущия потребител
     */
    public static function id(): ?int
    {
        return Session::get('user_id');
    }

    /**
     * Връща пълните данни на текущия потребител
     */
    public static function user(): ?object
    {
        if (!self::check()) {
            return null;
        }

        $userModel = new User();
        $users = $userModel->find(['id' => self::id()]);
        return $users[0] ?? null;
    }
}