<?php ob_start(); ?>

<h1 class="mb-4">📞 <?= $this->escape($title) ?></h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        ✅ Съобщението ви беше изпратено успешно! Ще се свържем с вас скоро.
    </div>
<?php endif; ?>

<div class="row g-5 my-3">
    <div class="col-12 col-lg-6">
        <h2>Свържете се с нас</h2>
        <p>Имате въпроси относно framework-а? Не се колебайте да се свържете с нас!</p>

        <div class="my-4">
            <h3>📧 Контактна информация</h3>
            <p><strong>Имейл:</strong> <?= $this->escape($email) ?></p>
            <p><strong>Телефон:</strong> <?= $this->escape($phone) ?></p>
        </div>

        <div class="p-3 rounded bg-body-secondary">
            <h4>⏰ Работно време</h4>
            <p>Понеделник - Петък: 9:00 - 18:00</p>
            <p>Съботни дни: 10:00 - 14:00</p>
            <p>Неделя: Почивен ден</p>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <h2>Изпратете съобщение</h2>

        <form id="contactForm" action="<?= $this->url('contact') ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Име *</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Имейл *</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Съобщение *</label>
                <textarea id="message" name="message" class="form-control" required placeholder="Напишете вашето съобщение тук..."></textarea>
            </div>
            <button type="submit" class="btn btn-success">📤 Изпрати съобщение</button>
        </form>

        <div id="formMessage" class="mt-2"></div>
    </div>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const messageDiv = document.getElementById('formMessage');
    messageDiv.innerHTML = '<div class="text-secondary">⏳ Изпращане...</div>';

    submitForm(this, function(data) {
        if (data.success) {
            messageDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
            document.getElementById('contactForm').reset();
        } else {
            messageDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
        }
    });
});
</script>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>