<?php ob_start(); ?>

<h1 class="mb-3">👥 <?= $this->escape($title) ?></h1>

<p class="text-secondary">Това е примерна страница за управление на потребители. Тук може да видите как работи интеграцията между контролер, модел и изглед.</p>

<?php if (empty($users)): ?>
    <div class="text-center p-5 bg-body-secondary rounded-3 my-4">
        <h3>😔 Няма потребители</h3>
        <p>Все още няма регистрирани потребители в системата.</p>
        <p class="text-secondary small">
            <strong>Забележка:</strong> За да работи тази функционалност, трябва да настроите базата данни в <code>config/database.php</code>
            и да създадете таблица <code>users</code> със структура като тази:
        </p>
        <pre class="bg-dark text-white p-3 rounded text-start my-3"><code>CREATE TABLE users (
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
    <div class="my-3">
        <button onclick="showAddUserForm()" class="btn btn-success">➕ Добави нов потребител</button>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Име</th>
                    <th>Имейл</th>
                    <th>Статус</th>
                    <th>Създаден</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->escape($user['id']) ?></td>
                    <td><?= $this->escape($user['name']) ?></td>
                    <td><?= $this->escape($user['email']) ?></td>
                    <td>
                        <?php $isActive = ($user['status'] ?? 'active') === 'active'; ?>
                        <span class="badge bg-<?= $isActive ? 'success' : 'danger' ?>">
                            <?= $this->escape($user['status'] ?? 'active') ?>
                        </span>
                    </td>
                    <td>
                        <?= isset($user['created_at']) ? date('d.m.Y H:i', strtotime($user['created_at'])) : 'N/A' ?>
                    </td>
                    <td>
                        <a href="<?= $this->url('users/' . $user['id']) ?>" class="btn btn-sm btn-primary">👁️ Виж</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<!-- Форма за добавяне на потребител (Bootstrap Modal) -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">➕ Добави нов потребител</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addUserForm" action="<?= $this->url('users') ?>" method="POST">
            <div class="mb-3">
                <label for="newUserName" class="form-label">Име *</label>
                <input type="text" id="newUserName" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="newUserEmail" class="form-label">Имейл *</label>
                <input type="email" id="newUserEmail" name="email" class="form-control" required>
            </div>
            <div id="addUserMessage"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Отказ</button>
        <button type="button" class="btn btn-success" id="saveUserBtn">💾 Запази</button>
      </div>
    </div>
  </div>
  </div>

<script>
let addUserModal;
function showAddUserForm() {
    addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
    document.getElementById('addUserForm').reset();
    document.getElementById('addUserMessage').innerHTML = '';
    addUserModal.show();
}

document.getElementById('saveUserBtn').addEventListener('click', function() {
    const form = document.getElementById('addUserForm');
    const messageDiv = document.getElementById('addUserMessage');
    messageDiv.innerHTML = '<div class="text-secondary">⏳ Записване...</div>';
    submitForm(form, function(data) {
        if (data.success) {
            messageDiv.innerHTML = '<div class="alert alert-success mt-2">' + data.message + '</div>';
            setTimeout(function() { location.reload(); }, 1200);
        } else {
            messageDiv.innerHTML = '<div class="alert alert-danger mt-2">' + data.message + '</div>';
        }
    });
});
</script>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>