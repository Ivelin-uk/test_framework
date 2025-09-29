<div class="container py-4">
  <h1 class="h3 mb-4">Вход</h1>
  <form method="post" action="#" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Имейл</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Парола</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">Вход</button>
      <a class="btn btn-outline-secondary" href="<?= $this->url('') ?>">Отказ</a>
    </div>
  </form>
</div>
