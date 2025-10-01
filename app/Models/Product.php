<?php

namespace App\Models;

use Core\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * Връща всички продукти (масив от обекти)
     */
    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * Взема активни продукти с информация за категорията
     */
    public function getActiveProductsWithCategory(int $limit = 0): array
    {
        $limitClause = $limit > 0 ? "LIMIT $limit" : "";
        
        $sql = "
            SELECT p.*, c.name as category_name, c.icon as category_icon 
            FROM {$this->table} p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.is_active = 1 
            ORDER BY p.created_at DESC 
            $limitClause
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * Взема продукти по категория
     */
    public function getProductsByCategory($categoryId, $limit = 0)
    {
        $limitClause = $limit > 0 ? "LIMIT $limit" : "";
        
        $sql = "
            SELECT p.*, c.name as category_name, c.icon as category_icon 
            FROM {$this->table} p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.category_id = ? AND p.is_active = 1 
            ORDER BY p.name ASC 
            $limitClause
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * Взема продукт по ID с категория
     */
    public function getProductWithCategory($id)
    {
        $sql = "
            SELECT p.*, c.name as category_name, c.icon as category_icon 
            FROM {$this->table} p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = ? AND p.is_active = 1
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result ?: null;
    }
    
    /**
     * Търси продукти по име или описание
     */
    public function searchProducts($query, $categoryId = 0)
    {
        $categoryClause = $categoryId > 0 ? "AND p.category_id = ?" : "";
        $params = ['%' . $query . '%', '%' . $query . '%'];
        
        if ($categoryId > 0) {
            $params[] = $categoryId;
        }
        
        $sql = "
            SELECT p.*, c.name as category_name, c.icon as category_icon 
            FROM {$this->table} p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE (p.name LIKE ? OR p.description LIKE ?) 
            AND p.is_active = 1 
            $categoryClause
            ORDER BY p.name ASC
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * Взема препоръчани продукти (случайни активни продукти)
     */
    public function getRecommendedProducts($limit = 6, $excludeId = 0)
    {
        $excludeClause = $excludeId > 0 ? "AND p.id != ?" : "";
        $params = $excludeId > 0 ? [$excludeId] : [];
        
        $sql = "
            SELECT p.*, c.name as category_name, c.icon as category_icon 
            FROM {$this->table} p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.is_active = 1 
            $excludeClause
            ORDER BY RAND() 
            LIMIT $limit
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}