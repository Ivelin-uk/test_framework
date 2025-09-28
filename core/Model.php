<?php

namespace Core;

/**
 * Базов модел клас за работа с бази данни
 * 
 * Всички модели трябва да наследяват този клас
 * за да получат основната функционалност за работа с БД
 */
abstract class Model
{
    protected static $connection;
    protected $table;
    protected $primaryKey = 'id';
    
    /**
     * Създава връзка към базата данни
     * 
     * @return \PDO
     */
    protected static function getConnection()
    {
        if (self::$connection === null) {
            $config = require CONFIG_PATH . '/database.php';
            
            $dsn = sprintf(
                '%s:host=%s;dbname=%s;charset=%s',
                $config['driver'],
                $config['host'],
                $config['database'],
                $config['charset']
            );
            
            try {
                self::$connection = new \PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (\PDOException $e) {
                throw new \Exception('Грешка при свързване с базата данни: ' . $e->getMessage());
            }
        }
        
        return self::$connection;
    }
    
    /**
     * Намира записи по ID
     * 
     * @param int $id
     * @return array|null
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
    
    /**
     * Намира всички записи
     * 
     * @param array $conditions Условия за търсене
     * @param string $orderBy Сортиране
     * @param int $limit Лимит
     * @return array
     */
    public function findAll($conditions = [], $orderBy = null, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Записва нови данни
     * 
     * @param array $data
     * @return int Последно вмъкнато ID
     */
    public function create($data)
    {
        $fields = array_keys($data);
        $values = ':' . implode(', :', $fields);
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES ({$values})";
        
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($data);
        
        return self::getConnection()->lastInsertId();
    }
    
    /**
     * Обновява запис
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        $setParts = [];
        foreach (array_keys($data) as $field) {
            $setParts[] = "{$field} = :{$field}";
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts) . " WHERE {$this->primaryKey} = :id";
        
        $data['id'] = $id;
        $stmt = self::getConnection()->prepare($sql);
        
        return $stmt->execute($data);
    }
    
    /**
     * Изтрива запис
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Изпълнява заявка и връща резултата
     * 
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function query($sql, $params = [])
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Започва транзакция
     */
    public static function beginTransaction()
    {
        self::getConnection()->beginTransaction();
    }
    
    /**
     * Потвърждава транзакцията
     */
    public static function commit()
    {
        self::getConnection()->commit();
    }
    
    /**
     * Отменя транзакцията
     */
    public static function rollback()
    {
        self::getConnection()->rollback();
    }
}