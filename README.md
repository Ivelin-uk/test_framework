# 🚀 Моят PHP Framework

Лек и бърз PHP framework, построен на MVC архитектура. Идеален за създаване на малки до средни уеб приложения с ясна структура и лесна за разбиране логика.

## ✨ Характеристики

- 🏗️ **MVC архитектура** - Ясно разделение между Model, View и Controller
- 🎯 **URL маршрутизация** - Лесно дефиниране на routes с поддръжка на параметри
- 🎨 **Шаблонна система** - Гъвкави и переизползваеми изгледи
- 🗄️ **ORM подобен модел** - Лесна работа с бази данни чрез PDO
- 🔄 **Автолоудър** - Автоматично зареждане на класове според PSR-4
- ⚙️ **Конфигурация** - Централизирано управление на настройки
- 🔒 **Сигурност** - Защита от основни уязвимости
- 📱 **AJAX поддръжка** - Лесно създаване на API endpoints

## 📁 Структура на проекта

```
my-framework/
├── app/
│   ├── Controllers/     # Контролери
│   ├── Models/         # Модели за работа с данни
│   └── Views/          # HTML шаблони
├── config/
│   ├── app.php         # Основна конфигурация
│   └── database.php    # Настройки за БД
├── core/               # Основни класове на framework-а
│   ├── Application.php
│   ├── Router.php
│   ├── Controller.php
│   ├── Model.php
│   ├── View.php
│   └── Autoloader.php
├── public/
│   ├── index.php       # Входна точка
│   └── .htaccess       # URL rewriting
└── routes/
    └── web.php         # Дефиниция на маршрути
```

## 🚀 Инсталация

### 1. Изисквания
- PHP 7.4 или по-нова версия
- Apache/Nginx с mod_rewrite
- MySQL/MariaDB (опционално)

### 2. Настройка

1. **Клонирайте или изтеглете проекта:**
```bash
git clone https://github.com/username/my-php-framework.git
cd my-php-framework
```

2. **Настройте виртуален хост или използвайте PHP вграден сървър:**

За development можете да използвате:
```bash
cd public
php -S localhost:8000
```

3. **Конфигурирайте базата данни** в `config/database.php`:
```php
return [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'my_framework_db',
    'username' => 'root',
    'password' => '',
    // ...
];
```

4. **Създайте тестова база данни** (опционално):
```sql
CREATE DATABASE my_framework_db;
USE my_framework_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO users (name, email) VALUES 
    ('Иван Петров', 'ivan@example.com'),
    ('Мария Георгиева', 'maria@example.com');
```

## 📖 Как да използвам

### Създаване на контролер

```php
<?php
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
    
    public function apiData()
    {
        $this->json([
            'success' => true,
            'data' => ['key' => 'value']
        ]);
    }
}
```

### Създаване на модел

```php
<?php
namespace App\Models;

use Core\Model;

class MyModel extends Model
{
    protected $table = 'my_table';
    
    public function getActive()
    {
        return $this->findAll(['status' => 'active']);
    }
}
```

### Дефиниране на маршрути

В `routes/web.php`:

```php
// GET маршрут
$router->get('/my-page', [
    'controller' => 'MyController',
    'action' => 'index'
]);

// POST маршрут
$router->post('/api/data', [
    'controller' => 'MyController',
    'action' => 'apiData'
]);

// Маршрут с параметър
$router->get('/user/{id}', [
    'controller' => 'UserController',
    'action' => 'show'
]);
```

### Създаване на изглед

В `app/Views/my/index.php`:

```php
<?php ob_start(); ?>

<h1><?= $this->escape($title) ?></h1>
<p><?= $this->escape($message) ?></p>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>
```

## 🎨 Шаблонна система

Framework-ът използва PHP файлове като шаблони с помощни функции:

- `$this->escape($value)` - HTML escape
- `$this->url($path)` - Генериране на URL
- `$this->partial($view, $data)` - Включване на частичен изглед

## 🗄️ Работа с база данни

```php
// В контролера
$userModel = new User();

// Намиране по ID
$user = $userModel->find(1);

// Намиране на всички
$users = $userModel->findAll();

// Създаване
$userId = $userModel->create([
    'name' => 'Петър',
    'email' => 'peter@example.com'
]);

// Обновяване
$userModel->update(1, ['name' => 'Петър Updated']);

// Изтриване
$userModel->delete(1);

// Персонализирана заявка
$activeUsers = $userModel->query(
    "SELECT * FROM users WHERE status = :status",
    ['status' => 'active']
);
```

## 🔧 Конфигурация

### Основни настройки (`config/app.php`)
```php
return [
    'debug' => true,
    'app_name' => 'Моето приложение',
    'timezone' => 'Europe/Sofia',
    // ...
];
```

### База данни (`config/database.php`)
```php
return [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'my_db',
    'username' => 'user',
    'password' => 'pass',
    // ...
];
```

## 🌐 Примерни страници

След настройката можете да посетите:

- `/` - Начална страница
- `/about` - За проекта
- `/contact` - Контактна форма
- `/users` - Списък с потребители (изисква БД)
- `/users/1` - Детайли за потребител

## 🚧 Разширения

Framework-ът може лесно да бъде разширен с:

- Middleware система
- Валидация на форми
- Сесии и автентификация
- Кеширане
- Логове
- CLI команди
- Email система

## 📝 Принос

Приветстваме всякакви предложения и подобрения! Просто:

1. Fork проекта
2. Създайте feature branch
3. Commit промените
4. Push в branch-а
5. Отворете Pull Request

## 📄 Лиценз

Този проект е лицензиран под MIT License.

## 🤝 Поддръжка

Ако имате въпроси или проблеми:

- Отворете Issue в GitHub
- Свържете се с нас на contact@example.com

---

**Наслаждавайте се на разработката с Моят PHP Framework! 🎉**# test_framework

## 🎨 Дизайн с Bootstrap 5

Проектът използва Bootstrap 5 чрез CDN за базовия дизайн и компоненти.

- Включването става в `app/Views/layouts/main.php` (CSS и JS от jsDelivr CDN)
- Основният контейнер и навигация са изградени с Bootstrap класове
- Формите, таблиците и бутоните в примерните изгледи използват Bootstrap компоненти

Как да персонализирате стила:

- Добавете свои CSS правила след Bootstrap в `main.php` с `<style>` или създайте файл в `public/` и го включете
- Използвайте utility класове (например `mt-3`, `text-secondary`, `d-flex`, `gap-2`)
- Разгледайте документацията: https://getbootstrap.com/docs/5.3/
