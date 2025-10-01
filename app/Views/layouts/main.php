<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $this->escape($title) : 'Моят PHP Framework' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= $this->url('css/framework.css') ?>" rel="stylesheet">
</head>
<body class="bg-body-tertiary d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->url('shop') ?>" data-nav-persist="true">
                            <i class="fas fa-store me-1"></i>Магазин
                        </a>
                    </li>
                    <?php if (\Core\Auth::check()): ?>
                        <li class="nav-item">
                            <span class="nav-link text-light">
                                Здравей, <?= $this->escape(\Core\Auth::user()->username) ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->url('auth/logout') ?>">
                                Изход
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->url('auth/login') ?>" data-nav-persist="true">
                                Логин
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->url('auth/register') ?>" data-nav-persist="true">
                                Регистър
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <div class="content-container">
            <?php if (\Core\Flash::has('status')): ?>
                <?php foreach (\Core\Flash::get('status') as $flash): ?>
                    <div class="alert alert-<?= $flash['type'] ?> auto-hide" role="alert">
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?= $content ?? '' ?>
        </div>
    </main>

    <footer class="py-4 bg-body-secondary border-top mt-auto">
        <div class="container text-center">
            <small class="text-muted">&copy; <?= date('Y') ?> Моят PHP Framework. Всички права запазени.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= $this->url('js/framework.js') ?>"></script>
</body>
</html>