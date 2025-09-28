<?php ob_start(); ?>

<div style="text-align: center; padding: 2rem 0;">
    <h1>🎉 <?= $this->escape($title) ?></h1>
    <p style="font-size: 1.2rem; color: #666; margin: 1rem 0;"><?= $this->escape($message) ?></p>
</div>

<div class="features-grid">
    <?php foreach ($features as $feature): ?>
        <div class="feature-card">
            <h3>✨ <?= $this->escape($feature) ?></h3>
        </div>
    <?php endforeach; ?>
</div>

<div style="text-align: center; margin: 3rem 0;">
    <h2>Как да започна?</h2>
    <p style="margin: 1rem 0;">Този framework следва MVC архитектурата и предоставя:</p>
    
    <div style="text-align: left; max-width: 600px; margin: 2rem auto;">
        <h3>📁 Структура на папките</h3>
        <ul style="list-style-type: none; padding-left: 0;">
            <li>📂 <strong>app/Controllers/</strong> - Контролери</li>
            <li>📂 <strong>app/Models/</strong> - Модели</li>
            <li>📂 <strong>app/Views/</strong> - Изгледи</li>
            <li>📂 <strong>config/</strong> - Конфигурационни файлове</li>
            <li>📂 <strong>core/</strong> - Основни класове на framework-а</li>
            <li>📂 <strong>public/</strong> - Публични файлове</li>
            <li>📂 <strong>routes/</strong> - Дефиниция на маршрути</li>
        </ul>
    </div>
    
    <div style="margin: 2rem 0;">
        <a href="<?= $this->url('about') ?>" class="btn">Научи повече</a>
        <a href="<?= $this->url('users') ?>" class="btn btn-success">Виж примери</a>
    </div>
</div>

<div style="background: #ecf0f1; padding: 2rem; border-radius: 8px; margin: 2rem 0;">
    <h3>🔧 Пример за създаване на контролер</h3>
    <pre style="background: #2c3e50; color: white; padding: 1rem; border-radius: 5px; overflow-x: auto;"><code>&lt;?php

namespace App\Controllers;

use Core\Controller;

class MyController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Моя страница',
            'message' => 'Здравей, свят!'
        ];
        
        $this->render('my/index', $data);
    }
}</code></pre>
</div>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>