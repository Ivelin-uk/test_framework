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
    /** @var \PDO */
    protected $pdo;
    protected $table;
    protected $primaryKey = 'id';
    
    public function __construct()
    {
        // Създава и пази PDO връзка на ниво инстанция
        $this->pdo = self::getConnection();
    }
    
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
     * Намира записи по ID или условия
     *
     * Приема следните формати за $criteria:
     * - scalar (int|string): търсене по първичен ключ
     * - асоциативен масив: [ 'field' => value, ... ] – AND между условията
     * - масив от обекти/масиви: [ {field1: val1, field2: val2}, {field3: val3} ] – OR между групите, AND в група
     * Връща масив от обекти (stdClass). За единичен резултат вземете първия елемент.
     *
     * @param mixed $criteria
     * @return array Масив от обекти (stdClass)
     */
    public function find($criteria = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if ($criteria === null || (is_array($criteria) && empty($criteria))) {
            // Без WHERE – връщаме всички
        } elseif (is_array($criteria)) {
            if (!empty($criteria)) {
                $isList = array_keys($criteria) === range(0, count($criteria) - 1);

                if ($isList) {
                    // Масив от групи: (g1) OR (g2) OR ... ; всяка група е AND от полета
                    $groups = [];
                    $gi = 0;
                    foreach ($criteria as $group) {
                        if (is_object($group)) {
                            $group = (array) $group;
                        }
                        if (!is_array($group) || empty($group)) {
                            $gi++;
                            continue;
                        }
                        $clauses = [];
                        foreach ($group as $key => $value) {
                            $param = $key . '_' . $gi;
                            $clauses[] = "{$key} = :{$param}";
                            $params[$param] = $value;
                        }
                        if (!empty($clauses)) {
                            $groups[] = '(' . implode(' AND ', $clauses) . ')';
                        }
                        $gi++;
                    }
                    if (!empty($groups)) {
                        $sql .= ' WHERE ' . implode(' OR ', $groups);
                    }
                } else {
                    // Единична група: AND между условията
                    $whereClauses = [];
                    foreach ($criteria as $key => $value) {
                        $whereClauses[] = "{$key} = :{$key}";
                        $params[$key] = $value;
                    }
                    if (!empty($whereClauses)) {
                        $sql .= ' WHERE ' . implode(' AND ', $whereClauses);
                    }
                }
            }
        } else {
            // Търсене по първичен ключ
            $sql .= " WHERE {$this->primaryKey} = :id";
            $params['id'] = $criteria;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Връща един запис (първия) според критериите
     */
    public function findOne($criteria)
    {
        $rows = $this->find($criteria);
        return $rows[0] ?? null;
    }

    /**
     * Връща всички записи от таблицата
     */
    public function all()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
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
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        
        return $this->pdo->lastInsertId();
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
        $stmt = $this->pdo->prepare($sql);
        
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
        $stmt = $this->pdo->prepare($sql);
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
        $stmt = $this->pdo->prepare($sql);
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