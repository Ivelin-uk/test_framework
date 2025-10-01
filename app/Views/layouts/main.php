<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $this->escape($title) : 'Моят PHP Framework' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body class="bg-body-tertiary d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= $this->url('') ?>">Начало</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $this->url('products/list') ?>">Продукти</a></li>
                    <?php if (\Core\Auth::check()): ?>
                        <li class="nav-item"><span class="nav-link">Здравей, <?= $this->escape(\Core\Auth::user()->name) ?></span></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $this->url('auth/logout') ?>">Изход</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= $this->url('auth/login') ?>">Логин</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $this->url('auth/register') ?>">Регистър</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <?= $content ?? '' ?>
        </div>
    </main>

    <footer class="py-4 bg-body-secondary border-top mt-auto">
        <div class="container text-center">
            <small class="text-muted">&copy; <?= date('Y') ?> Моят PHP Framework. Всички права запазени.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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