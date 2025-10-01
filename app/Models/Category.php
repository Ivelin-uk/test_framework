<?php

namespace App\Models;

use Core\Model;

class Category extends Model
{
    protected $table = 'categories';
    
    /**
     * Взема всички категории с брой продукти
     */
    public function getCategoriesWithProductCount()
    {
        $sql = "
            SELECT c.*, COUNT(p.id) as product_count 
            FROM {$this->table} c 
            LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1
            WHERE c.is_active = 1 
            GROUP BY c.id 
            ORDER BY c.sort_order ASC, c.name ASC
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * Взема категория по ID с брой продукти
     */
    public function getCategoryWithProductCount($id)
    {
        $sql = "
            SELECT c.*, COUNT(p.id) as product_count 
            FROM {$this->table} c 
            LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1
            WHERE c.id = ? AND c.is_active = 1 
            GROUP BY c.id
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result ?: null;
    }
    
    /**
     * Взема активни категории
     */
    public function getActiveCategories()
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY sort_order ASC, name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * Търси категории по име
     */
    public function searchByName(string $name): array
    {
        $sql = "
            SELECT * FROM {$this->table} 
            WHERE name LIKE ? AND is_active = 1 
            ORDER BY name ASC
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $name . '%']);
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}