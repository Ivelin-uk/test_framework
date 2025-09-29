<div class="container py-4">
  <h1 class="h3 mb-4">Регистрация</h1>

  <form method="post" action="<?= $this->url('users/save') ?>" class="row g-3">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Потребителско име</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Имейл</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Име</label>
        <input type="text" name="first_name" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Фамилия</label>
        <input type="text" name="last_name" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Парола</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Повтори паролата</label>
        <input type="password" name="password_confirm" class="form-control" required>
      </div>
    </div>

    <div class="mt-4 d-flex gap-2">
      <button type="submit" class="btn btn-primary">Създай акаунт</button>
  <a href="<?= $this->url('') ?>" class="btn btn-outline-secondary">Отказ</a>
    </div>
  </form>
</div>
