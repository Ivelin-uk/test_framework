<?php ob_start(); ?>

<div style="margin-bottom: 2rem;">
    <a href="<?= $this->url('users') ?>" class="btn">⬅️ Назад към потребителите</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <div>
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; text-align: center;">
            <div style="width: 80px; height: 80px; background: #3498db; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white;">
                👤
            </div>
            <h2><?= $this->escape($user['name']) ?></h2>
            <p style="color: #666;"><?= $this->escape($user['email']) ?></p>
            <span style="background: <?= $user['status'] === 'active' ? '#27ae60' : '#e74c3c' ?>; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">
                <?= $this->escape($user['status'] ?? 'active') ?>
            </span>
        </div>
    </div>
    
    <div>
        <h1><?= $this->escape($title) ?></h1>
        
        <div style="background: white; border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden; margin: 2rem 0;">
            <div style="background: #f8f9fa; padding: 1rem; border-bottom: 1px solid #e9ecef;">
                <h3>ℹ️ Информация за потребителя</h3>
            </div>
            <div style="padding: 1.5rem;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4; font-weight: bold; width: 30%;">ID:</td>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4;"><?= $this->escape($user['id']) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4; font-weight: bold;">Име:</td>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4;"><?= $this->escape($user['name']) ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4; font-weight: bold;">Имейл:</td>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4;">
                            <a href="mailto:<?= $this->escape($user['email']) ?>" style="color: #3498db; text-decoration: none;">
                                <?= $this->escape($user['email']) ?>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4; font-weight: bold;">Статус:</td>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4;">
                            <span style="background: <?= $user['status'] === 'active' ? '#27ae60' : '#e74c3c' ?>; color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.85rem;">
                                <?= $this->escape($user['status'] ?? 'active') ?>
                            </span>
                        </td>
                    </tr>
                    <?php if (isset($user['created_at'])): ?>
                    <tr>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4; font-weight: bold;">Регистриран:</td>
                        <td style="padding: 0.8rem 0; border-bottom: 1px solid #f1f3f4;">
                            <?= date('d.m.Y в H:i', strtotime($user['created_at'])) ?>
                            <span style="color: #666; font-size: 0.9rem;">
                                (преди <?= $this->timeAgo($user['created_at']) ?>)
                            </span>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if (isset($user['updated_at']) && $user['updated_at'] !== $user['created_at']): ?>
                    <tr>
                        <td style="padding: 0.8rem 0; font-weight: bold;">Последна промяна:</td>
                        <td style="padding: 0.8rem 0;">
                            <?= date('d.m.Y в H:i', strtotime($user['updated_at'])) ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        
        <div style="background: #e8f5e8; padding: 1.5rem; border-radius: 8px; margin: 2rem 0;">
            <h4>🎯 Пример за използване</h4>
            <p>Този изглед демонстрира как да:</p>
            <ul>
                <li>Получите данни от контролера</li>
                <li>Покажете детайли за конкретен запис</li>
                <li>Използвате helper функции във view-то</li>
                <li>Стилизирате съдържанието</li>
            </ul>
        </div>
        
        <div style="margin: 2rem 0;">
            <a href="<?= $this->url('users') ?>" class="btn">📋 Всички потребители</a>
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