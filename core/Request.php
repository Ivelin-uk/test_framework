<?php

namespace Core;

/**
 * Request клас – капсулира достъпа до входните данни
 */
class Request
{
    /**
     * Връща всички POST данни или конкретен ключ (с default)
     */
    public function post($key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    /**
     * Връща всички GET данни или конкретен ключ (с default)
     */
    public function get($key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    /**
     * Връща комбиниран вход (GET предпочита POST ако има същия ключ)
     */
    public function input(string $key = null, $default = null)
    {
        $data = array_merge($_GET ?? [], $_POST ?? []);
        if ($key === null) {
            return $data;
        }
        return $data[$key] ?? $default;
    }

    /**
     * Взима само избрани ключове от масив/суперглобал
     */
    public function only(array $keys, array $source = null): array
    {
        $src = $source ?? $this->input();
        $out = [];
        foreach ($keys as $k) {
            if (array_key_exists($k, $src)) {
                $out[$k] = $src[$k];
            }
        }
        return $out;
    }

    /**
     * Връща избрани или всички входни ключове като stdClass.
     * Ако $keys е null – взима всички от избрания източник ($source: post|get|input).
     * По подразбиране: взима всички POST полета и тримва стринговете (без password полета).
     */
    public function toObject(array $keys = null, bool $trimStrings = true, string $source = 'post'): \stdClass
    {
        $src = $source === 'get' ? $this->get() : ($source === 'input' ? $this->input() : $this->post());
        $arr = $keys === null ? $src : $this->only($keys, $src);
        foreach ($arr as $k => $v) {
            if ($trimStrings && is_string($v) && !in_array($k, ['password', 'password_confirm'], true)) {
                $arr[$k] = trim($v);
            }
        }
        return (object) $arr;
    }

    public function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    public function isGet(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET';
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
