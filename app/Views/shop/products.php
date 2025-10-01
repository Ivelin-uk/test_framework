<!-- Breadcrumbs -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= $this->url('shop') ?>">
                <i class="fas fa-store me-1"></i>Магазин
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <?= $this->escape($category->name) ?>
        </li>
    </ol>
</nav>

<!-- Заглавие на категорията -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-3">
            <?php if (!empty($category->icon)): ?>
                <i class="fas fa-<?= $this->escape($category->icon) ?> text-primary me-3" style="font-size: 2rem;"></i>
            <?php endif; ?>
            <div>
                <h1 class="h3 mb-1"><?= $this->escape($category->name) ?></h1>
                <p class="text-muted mb-0">
                    <?= (int)$category->products_count ?> продукта в тази категория
                </p>
            </div>
        </div>
        
        <?php if (!empty($category->description)): ?>
        <div class="alert alert-light">
            <p class="mb-0"><?= $this->escape($category->description) ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($products)): ?>
<div class="row g-4">
    <?php foreach ($products as $product): ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="product-card fade-in">
            <?php if (!empty($product->image)): ?>
                <img src="<?= $this->escape($product->image) ?>" 
                     class="card-img-top" 
                     alt="<?= $this->escape($product->name) ?>"
                     loading="lazy">
            <?php else: ?>
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light">
                    <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                </div>
            <?php endif; ?>
            
            <div class="card-body">
                <h5 class="card-title">
                    <a href="<?= $this->url('shop/product/' . $product->id) ?>" 
                       class="text-decoration-none text-dark">
                        <?= $this->escape($product->name) ?>
                    </a>
                </h5>
                
                <?php if (!empty($product->short_description)): ?>
                <p class="card-text">
                    <?= $this->escape(mb_substr($product->short_description, 0, 100)) ?>
                    <?php if (mb_strlen($product->short_description) > 100): ?>...<?php endif; ?>
                </p>
                <?php endif; ?>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <?php if (!empty($product->old_price) && $product->old_price > $product->price): ?>
                            <span class="product-price old-price">
                                <?= number_format($product->old_price, 2) ?> лв.
                            </span><br>
                        <?php endif; ?>
                        <span class="product-price">
                            <?= number_format($product->price, 2) ?> лв.
                        </span>
                        <?php if (!empty($product->unit)): ?>
                            <small class="text-muted">/ <?= $this->escape($product->unit) ?></small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="text-end">
                        <a href="<?= $this->url('shop/product/' . $product->id) ?>" 
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Детайли
                        </a>
                    </div>
                </div>
                
                <?php if (isset($product->stock_quantity) && $product->stock_quantity <= 5 && $product->stock_quantity > 0): ?>
                <small class="text-warning">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Остават само <?= (int)$product->stock_quantity ?> бр.
                </small>
                <?php elseif (isset($product->stock_quantity) && $product->stock_quantity <= 0): ?>
                <small class="text-danger">
                    <i class="fas fa-times-circle me-1"></i>
                    Изчерпан
                </small>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Филтри (за бъдеща употреба) -->
<div class="row mt-5">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <p class="text-muted mb-0">
                Показани <?= count($products) ?> от <?= (int)$category->products_count ?> продукта
            </p>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;" onchange="sortProducts(this.value)">
                    <option value="">Сортиране</option>
                    <option value="name_asc">Име А-Я</option>
                    <option value="name_desc">Име Я-А</option>
                    <option value="price_asc">Цена ↑</option>
                    <option value="price_desc">Цена ↓</option>
                </select>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
            <h4>Няма продукти в тази категория</h4>
            <p class="mb-3">В момента няма налични продукти в категория "<?= $this->escape($category->name) ?>".</p>
            <a href="<?= $this->url('shop') ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Обратно към категориите
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function sortProducts(sortBy) {
    if (!sortBy) return;
    
    const container = document.querySelector('.row.g-4');
    const products = Array.from(container.children);
    
    products.sort((a, b) => {
        const titleA = a.querySelector('.card-title a').textContent.trim();
        const titleB = b.querySelector('.card-title a').textContent.trim();
        const priceA = parseFloat(a.querySelector('.product-price').textContent.replace(/[^\d.]/g, ''));
        const priceB = parseFloat(b.querySelector('.product-price').textContent.replace(/[^\d.]/g, ''));
        
        switch(sortBy) {
            case 'name_asc':
                return titleA.localeCompare(titleB, 'bg');
            case 'name_desc':
                return titleB.localeCompare(titleA, 'bg');
            case 'price_asc':
                return priceA - priceB;
            case 'price_desc':
                return priceB - priceA;
            default:
                return 0;
        }
    });
    
    products.forEach(product => container.appendChild(product));
}
</script>