<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $this->escape($title) : 'Моят PHP Framework' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background: #2c3e50;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        nav ul {
            list-style: none;
            display: flex;
            align-items: center;
        }
        
        nav ul li {
            margin-right: 2rem;
        }
        
        nav ul li:first-child {
            margin-right: auto;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        nav a:hover {
            color: #3498db;
        }
        
        main {
            background: white;
            margin: 2rem 0;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-height: 500px;
        }
        
        footer {
            background: #34495e;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
        }
        
        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #297fb8;
        }
        
        .btn-success {
            background: #27ae60;
        }
        
        .btn-success:hover {
            background: #219a52;
        }
        
        .alert {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #d4edda;
            border-color: #27ae60;
            color: #155724;
        }
        
        .alert-error {
            background: #f8d7da;
            border-color: #e74c3c;
            color: #721c24;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        
        input, textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        textarea {
            height: 120px;
            resize: vertical;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .feature-card {
            background: #ecf0f1;
            padding: 1rem;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="<?= $this->url() ?>">🚀 Моят Framework</a></li>
                    <li><a href="<?= $this->url() ?>">Начало</a></li>
                    <li><a href="<?= $this->url('about') ?>">За нас</a></li>
                    <li><a href="<?= $this->url('contact') ?>">Контакти</a></li>
                    <li><a href="<?= $this->url('users') ?>">Потребители</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <main>
            <?= $content ?? '' ?>
        </main>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> Моят PHP Framework. Всички права запазени.</p>
        </div>
    </footer>

    <script>
        // Основен JavaScript за AJAX заявки
        function submitForm(form, callback) {
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (callback) callback(data);
            })
            .catch(error => {
                console.error('Грешка:', error);
                if (callback) callback({success: false, message: 'Възникна грешка при изпращането'});
            });
        }
    </script>
</body>
</html>