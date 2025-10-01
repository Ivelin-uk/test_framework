<div class="center-content">
    <div class="form-container">
        <h1 class="h3 mb-4 text-gradient text-center">Вход в системата</h1>
        
        <form method="post" action="<?= $this->url('auth/login') ?>" class="needs-validation" novalidate>
            <div class="mb-3">
                <label class="form-label">Имейл адрес</label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       value="<?= isset($old['email']) ? $this->escape($old['email']) : '' ?>" 
                       required>
                <div class="invalid-feedback">
                    Моля въведете валиден имейл адрес.
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Парола</label>
                <input type="password" 
                       name="password" 
                       class="form-control" 
                       required>
                <div class="invalid-feedback">
                    Моля въведете вашата парола.
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary hover-lift">
                    Влез в системата
                </button>
                <a class="btn btn-outline-secondary" href="<?= $this->url('auth/register') ?>">
                    Няма акаунт? Регистрирай се
                </a>
            </div>
        </form>
    </div>
</div>
