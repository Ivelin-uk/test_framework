-- ===========================================
-- ПЪЛНА SQL СТРУКТУРА ЗА ХРАНИТЕЛЕН МАГАЗИН
-- ===========================================

-- Създаване на таблица за потребители
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL COMMENT 'Потребителско име',
    `email` varchar(100) NOT NULL COMMENT 'Имейл адрес',
    `password` varchar(255) NOT NULL COMMENT 'Хеширана парола',
    `first_name` varchar(50) DEFAULT NULL COMMENT 'Собствено име',
    `last_name` varchar(50) DEFAULT NULL COMMENT 'Фамилно име',
    `phone` varchar(20) DEFAULT NULL COMMENT 'Телефонен номер',
    `address` text DEFAULT NULL COMMENT 'Адрес за доставка',
    `date_of_birth` date DEFAULT NULL COMMENT 'Дата на раждане',
    `is_active` tinyint(1) DEFAULT 1 COMMENT 'Дали акаунтът е активен',
    `email_verified_at` timestamp NULL DEFAULT NULL COMMENT 'Кога е верифициран имейлът',
    `remember_token` varchar(100) DEFAULT NULL COMMENT 'Remember me токен',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_username_unique` (`username`),
    UNIQUE KEY `users_email_unique` (`email`),
    KEY `idx_users_email` (`email`),
    KEY `idx_users_username` (`username`),
    KEY `idx_users_created_at` (`created_at`),
    KEY `idx_users_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Потребители на системата';

-- Създаване на таблица за категории
CREATE TABLE IF NOT EXISTS `categories` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL COMMENT 'Име на категорията',
    `slug` varchar(120) NOT NULL COMMENT 'URL slug',
    `description` text DEFAULT NULL COMMENT 'Описание на категорията',
    `icon` varchar(50) DEFAULT NULL COMMENT 'FontAwesome икона',
    `image` varchar(255) DEFAULT NULL COMMENT 'Изображение на категорията',
    `parent_id` int(11) DEFAULT NULL COMMENT 'Родителска категория (за подкатегории)',
    `sort_order` int(11) DEFAULT 0 COMMENT 'Ред за сортиране',
    `is_active` tinyint(1) DEFAULT 1 COMMENT 'Дали категорията е активна',
    `meta_title` varchar(200) DEFAULT NULL COMMENT 'SEO заглавие',
    `meta_description` varchar(500) DEFAULT NULL COMMENT 'SEO описание',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `categories_slug_unique` (`slug`),
    KEY `idx_categories_name` (`name`),
    KEY `idx_categories_active_sort` (`is_active`, `sort_order`),
    KEY `idx_categories_parent` (`parent_id`),
    KEY `fk_categories_parent` (`parent_id`),
    CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Категории продукти';

-- Създаване на таблица за продукти
CREATE TABLE IF NOT EXISTS `products` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `category_id` int(11) DEFAULT NULL COMMENT 'ID на категорията',
    `name` varchar(150) NOT NULL COMMENT 'Име на продукта',
    `slug` varchar(170) NOT NULL COMMENT 'URL slug',
    `sku` varchar(50) DEFAULT NULL COMMENT 'Артикулен номер',
    `barcode` varchar(50) DEFAULT NULL COMMENT 'Баркод',
    `description` text DEFAULT NULL COMMENT 'Подробно описание',
    `short_description` varchar(500) DEFAULT NULL COMMENT 'Кратко описание',
    `price` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Цена на продукта',
    `old_price` decimal(10,2) DEFAULT NULL COMMENT 'Стара цена (за отстъпка)',
    `cost_price` decimal(10,2) DEFAULT NULL COMMENT 'Себестойност',
    `stock_quantity` int(11) DEFAULT 0 COMMENT 'Количество в наличност',
    `min_stock_level` int(11) DEFAULT 0 COMMENT 'Минимално ниво на наличност',
    `image` varchar(255) DEFAULT NULL COMMENT 'Основно изображение',
    `gallery` json DEFAULT NULL COMMENT 'JSON с допълнителни изображения',
    `weight` decimal(8,3) DEFAULT NULL COMMENT 'Тегло в кг',
    `dimensions` varchar(50) DEFAULT NULL COMMENT 'Размери (ДxШxВ)',
    `unit` varchar(20) DEFAULT 'бр.' COMMENT 'Мерна единица',
    `brand` varchar(100) DEFAULT NULL COMMENT 'Марка/Производител',
    `country_of_origin` varchar(50) DEFAULT NULL COMMENT 'Страна на произход',
    `expiry_date` date DEFAULT NULL COMMENT 'Срок на годност',
    `is_featured` tinyint(1) DEFAULT 0 COMMENT 'Препоръчан продукт',
    `is_active` tinyint(1) DEFAULT 1 COMMENT 'Дали продуктът е активен',
    `is_digital` tinyint(1) DEFAULT 0 COMMENT 'Дали е дигитален продукт',
    `requires_shipping` tinyint(1) DEFAULT 1 COMMENT 'Изисква ли доставка',
    `tax_rate` decimal(5,2) DEFAULT 0.00 COMMENT 'Данъчна ставка (%)',
    `meta_title` varchar(200) DEFAULT NULL COMMENT 'SEO заглавие',
    `meta_description` varchar(500) DEFAULT NULL COMMENT 'SEO описание',
    `meta_keywords` varchar(300) DEFAULT NULL COMMENT 'SEO ключови думи',
    `views_count` int(11) DEFAULT 0 COMMENT 'Брой прегледи',
    `sales_count` int(11) DEFAULT 0 COMMENT 'Брой продажби',
    `rating_avg` decimal(3,2) DEFAULT 0.00 COMMENT 'Средна оценка',
    `rating_count` int(11) DEFAULT 0 COMMENT 'Брой оценки',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `products_slug_unique` (`slug`),
    UNIQUE KEY `products_sku_unique` (`sku`),
    KEY `idx_products_category` (`category_id`),
    KEY `idx_products_price` (`price`),
    KEY `idx_products_active_featured` (`is_active`, `is_featured`),
    KEY `idx_products_name_active` (`name`, `is_active`),
    KEY `idx_products_stock` (`stock_quantity`),
    KEY `idx_products_brand` (`brand`),
    KEY `idx_products_rating` (`rating_avg`),
    KEY `idx_products_created` (`created_at`),
    CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Продукти в магазина';

-- Създаване на таблица за количка
CREATE TABLE IF NOT EXISTS `cart` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) DEFAULT NULL COMMENT 'ID на потребителя (NULL за гости)',
    `session_id` varchar(255) DEFAULT NULL COMMENT 'ID на сесията за гости',
    `product_id` int(11) NOT NULL COMMENT 'ID на продукта',
    `quantity` int(11) NOT NULL DEFAULT 1 COMMENT 'Количество',
    `price` decimal(10,2) NOT NULL COMMENT 'Цена в момента на добавяне',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_cart_user` (`user_id`),
    KEY `idx_cart_session` (`session_id`),
    KEY `idx_cart_product` (`product_id`),
    KEY `idx_cart_created` (`created_at`),
    CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Количка за пазаруване';

-- Създаване на таблица за поръчки
CREATE TABLE IF NOT EXISTS `orders` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) DEFAULT NULL COMMENT 'ID на потребителя',
    `order_number` varchar(50) NOT NULL COMMENT 'Номер на поръчката',
    `status` enum('pending','processing','shipped','delivered','cancelled','refunded') DEFAULT 'pending' COMMENT 'Статус на поръчката',
    `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending' COMMENT 'Статус на плащането',
    `payment_method` varchar(50) DEFAULT NULL COMMENT 'Метод на плащане',
    `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Междинна сума',
    `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Данък',
    `shipping_amount` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Доставка',
    `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Отстъпка',
    `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Обща сума',
    `currency` varchar(3) DEFAULT 'BGN' COMMENT 'Валута',
    `customer_name` varchar(100) NOT NULL COMMENT 'Име на клиента',
    `customer_email` varchar(100) NOT NULL COMMENT 'Имейл на клиента',
    `customer_phone` varchar(20) DEFAULT NULL COMMENT 'Телефон на клиента',
    `billing_address` json DEFAULT NULL COMMENT 'Адрес за фактуриране',
    `shipping_address` json DEFAULT NULL COMMENT 'Адрес за доставка',
    `notes` text DEFAULT NULL COMMENT 'Бележки към поръчката',
    `shipped_at` timestamp NULL DEFAULT NULL COMMENT 'Дата на изпращане',
    `delivered_at` timestamp NULL DEFAULT NULL COMMENT 'Дата на доставка',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `orders_order_number_unique` (`order_number`),
    KEY `idx_orders_user` (`user_id`),
    KEY `idx_orders_status` (`status`),
    KEY `idx_orders_payment_status` (`payment_status`),
    KEY `idx_orders_created` (`created_at`),
    CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Поръчки';

-- Създаване на таблица за детайли на поръчките
CREATE TABLE IF NOT EXISTS `order_items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `order_id` int(11) NOT NULL COMMENT 'ID на поръчката',
    `product_id` int(11) NOT NULL COMMENT 'ID на продукта',
    `product_name` varchar(150) NOT NULL COMMENT 'Име на продукта (в момента на поръчката)',
    `product_sku` varchar(50) DEFAULT NULL COMMENT 'SKU на продукта',
    `quantity` int(11) NOT NULL COMMENT 'Количество',
    `unit_price` decimal(10,2) NOT NULL COMMENT 'Единична цена',
    `total_price` decimal(10,2) NOT NULL COMMENT 'Обща цена за този артикул',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_order_items_order` (`order_id`),
    KEY `idx_order_items_product` (`product_id`),
    CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Артикули в поръчките';

-- Създаване на таблица за отзиви
CREATE TABLE IF NOT EXISTS `product_reviews` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `product_id` int(11) NOT NULL COMMENT 'ID на продукта',
    `user_id` int(11) NOT NULL COMMENT 'ID на потребителя',
    `rating` tinyint(1) NOT NULL COMMENT 'Оценка (1-5)',
    `title` varchar(200) DEFAULT NULL COMMENT 'Заглавие на отзива',
    `review` text DEFAULT NULL COMMENT 'Текст на отзива',
    `is_approved` tinyint(1) DEFAULT 0 COMMENT 'Дали е одобрен',
    `is_verified_purchase` tinyint(1) DEFAULT 0 COMMENT 'Потвърдена покупка',
    `helpful_votes` int(11) DEFAULT 0 COMMENT 'Полезни гласове',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_reviews_product` (`product_id`),
    KEY `idx_reviews_user` (`user_id`),
    KEY `idx_reviews_rating` (`rating`),
    KEY `idx_reviews_approved` (`is_approved`),
    CONSTRAINT `fk_reviews_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Отзиви за продукти';

-- Създаване на таблица за желани продукти
CREATE TABLE IF NOT EXISTS `wishlists` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL COMMENT 'ID на потребителя',
    `product_id` int(11) NOT NULL COMMENT 'ID на продукта',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `wishlists_user_product_unique` (`user_id`, `product_id`),
    KEY `idx_wishlists_user` (`user_id`),
    KEY `idx_wishlists_product` (`product_id`),
    CONSTRAINT `fk_wishlists_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_wishlists_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Списък с желани продукти';