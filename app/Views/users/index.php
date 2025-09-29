<?php ob_start(); ?>

<h1>👥 <?= $this->escape($title) ?></h1>

<p>Това е примерна страница за управление на потребители. Тук може да видите как работи интеграцията между контролер, модел и изглед.</p>

<?php if (empty($users)): ?>
    <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px; margin: 2rem 0;">
        <h3>😔 Няма потребители</h3>
        <p>Все още няма регистрирани потребители в системата.</p>
        <p style="color: #666; font-size: 0.9rem;">
            <strong>Забележка:</strong> За да работи тази функционалност, трябва да настроите базата данни в <code>config/database.php</code>
            и да създадете таблица <code>users</code> със структура като тази:
        </p>
        <pre style="background: #2c3e50; color: white; padding: 1rem; border-radius: 5px; text-align: left; margin: 1rem 0;"><code>CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);</code></pre>
        <button onclick="showAddUserForm()" class="btn btn-success">➕ Добави тестов потребител</button>
    </div>
<?php else: ?>
    <div style="margin: 2rem 0;">
        <button onclick="showAddUserForm()" class="btn btn-success">➕ Добави нов потребител</button>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; margin: 2rem 0;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="border: 1px solid #ddd; padding: 1rem; text-align: left;">ID</th>
                    <th style="border: 1px solid #ddd; padding: 1rem; text-align: left;">Име</th>
                    <th style="border: 1px solid #ddd; padding: 1rem; text-align: left;">Имейл</th>
                    <th style="border: 1px solid #ddd; padding: 1rem; text-align: left;">Статус</th>
                    <th style="border: 1px solid #ddd; padding: 1rem; text-align: left;">Създаден</th>
                    <th style="border: 1px solid #ddd; padding: 1rem; text-align: left;">Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 1rem;"><?= $this->escape($user['id']) ?></td>
                    <td style="border: 1px solid #ddd; padding: 1rem;"><?= $this->escape($user['name']) ?></td>
                    <td style="border: 1px solid #ddd; padding: 1rem;"><?= $this->escape($user['email']) ?></td>
                    <td style="border: 1px solid #ddd; padding: 1rem;">
                        <span style="background: <?= $user['status'] === 'active' ? '#27ae60' : '#e74c3c' ?>; color: white; padding: 0.3rem 0.6rem; border-radius: 3px; font-size: 0.8rem;">
                            <?= $this->escape($user['status'] ?? 'active') ?>
                        </span>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 1rem;">
                        <?= isset($user['created_at']) ? date('d.m.Y H:i', strtotime($user['created_at'])) : 'N/A' ?>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 1rem;">
                        <a href="<?= $this->url('users/' . $user['id']) ?>" class="btn" style="font-size: 0.8rem; padding: 0.3rem 0.6rem;">👁️ Виж</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<!-- Форма за добавяне на потребител -->
<div id="addUserModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2rem; border-radius: 8px; min-width: 400px;">
        <h3>➕ Добави нов потребител</h3>
        
        <form id="addUserForm" action="<?= $this->url('users') ?>" method="POST" style="margin: 1rem 0;">
            <div class="form-group">
                <label for="newUserName">Имеd *</label>
                <input type="text" id="newUserName" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="newUserEmail">Имейл *</label>
                <input type="email" id="newUserEmail" name="email" required>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-success">💾 Запази</button>
                <button type="button" onclick="hideAddUserForm()" class="btn">❌ Отказ</button>
            </div>
        </form>
        
        <div id="addUserMessage"></div>
    </div>
</div>

<script>
function showAddUserForm() {
    document.getElementById('addUserModal').style.display = 'block';
}

function hideAddUserForm() {
    document.getElementById('addUserModal').style.display = 'none';
    document.getElementById('addUserForm').reset();
    document.getElementById('addUserMessage').innerHTML = '';
}

document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageDiv = document.getElementById('addUserMessage');
    messageDiv.innerHTML = '<div style="color: #666; margin-top: 1rem;">⏳ Записване...</div>';
    
    submitForm(this, function(data) {
        if (data.success) {
            messageDiv.innerHTML = '<div class="alert alert-success" style="margin-top: 1rem;">' + data.message + '</div>';
            setTimeout(function() {
                location.reload(); // Презареди страницата за да покаже новия потребител
            }, 1500);
        } else {
            messageDiv.innerHTML = '<div class="alert alert-error" style="margin-top: 1rem;">' + data.message + '</div>';
        }
    });
});

// Затваряне на модала при клик извън него
document.getElementById('addUserModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideAddUserForm();
    }
});
</script>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>