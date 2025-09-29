<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
      <h1 class="h3 mb-4">Вход</h1>
      <form method="post" action="#" class="g-3">
        <div class="mb-3">
          <label class="form-label">Имейл</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Парола</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mt-3 d-flex gap-2">
          <button class="btn btn-primary">Вход</button>
          <a class="btn btn-outline-secondary" href="<?= $this->url('') ?>">Отказ</a>
        </div>
      </form>
    </div>
  </div>
</div>
