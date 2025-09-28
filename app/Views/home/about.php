<?php ob_start(); ?>

<h1>📚 <?= $this->escape($title) ?></h1>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin: 2rem 0;">
    <div>
        <h2>За Framework-а</h2>
        <p><?= $this->escape($description) ?></p>
        <p><strong>Версия:</strong> <?= $this->escape($version) ?></p>
        
        <h3 style="margin-top: 2rem;">Основни характеристики</h3>
        <ul>
            <li>🏗️ <strong>MVC архитектура</strong> - Ясно разделение на логиката</li>
            <li>🎯 <strong>URL маршрутизация</strong> - Лесно дефиниране на routes</li>
            <li>🎨 <strong>Шаблонна система</strong> - Гъвкави и переизползваеми изгледи</li>
            <li>🗄️ <strong>ORM подобен модел</strong> - Лесна работа с бази данни</li>
            <li>🔄 <strong>Автолоудър</strong> - Автоматично зареждане на класове</li>
            <li>⚙️ <strong>Конфигурация</strong> - Централизирано управление на настройки</li>
        </ul>
    </div>
    
    <div>
        <h2>Как работи</h2>
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px;">
            <h4>1. 🌐 Заявка</h4>
            <p>Потребителят прави HTTP заявка към приложението</p>
            
            <h4>2. 🎯 Маршрутизация</h4>
            <p>Router класът анализира URL-то и намира съответния контролер</p>
            
            <h4>3. 🎮 Контролер</h4>
            <p>Контролерът обработва заявката и извиква необходимите модели</p>
            
            <h4>4. 🗃️ Модел</h4>
            <p>Моделът взаимодейства с базата данни</p>
            
            <h4>5. 🎨 Изглед</h4>
            <p>View системата рендерира HTML отговора</p>
            
            <h4>6. 📤 Отговор</h4>
            <p>Крайният HTML се изпраща обратно към потребителя</p>
        </div>
    </div>
</div>

<div style="background: #e8f5e8; padding: 2rem; border-radius: 8px; margin: 2rem 0;">
    <h3>🚀 Начало на работа</h3>
    <ol>
        <li>Клонирай или изтегли framework-а</li>
        <li>Настрой виртуален хост или използвай PHP вграден сървър</li>
        <li>Конфигурирай базата данни в <code>config/database.php</code></li>
        <li>Дефинирай маршрути в <code>routes/web.php</code></li>
        <li>Създавай контролери в <code>app/Controllers/</code></li>
        <li>Създавай модели в <code>app/Models/</code></li>
        <li>Създавай изгледи в <code>app/Views/</code></li>
    </ol>
</div>

<div style="text-align: center; margin: 2rem 0;">
    <a href="<?= $this->url() ?>" class="btn">Назад към началото</a>
    <a href="<?= $this->url('contact') ?>" class="btn btn-success">Свържи се с нас</a>
</div>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>