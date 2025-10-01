<div class="center-content">
    <div class="form-container" style="max-width: 600px;">
        <h1 class="h3 mb-4 text-gradient text-center">Създаване на акаунт</h1>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success auto-hide">Акаунтът е създаден успешно.</div>
        <?php endif; ?>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger"><?= $this->escape($errors['general']) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= $this->url('auth/register') ?>" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Потребителско име *</label>
                    <input type="text" 
                           name="username" 
                           class="form-control<?= !empty($errors['username']) ? ' is-invalid' : '' ?>" 
                           value="<?= isset($old['username']) ? $this->escape($old['username']) : '' ?>" 
                           required>
                    <?php if (!empty($errors['username'])): ?>
                        <div class="form-error"><?= $this->escape($errors['username']) ?></div>
                    <?php else: ?>
                        <div class="invalid-feedback">Моля въведете потребителско име.</div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Имейл адрес *</label>
                    <input type="email" 
                           name="email" 
                           class="form-control<?= !empty($errors['email']) ? ' is-invalid' : '' ?>" 
                           value="<?= isset($old['email']) ? $this->escape($old['email']) : '' ?>" 
                           required>
                    <?php if (!empty($errors['email'])): ?>
                        <div class="form-error"><?= $this->escape($errors['email']) ?></div>
                    <?php else: ?>
                        <div class="invalid-feedback">Моля въведете валиден имейл адрес.</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Име</label>
                    <input type="text" 
                           name="first_name" 
                           class="form-control" 
                           value="<?= isset($old['first_name']) ? $this->escape($old['first_name']) : '' ?>">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Фамилия</label>
                    <input type="text" 
                           name="last_name" 
                           class="form-control" 
                           value="<?= isset($old['last_name']) ? $this->escape($old['last_name']) : '' ?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Парола *</label>
                    <input type="password" 
                           name="password" 
                           class="form-control<?= !empty($errors['password']) ? ' is-invalid' : '' ?>" 
                           required>
                    <?php if (!empty($errors['password'])): ?>
                        <div class="form-error"><?= $this->escape($errors['password']) ?></div>
                    <?php else: ?>
                        <div class="invalid-feedback">Моля въведете парола.</div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Повтори паролата *</label>
                    <input type="password" 
                           name="password_confirm" 
                           class="form-control<?= !empty($errors['password_confirm']) ? ' is-invalid' : '' ?>" 
                           required>
                    <?php if (!empty($errors['password_confirm'])): ?>
                        <div class="form-error"><?= $this->escape($errors['password_confirm']) ?></div>
                    <?php else: ?>
                        <div class="invalid-feedback">Моля повторете паролата.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="divider"></div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary hover-lift">
                    Създай акаунт
                </button>
                <a href="<?= $this->url('auth/login') ?>" class="btn btn-outline-secondary">
                    Вече имам акаунт
                </a>
            </div>
        </form>
        </div>
    </div>
</div>
