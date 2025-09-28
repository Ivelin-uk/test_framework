<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

/**
 * Потребителски контролер
 */
class UserController extends Controller
{
    private $userModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }
    
    /**
     * Показва списък с потребители
     */
    public function index()
    {
        $users = $this->userModel->findAll();
        
        $data = [
            'title' => 'Потребители',
            'users' => $users
        ];
        
        $this->render('users/index', $data);
    }
    
    /**
     * Показва конкретен потребител
     */
    public function show($id = null)
    {
        if (!$id) {
            $this->redirect('/users');
            return;
        }
        
        $user = $this->userModel->find($id);
        
        if (!$user) {
            // Можете да създадете специална 404 страница
            http_response_code(404);
            echo "Потребителят не е намерен";
            return;
        }
        
        $data = [
            'title' => 'Потребител: ' . $user['name'],
            'user' => $user
        ];
        
        $this->render('users/show', $data);
    }
    
    /**
     * Създава нов потребител
     */
    public function store()
    {
        if (!$this->isPost()) {
            $this->json(['error' => 'Само POST заявки са разрешени'], 405);
            return;
        }
        
        $name = $this->post('name');
        $email = $this->post('email');
        
        // Валидация
        if (empty($name) || empty($email)) {
            $this->json([
                'success' => false,
                'message' => 'Име и имейл са задължителни'
            ], 400);
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json([
                'success' => false,
                'message' => 'Невалиден имейл адрес'
            ], 400);
            return;
        }
        
        try {
            $userId = $this->userModel->create([
                'name' => $name,
                'email' => $email,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->json([
                'success' => true,
                'message' => 'Потребителят беше създаден успешно',
                'user_id' => $userId
            ]);
            
        } catch (\Exception $e) {
            $this->json([
                'success' => false,
                'message' => 'Грешка при създаване на потребителя: ' . $e->getMessage()
            ], 500);
        }
    }
}