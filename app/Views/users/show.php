<?php ob_start(); ?>

<div class="mb-3">
    <a href="<?= $this->url('users') ?>" class="btn btn-outline-secondary">⬅️ Назад към потребителите</a>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="card text-center bg-body-secondary">
            <div class="card-body">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">👤</div>
                <h2 class="h4 mb-1"><?= $this->escape($user['name']) ?></h2>
                <p class="text-secondary mb-2"><?= $this->escape($user['email']) ?></p>
                <?php $isActive = ($user['status'] ?? 'active') === 'active'; ?>
                <span class="badge bg-<?= $isActive ? 'success' : 'danger' ?>"><?= $this->escape($user['status'] ?? 'active') ?></span>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <h1 class="h3"><?= $this->escape($title) ?></h1>

        <div class="card my-3">
            <div class="card-header bg-body-secondary">
                <h3 class="h5 mb-0">ℹ️ Информация за потребителя</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th class="w-25">ID:</th>
                                <td><?= $this->escape($user['id']) ?></td>
                            </tr>
                            <tr>
                                <th>Име:</th>
                                <td><?= $this->escape($user['name']) ?></td>
                            </tr>
                            <tr>
                                <th>Имейл:</th>
                                <td>
                                    <a href="mailto:<?= $this->escape($user['email']) ?>" class="link-primary text-decoration-none">
                                        <?= $this->escape($user['email']) ?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Статус:</th>
                                <td>
                                    <span class="badge bg-<?= $isActive ? 'success' : 'danger' ?>"><?= $this->escape($user['status'] ?? 'active') ?></span>
                                </td>
                            </tr>
                            <?php if (isset($user['created_at'])): ?>
                            <tr>
                                <th>Регистриран:</th>
                                <td>
                                    <?= date('d.m.Y в H:i', strtotime($user['created_at'])) ?>
                                    <span class="text-secondary small">
                                        (преди <?= $this->timeAgo($user['created_at']) ?>)
                                    </span>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php if (isset($user['updated_at']) && $user['updated_at'] !== $user['created_at']): ?>
                            <tr>
                                <th>Последна промяна:</th>
                                <td><?= date('d.m.Y в H:i', strtotime($user['updated_at'])) ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="alert alert-success">
            <h4 class="h6">🎯 Пример за използване</h4>
            <ul class="mb-0">
                <li>Получите данни от контролера</li>
                <li>Покажете детайли за конкретен запис</li>
                <li>Използвате helper функции във view-то</li>
                <li>Стилизирате съдържанието</li>
            </ul>
        </div>

        <div class="my-3 d-flex gap-2">
            <a href="<?= $this->url('users') ?>" class="btn btn-outline-primary">📋 Всички потребители</a>
            <button onclick="editUser()" class="btn btn-success">✏️ Редактирай</button>
        </div>
    </div>
</div>

<script>
function editUser() {
    alert('Функционалността за редактиране все още не е имплементирана.\n\nМожете да я добавите като:\n1. Създадете метод edit() в UserController\n2. Добавите съответния маршрут\n3. Направите форма за редактиране');
}

// Helper функция за изчисляване на време (PHP функция симулирана в JS)
<?php if (!method_exists($this, 'timeAgo')): ?>
<?php 
// Добавяме helper функция към View класа
$this->timeAgo = function($datetime) {
    $time = time() - strtotime($datetime);
    if ($time < 60) return 'няколко секунди';
    if ($time < 3600) return floor($time/60) . ' минути';
    if ($time < 86400) return floor($time/3600) . ' часа';
    if ($time < 2629746) return floor($time/86400) . ' дни';
    if ($time < 31556952) return floor($time/2629746) . ' месеца';
    return floor($time/31556952) . ' години';
};
?>
<?php endif; ?>
</script>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>