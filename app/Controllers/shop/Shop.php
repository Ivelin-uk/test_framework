<?php

namespace App\Controllers\Shop;

use Core\Controller;
use App\Models\Product;
use App\Models\Category;

class Shop extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Начална страница на магазина - показва всички категории
     */
    public function index()
    {
        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getCategoriesWithProductCount();
        
        $this->set_data('categories', $categories);
        $this->set_data('title', 'Хранителни продукти - Категории');
        
        $this->view->render('shop', 'categories', $this->get_data());
    }
    
    /**
     * Показва продуктите от дадена категория
     */
    public function category($categoryId = null)
    {
        if (!$categoryId || !is_numeric($categoryId)) {
            \Core\Flash::set('status', 'Невалидна категория.', 'warning');
            return $this->redirect($this->view->url('shop'));
        }
        
        // Взема категорията
        $categoryModel = new \App\Models\Category();
        $category = $categoryModel->getCategoryWithProductCount((int)$categoryId);
        
        if (!$category) {
            \Core\Flash::set('status', 'Категорията не съществува.', 'warning');
            return $this->redirect($this->view->url('shop'));
        }
        
        // Взема продуктите в категорията
        $productModel = new \App\Models\Product();
        $products = $productModel->getProductsByCategory((int)$categoryId);
        
        $this->set_data('category', $category);
        $this->set_data('products', $products);
        $this->set_data('title', $category->name . ' - Продукти');
        
        $this->view->render('shop', 'products', $this->get_data());
    }
    
    /**
     * Показва детайли за конкретен продукт
     */
    public function product($productId = null)
    {
        if (!$productId || !is_numeric($productId)) {
            \Core\Flash::set('status', 'Невалиден продукт.', 'warning');
            return $this->redirect($this->view->url('shop'));
        }
        
        // Взема продукта с категория
        $productModel = new \App\Models\Product();
        $product = $productModel->getProductWithCategory((int)$productId);
        
        if (!$product) {
            \Core\Flash::set('status', 'Продуктът не съществува.', 'warning');
            return $this->redirect($this->view->url('shop'));
        }
        
        // Взема препоръчани продукти (без текущия)
        $recommendedProducts = $productModel->getRecommendedProducts(4, (int)$productId);
        
        $this->set_data('product', $product);
        $this->set_data('recommendedProducts', $recommendedProducts);
        $this->set_data('title', $product->name);
        
        $this->view->render('shop', 'product_detail', $this->get_data());
    }
    
    /**
     * Търсене на продукти
     */
    public function search()
    {
        $query = $this->get('q') ?? '';
        $categoryId = (int)($this->get('category') ?? 0);
        
        if (empty($query)) {
            \Core\Flash::set('status', 'Моля въведете текст за търсене.', 'warning');
            return $this->redirect($this->view->url('shop'));
        }
        
        // Търси продукти
        $productModel = new \App\Models\Product();
        $products = $productModel->searchProducts($query, $categoryId);
        
        // Взема категориите за филтъра
        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getActiveCategories();
        
        $this->set_data('products', $products);
        $this->set_data('categories', $categories);
        $this->set_data('searchQuery', $query);
        $this->set_data('selectedCategory', $categoryId);
        $this->set_data('title', 'Търсене: ' . $query);
        
        $this->view->render('shop', 'search_results', $this->get_data());
    }
    
    /**
     * Показва препоръчани/представени продукти
     */
    public function featured()
    {
        // За демо цели - показваме случайни продукти като "препоръчани"
        $productModel = new \App\Models\Product();
        $products = $productModel->getRecommendedProducts(12);
        
        $this->set_data('products', $products);
        $this->set_data('title', 'Препоръчани продукти');
        
        $this->view->render('shop', 'featured', $this->get_data());
    }
}