<!-- Breadcrumbs -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= $this->url('shop') ?>">
                <i class="fas fa-store me-1"></i>Магазин
            </a>
        </li>
        <?php if (!empty($product->category_name)): ?>
        <li class="breadcrumb-item">
            <a href="<?= $this->url('shop/category/' . $product->category_id) ?>">
                <?= $this->escape($product->category_name) ?>
            </a>
        </li>
        <?php endif; ?>
        <li class="breadcrumb-item active" aria-current="page">
            <?= $this->escape($product->name) ?>
        </li>
    </ol>
</nav>

<!-- Детайли на продукта -->
<div class="row mb-5">
    <div class="col-lg-6">
        <?php if (!empty($product->image)): ?>
            <img src="<?= $this->escape($product->image) ?>" 
                 class="img-fluid rounded shadow-sm mb-3" 
                 alt="<?= $this->escape($product->name) ?>"
                 id="mainProductImage">
        <?php else: ?>
            <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                 style="height: 400px;">
                <i class="fas fa-image text-muted" style="font-size: 4rem;"></i>
            </div>
        <?php endif; ?>
        
        <!-- Галерия (за бъдеща употреба) -->
        <?php if (!empty($product->gallery)): ?>
        <div class="row g-2 mt-3">
            <?php 
            $gallery = json_decode($product->gallery, true);
            if ($gallery && is_array($gallery)): 
            ?>
                <?php foreach ($gallery as $index => $image): ?>
                <div class="col-3">
                    <img src="<?= $this->escape($image) ?>" 
                         class="img-fluid rounded cursor-pointer gallery-thumb" 
                         alt="<?= $this->escape($product->name) ?> - изглед <?= $index + 1 ?>"
                         onclick="changeMainImage('<?= $this->escape($image) ?>')">
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="col-lg-6">
        <h1 class="h3 mb-3"><?= $this->escape($product->name) ?></h1>
        
        <?php if (!empty($product->sku)): ?>
        <p class="text-muted mb-2">
            <small>Код: <?= $this->escape($product->sku) ?></small>
        </p>
        <?php endif; ?>
        
        <?php if (!empty($product->short_description)): ?>
        <p class="lead mb-4"><?= $this->escape($product->short_description) ?></p>
        <?php endif; ?>
        
        <!-- Цена -->
        <div class="mb-4">
            <?php if (!empty($product->old_price) && $product->old_price > $product->price): ?>
                <span class="product-price old-price fs-5 me-2">
                    <?= number_format($product->old_price, 2) ?> лв.
                </span>
                <span class="badge bg-danger">
                    -<?= round((($product->old_price - $product->price) / $product->old_price) * 100) ?>%
                </span>
                <br>
            <?php endif; ?>
            <span class="product-price fs-2 fw-bold">
                <?= number_format($product->price, 2) ?> лв.
            </span>
            <?php if (!empty($product->unit)): ?>
                <small class="text-muted">/ <?= $this->escape($product->unit) ?></small>
            <?php endif; ?>
        </div>
        
        <!-- Наличност -->
        <div class="mb-4">
            <?php if (isset($product->stock_quantity)): ?>
                <?php if ($product->stock_quantity > 10): ?>
                    <span class="badge bg-success fs-6">
                        <i class="fas fa-check-circle me-1"></i>В наличност
                    </span>
                <?php elseif ($product->stock_quantity > 0): ?>
                    <span class="badge bg-warning fs-6">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Остават <?= (int)$product->stock_quantity ?> бр.
                    </span>
                <?php else: ?>
                    <span class="badge bg-danger fs-6">
                        <i class="fas fa-times-circle me-1"></i>Изчерпан
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <!-- Допълнителна информация -->
        <?php if (!empty($product->weight)): ?>
        <div class="mb-3">
            <strong>Тегло:</strong> <?= number_format($product->weight, 2) ?> кг
        </div>
        <?php endif; ?>
        
        <!-- Действия -->
        <div class="d-flex gap-3 mb-4">
            <?php if (!isset($product->stock_quantity) || $product->stock_quantity > 0): ?>
            <div class="quantity-controls">
                <button class="quantity-btn" onclick="changeQuantity(-1)">
                    <i class="fas fa-minus"></i>
                </button>
                <input type="number" id="quantity" class="quantity-input" value="1" min="1" 
                       max="<?= $product->stock_quantity ?? 999 ?>">
                <button class="quantity-btn" onclick="changeQuantity(1)">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <button class="btn btn-primary btn-lg flex-grow-1" onclick="addToCart(<?= $product->id ?>)">
                <i class="fas fa-shopping-cart me-2"></i>Добави в количката
            </button>
            <?php else: ?>
            <button class="btn btn-secondary btn-lg flex-grow-1" disabled>
                <i class="fas fa-times-circle me-2"></i>Изчерпан
            </button>
            <?php endif; ?>
        </div>
        
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" onclick="addToWishlist(<?= $product->id ?>)">
                <i class="fas fa-heart me-1"></i>Желани
            </button>
            <button class="btn btn-outline-secondary" onclick="shareProduct()">
                <i class="fas fa-share me-1"></i>Сподели
            </button>
        </div>
    </div>
</div>

<!-- Подробно описание -->
<?php if (!empty($product->description)): ?>
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Подробно описание
                </h5>
            </div>
            <div class="card-body">
                <div class="description-content">
                    <?= nl2br($this->escape($product->description)) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Препоръчани продукти -->
<?php if (!empty($recommendedProducts)): ?>
<div class="row">
    <div class="col-md-12">
        <h4 class="mb-4">
            <i class="fas fa-thumbs-up me-2 text-primary"></i>
            Препоръчани продукти
        </h4>
        <div class="row g-4">
            <?php foreach ($recommendedProducts as $recommended): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <?php if (!empty($recommended->image)): ?>
                        <img src="<?= $this->escape($recommended->image) ?>" 
                             class="card-img-top" 
                             alt="<?= $this->escape($recommended->name) ?>">
                    <?php else: ?>
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light">
                            <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h6 class="card-title">
                            <a href="<?= $this->url('shop/product/' . $recommended->id) ?>" 
                               class="text-decoration-none text-dark">
                                <?= $this->escape($recommended->name) ?>
                            </a>
                        </h6>
                        <div class="product-price">
                            <?= number_format($recommended->price, 2) ?> лв.
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function changeQuantity(delta) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue + delta;
    const max = parseInt(quantityInput.getAttribute('max'));
    const min = parseInt(quantityInput.getAttribute('min'));
    
    if (newValue >= min && newValue <= max) {
        quantityInput.value = newValue;
    }
}

function changeMainImage(imageSrc) {
    const mainImage = document.getElementById('mainProductImage');
    if (mainImage) {
        mainImage.src = imageSrc;
    }
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    
    // За демо цели - показваме съобщение
    alert(`Продукт ${productId} е добавен в количката (${quantity} бр.)`);
    
    // Тук можете да добавите AJAX заявка за добавяне в количката
    // fetch('/cart/add', { ... })
}

function addToWishlist(productId) {
    alert(`Продукт ${productId} е добавен в желаните`);
    // Тук можете да добавите AJAX заявка за желани продукти
}

function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        });
    } else {
        // Fallback - копиране на URL в clipboard-а
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Линкът е копиран в clipboard-а');
        });
    }
}

// Стилизиране на галерията
document.querySelectorAll('.gallery-thumb').forEach(thumb => {
    thumb.style.cursor = 'pointer';
    thumb.addEventListener('mouseover', function() {
        this.style.opacity = '0.8';
    });
    thumb.addEventListener('mouseout', function() {
        this.style.opacity = '1';
    });
});
</script>