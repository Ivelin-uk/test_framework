<div class="row mb-4">
    <div class="col-md-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-store text-primary me-2"></i>
            Хранителни продукти
        </h1>
        <p class="text-muted">Изберете kategория za да разгледате нашите качествени продукти</p>
    </div>
</div>

<?php if (!empty($categories)): ?>
<div class="row g-4">
    <?php foreach ($categories as $category): ?>
    <div class="col-lg-4 col-md-6">
        <a href="<?= $this->url('shop/category/' . $category->id) ?>" class="category-card fade-in">
            <div class="category-icon">
                <?php if (!empty($category->icon)): ?>
                    <i class="fas fa-<?= $this->escape($category->icon) ?>"></i>
                <?php else: ?>
                    <i class="fas fa-boxes"></i>
                <?php endif; ?>
            </div>
            <div class="category-name">
                <?= $this->escape($category->name) ?>
            </div>
            <div class="category-count">
                <?= (int)$category->products_count ?> продукта
            </div>
            <?php if (!empty($category->description)): ?>
            <div class="category-description mt-2">
                <small class="text-muted">
                    <?= $this->escape(mb_substr($category->description, 0, 100)) ?>
                    <?php if (mb_strlen($category->description) > 100): ?>...<?php endif; ?>
                </small>
            </div>
            <?php endif; ?>
        </a>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-info-circle fa-3x mb-3 text-muted"></i>
            <h4>Все още няма категории</h4>
            <p class="mb-0">Категориите ще бъдат добавени скоро.</p>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Търсене -->
<div class="row mt-5">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center mb-3">
                    <i class="fas fa-search me-2"></i>
                    Търсене на продукти
                </h5>
                <form method="GET" action="<?= $this->url('shop/search') ?>" class="d-flex gap-2">
                    <input 
                        type="text" 
                        name="q" 
                        class="form-control" 
                        placeholder="Търсете продукти..." 
                        value="<?= isset($searchQuery) ? $this->escape($searchQuery) : '' ?>"
                    >
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Font Awesome CDN за иконите
if (!document.querySelector('link[href*="font-awesome"]')) {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
    document.head.appendChild(link);
}
</script>