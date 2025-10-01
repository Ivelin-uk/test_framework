<div class="container py-4">
    <!-- Заглавие -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body text-center">
                    <h2 class="card-title mb-3">
                        <i class="fas fa-star"></i> Препоръчани продукти
                    </h2>
                    <p class="card-text lead">
                        Открийте най-популярните и качествени продукти, специално подбрани за вас
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Търсене и филтри -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="<?= $this->url('shop/search') ?>" class="d-flex">
                <input type="text" name="q" class="form-control me-2" 
                       placeholder="Търсене в препоръчаните продукти...">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= $this->url('shop') ?>" class="btn btn-outline-primary">
                <i class="fas fa-th-large"></i> Всички категории
            </a>
        </div>
    </div>

    <!-- Препоръчани продукти -->
    <?php if (empty($products)): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5>Няма препоръчани продукти</h5>
                    <p>В момента няма налични препоръчани продукти.</p>
                    <a href="<?= $this->url('shop') ?>" class="btn btn-primary">
                        <i class="fas fa-th-large"></i> Разгледайте всички категории
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="product-card featured-product">
                        <div class="product-image">
                            <img src="https://via.placeholder.com/300x200?text=<?= urlencode($product->name) ?>" 
                                 alt="<?= htmlspecialchars($product->name) ?>" 
                                 class="card-img-top">
                            
                            <!-- Бадджове -->
                            <div class="product-badges">
                                <span class="product-badge featured">
                                    <i class="fas fa-star"></i> ПРЕПОРЪЧВАН
                                </span>
                                <?php if ($product->old_price): ?>
                                    <span class="product-badge sale">
                                        <i class="fas fa-percent"></i> НАМАЛЕНИЕ
                                    </span>
                                <?php endif; ?>
                                <?php if ($product->stock_quantity <= 5): ?>
                                    <span class="product-badge limited">
                                        <i class="fas fa-clock"></i> ОГРАНИЧЕНО
                                    </span>
                                <?php endif; ?>
                            </div>
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
                            
                            <!-- Цена с по-големи шрифтове за препоръчаните -->
                            <div class="product-price featured-price">
                                <?php if ($product->old_price): ?>
                                    <span class="old-price"><?= number_format($product->old_price, 2) ?> лв.</span>
                                    <div class="discount-percent">
                                        -<?= round((($product->old_price - $product->price) / $product->old_price) * 100) ?>%
                                    </div>
                                <?php endif; ?>
                                <span class="current-price"><?= number_format($product->price, 2) ?> лв.</span>
                                <small class="unit">за <?= htmlspecialchars($product->unit) ?></small>
                            </div>
                            
                            <!-- Рейтинг и продажби (ако има) -->
                            <?php if (isset($product->rating_avg) && $product->rating_avg > 0): ?>
                                <div class="product-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= round($product->rating_avg) ? 'text-warning' : 'text-muted' ?>"></i>
                                    <?php endfor; ?>
                                    <small class="text-muted">(<?= $product->rating_count ?? 0 ?> отзива)</small>
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-actions">
                                <a href="<?= $this->url('shop/product/' . $product->id) ?>" 
                                   class="btn btn-primary flex-fill">
                                    <i class="fas fa-eye"></i> Детайли
                                </a>
                                <button class="btn btn-success" onclick="addToCart(<?= $product->id ?>)" title="Добави в количката">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="addToWishlist(<?= $product->id ?>)" title="Добави в списъка с желани">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                            
                            <!-- Наличност -->
                            <div class="product-stock">
                                <?php if ($product->stock_quantity > 10): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> В наличност
                                    </span>
                                <?php elseif ($product->stock_quantity > 0): ?>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        Остават <?= $product->stock_quantity ?> бр.
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle"></i> Изчерпано
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Още препоръчани продукти бутон -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="text-muted mb-3">Показани са <?= count($products) ?> препоръчани продукта</p>
                <a href="<?= $this->url('shop') ?>" class="btn btn-outline-primary me-2">
                    <i class="fas fa-th-large"></i> Всички категории
                </a>
                <button onclick="location.reload()" class="btn btn-outline-secondary">
                    <i class="fas fa-sync-alt"></i> Обнови препоръките
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- CSS за featured продукти -->
<style>
.featured-product {
    border: 2px solid #ffc107;
    box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
    transition: transform 0.3s ease;
}

.featured-product:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(255, 193, 7, 0.4);
}

.featured-price .current-price {
    font-size: 1.4em;
    font-weight: bold;
    color: #28a745;
}

.discount-percent {
    position: absolute;
    top: -10px;
    right: -10px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8em;
    font-weight: bold;
}

.product-badges {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 2;
}

.product-badges .product-badge {
    display: block;
    margin-bottom: 5px;
}

.product-rating {
    margin: 10px 0;
}

.product-stock {
    margin-top: 10px;
}
</style>

<script>
function addToCart(productId) {
    // TODO: Implement add to cart functionality
    alert('Продуктът ще бъде добавен в количката скоро. ID: ' + productId);
}

function addToWishlist(productId) {
    // TODO: Implement wishlist functionality
    alert('Продуктът ще бъде добавен в списъка с желани скоро. ID: ' + productId);
}
</script>