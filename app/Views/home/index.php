<?php ob_start(); ?>

<div class="text-center py-4">
    <h1>🎉 <?= $this->escape($title) ?></h1>
    <p class="fs-5 text-secondary mt-2"><?= $this->escape($message) ?></p>
</div>

<div class="row g-3">
    <?php foreach ($features as $feature): ?>
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h3 class="card-title">✨ <?= $this->escape($feature) ?></h3>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="text-center my-5">
    <h2>Как да започна?</h2>
    <p class="mt-2">Този framework следва MVC архитектурата и предоставя:</p>

    <div class="text-start mx-auto mt-4" style="max-width: 600px;">
        <h3>📁 Структура на папките</h3>
        <ul class="list-unstyled">
            <li>📂 <strong>app/Controllers/</strong> - Контролери</li>
            <li>📂 <strong>app/Models/</strong> - Модели</li>
            <li>📂 <strong>app/Views/</strong> - Изгледи</li>
            <li>📂 <strong>config/</strong> - Конфигурационни файлове</li>
            <li>📂 <strong>core/</strong> - Основни класове на framework-а</li>
            <li>📂 <strong>public/</strong> - Публични файлове</li>
            <li>📂 <strong>routes/</strong> - Дефиниция на маршрути</li>
        </ul>
    </div>

    <div class="mt-4 d-inline-flex gap-2">
        <a href="<?= $this->url('about') ?>" class="btn btn-primary">Научи повече</a>
        <a href="<?= $this->url('users') ?>" class="btn btn-success">Виж примери</a>
    </div>
</div>

<div class="p-4 bg-body-secondary rounded-3">
    <h3>🔧 Пример за създаване на контролер</h3>
    <pre class="bg-dark text-white p-3 rounded overflow-auto"><code>&lt;?php

namespace App\Controllers;

use Core\Controller;

class MyController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Моя страница',
            'message' => 'Здравей, свят!'
        }
        </code></pre>
        </div>

        <?php $content = ob_get_clean(); ?>
        <?php include VIEW_PATH . '/layouts/main.php'; ?>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>