<?php

namespace Core;

class Flash
{
    /**
     * Добавя flash съобщение
     */
    public static function set(string $key, string $message, string $type = 'info'): void
    {
        Session::start();
        
        if (!Session::has('flash_messages')) {
            Session::set('flash_messages', []);
        }
        
        $messages = Session::get('flash_messages');
        $messages[$key][] = [
            'message' => $message,
            'type' => $type
        ];
        
        Session::set('flash_messages', $messages);
    }
    
    /**
     * Взема flash съобщенията за даден ключ
     */
    public static function get(string $key): array
    {
        Session::start();
        
        if (!Session::has('flash_messages')) {
            return [];
        }
        
        $messages = Session::get('flash_messages');
        $result = $messages[$key] ?? [];
        
        // Премахваме съобщенията след като ги вземем
        unset($messages[$key]);
        Session::set('flash_messages', $messages);
        
        return $result;
    }
    
    /**
     * Проверява дали има flash съобщения за даден ключ
     */
    public static function has(string $key): bool
    {
        Session::start();
        
        if (!Session::has('flash_messages')) {
            return false;
        }
        
        $messages = Session::get('flash_messages');
        return isset($messages[$key]) && !empty($messages[$key]);
    }
    
    /**
     * Взема всички flash съобщения
     */
    public static function all(): array
    {
        Session::start();
        
        if (!Session::has('flash_messages')) {
            return [];
        }
        
        $messages = Session::get('flash_messages');
        Session::set('flash_messages', []);
        
        return $messages;
    }
}