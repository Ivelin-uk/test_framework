<div class="container py-4">
    <!-- Заглавие и форма за търсене -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-search"></i>
                        Резултати от търсенето: "<?= htmlspecialchars($searchQuery) ?>"
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Форма за ново търсене -->
                    <form method="GET" action="<?= $this->url('shop/search') ?>" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="q" class="form-control" 
                                       placeholder="Търсене на продукти..." 
                                       value="<?= htmlspecialchars($searchQuery) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-select">
                                    <option value="">Всички категории</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->id ?>" 
                                                <?= $selectedCategory == $category->id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Търсене
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Брой резултати -->
                    <small class="text-muted">
                        Намерени са <?= count($products) ?> продукта
                        <?php if ($selectedCategory > 0): ?>
                            в категория "<?= htmlspecialchars($categories[array_search($selectedCategory, array_column($categories, 'id'))]->name ?? '') ?>"
                        <?php endif; ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Резултати -->
    <?php if (empty($products)): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5>Няма намерени продукти</h5>
                    <p>Опитайте с други ключови думи или разгледайте всички категории.</p>
                    <a href="<?= $this->url('shop') ?>" class="btn btn-primary">
                        <i class="fas fa-th-large"></i> Всички категории
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://via.placeholder.com/300x200?text=<?= urlencode($product->name) ?>" 
                                 alt="<?= htmlspecialchars($product->name) ?>" 
                                 class="card-img-top">
                            <?php if ($product->old_price): ?>
                                <span class="product-badge sale">НАМАЛЕНИЕ</span>
                            <?php endif; ?>
                            <?php if ($product->is_featured): ?>
                                <span class="product-badge featured">ПРЕПОРЪЧВАН</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-category">
                                <i class="fas fa-<?= $product->category_icon ?? 'tag' ?>"></i>
                                <?= htmlspecialchars($product->category_name) ?>
                            </div>
                            
                            <h5 class="product-title">
                                <a href="<?= $this->url('shop/product/' . $product->id) ?>">
                                    <?= htmlspecialchars($product->name) ?>
                                </a>
                            </h5>
                            
                            <p class="product-description">
                                <?= htmlspecialchars($product->short_description) ?>
                            </p>
                            
                            <div class="product-price">
                                <?php if ($product->old_price): ?>
                                    <span class="old-price"><?= number_format($product->old_price, 2) ?> лв.</span>
                                <?php endif; ?>
                                <span class="current-price"><?= number_format($product->price, 2) ?> лв.</span>
                                <small class="unit">за <?= htmlspecialchars($product->unit) ?></small>
                            </div>
                            
                            <div class="product-actions">
                                <a href="<?= $this->url('shop/product/' . $product->id) ?>" 
                                   class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Детайли
                                </a>
                                <button class="btn btn-outline-primary" onclick="addToCart(<?= $product->id ?>)">
                                    <i class="fas fa-shopping-cart"></i> Количка
                                </button>
                            </div>
                            
                            <?php if ($product->stock_quantity <= 5): ?>
                                <div class="stock-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Остават само <?= $product->stock_quantity ?> бр.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Връщане към категориите -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="<?= $this->url('shop') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Обратно към категориите
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function addToCart(productId) {
    // TODO: Implement add to cart functionality
    alert('Добавяне в количката ще бъде имплементирано скоро. Продукт ID: ' + productId);
}
</script>