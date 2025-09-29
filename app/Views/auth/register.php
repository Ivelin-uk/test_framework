<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6">
      <h1 class="h3 mb-4">Регистрация</h1>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success">Акаунтът е създаден успешно.</div>
  <?php endif; ?>

  <?php if (!empty($errors['general'])): ?>
    <div class="alert alert-danger"><?= $this->escape($errors['general']) ?></div>
  <?php endif; ?>

  <form method="post" action="<?= $this->url('users/save') ?>" class="g-3">
    <div class="mb-3">
        <label class="form-label">Потребителско име</label>
        <input type="text" name="username" class="form-control<?= !empty($errors['username']) ? ' is-invalid' : '' ?>" value="<?= isset($old['username']) ? $this->escape($old['username']) : '' ?>" required>
        <?php if (!empty($errors['username'])): ?><div class="invalid-feedback"><?= $this->escape($errors['username']) ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Имейл</label>
        <input type="email" name="email" class="form-control<?= !empty($errors['email']) ? ' is-invalid' : '' ?>" value="<?= isset($old['email']) ? $this->escape($old['email']) : '' ?>" required>
        <?php if (!empty($errors['email'])): ?><div class="invalid-feedback"><?= $this->escape($errors['email']) ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Име</label>
        <input type="text" name="first_name" class="form-control" value="<?= isset($old['first_name']) ? $this->escape($old['first_name']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Фамилия</label>
        <input type="text" name="last_name" class="form-control" value="<?= isset($old['last_name']) ? $this->escape($old['last_name']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Парола</label>
        <input type="password" name="password" class="form-control<?= !empty($errors['password']) ? ' is-invalid' : '' ?>" required>
        <?php if (!empty($errors['password'])): ?><div class="invalid-feedback"><?= $this->escape($errors['password']) ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Повтори паролата</label>
        <input type="password" name="password_confirm" class="form-control<?= !empty($errors['password_confirm']) ? ' is-invalid' : '' ?>" required>
        <?php if (!empty($errors['password_confirm'])): ?><div class="invalid-feedback"><?= $this->escape($errors['password_confirm']) ?></div><?php endif; ?>
      </div>

    <div class="mt-4 d-flex gap-2">
      <button type="submit" class="btn btn-primary">Създай акаунт</button>
  <a href="<?= $this->url('') ?>" class="btn btn-outline-secondary">Отказ</a>
    </div>
  </form>
    </div>
  </div>
</div>
