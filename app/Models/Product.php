<?php

namespace App\Models;

use Core\Model;

class Product extends Model
{
    protected $table = 'products';

    // Връща всички продукти (масив от обекти)
    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}