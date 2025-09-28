<?php

namespace App\Models;

use Core\Model;

/**
 * Потребителски модел
 * 
 * Модел за работа с потребители в базата данни
 */
class User extends Model
{
    protected $table = 'users';
    
    /**
     * Намира потребител по имейл
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail($email)
    {
        $users = $this->findAll(['email' => $email]);
        return !empty($users) ? $users[0] : null;
    }
    
    /**
     * Получава активните потребители
     * 
     * @return array
     */
    public function getActiveUsers()
    {
        return $this->findAll(['status' => 'active'], 'name ASC');
    }
    
    /**
     * Създава нов потребител с валидация
     * 
     * @param array $data
     * @return int
     * @throws \Exception
     */
    public function createUser($data)
    {
        // Проверка дали имейлът вече съществува
        if ($this->findByEmail($data['email'])) {
            throw new \Exception('Потребител с този имейл вече съществува');
        }
        
        // Добавяне на времена
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        // Ако няма статус, поставяме активен
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }
        
        return $this->create($data);
    }
    
    /**
     * Обновява потребител
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateUser($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }
    
    /**
     * Получава потребители с пагинация
     * 
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function getPaginatedUsers($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Броят на всички потребители
     * 
     * @return int
     */
    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $result = $this->query($sql);
        return $result[0]['count'] ?? 0;
    }
}