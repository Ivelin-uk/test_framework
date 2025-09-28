<?php ob_start(); ?>

<h1>📞 <?= $this->escape($title) ?></h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        ✅ Съобщението ви беше изпратено успешно! Ще се свържем с вас скоро.
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin: 2rem 0;">
    <div>
        <h2>Свържете се с нас</h2>
        <p>Имате въпроси относно framework-а? Не се колебайте да се свържете с нас!</p>
        
        <div style="margin: 2rem 0;">
            <h3>📧 Контактна информация</h3>
            <p><strong>Имейл:</strong> <?= $this->escape($email) ?></p>
            <p><strong>Телефон:</strong> <?= $this->escape($phone) ?></p>
        </div>
        
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px;">
            <h4>⏰ Работно време</h4>
            <p>Понеделник - Петък: 9:00 - 18:00</p>
            <p>Съботни дни: 10:00 - 14:00</p>
            <p>Неделя: Почивен ден</p>
        </div>
    </div>
    
    <div>
        <h2>Изпратете съобщение</h2>
        
        <form id="contactForm" action="<?= $this->url('contact') ?>" method="POST">
            <div class="form-group">
                <label for="name">Име *</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Имейл *</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="message">Съобщение *</label>
                <textarea id="message" name="message" required placeholder="Напишете вашето съобщение тук..."></textarea>
            </div>
            
            <button type="submit" class="btn btn-success">📤 Изпрати съобщение</button>
        </form>
        
        <div id="formMessage" style="margin-top: 1rem;"></div>
    </div>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageDiv = document.getElementById('formMessage');
    messageDiv.innerHTML = '<div style="color: #666;">⏳ Изпращане...</div>';
    
    submitForm(this, function(data) {
        if (data.success) {
            messageDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
            document.getElementById('contactForm').reset();
        } else {
            messageDiv.innerHTML = '<div class="alert alert-error">' + data.message + '</div>';
        }
    });
});
</script>

<?php $content = ob_get_clean(); ?>
<?php include VIEW_PATH . '/layouts/main.php'; ?>