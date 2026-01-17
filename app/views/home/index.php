<!-- Search Bar -->
<div class="search-container mb-3">
    <form action="<?= BASEURL; ?>" method="GET">
        <div class="position-relative">
            <i class="fas fa-search position-absolute text-muted" style="top: 15px; left: 15px;"></i>
            <input type="text" name="q" class="search-bar ps-5" placeholder="Cari produk digital..." value="<?= $data['search_query'] ?? ''; ?>">
        </div>
    </form>
</div>

<!-- Banner -->
<div class="banner-slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach($data['banners'] as $index => $banner): ?>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $index; ?>" class="<?= $index === 0 ? 'active' : ''; ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="carousel-inner">
            <?php foreach($data['banners'] as $index => $banner): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                <img src="<?= trim($banner); ?>" class="d-block w-100" alt="Banner" style="height: 180px; object-fit: cover;">
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Categories -->
<div class="d-flex justify-content-between align-items-center mb-3 px-1">
    <h6 class="fw-bold m-0" style="font-size: 16px;">Kategori</h6>
    <a href="#" class="text-decoration-none small fw-semibold">Lihat Semua</a>
</div>
<div class="row mb-4 gx-3">
    <?php if(!empty($data['categories'])): ?>
    <?php foreach($data['categories'] as $cat): ?>
    <div class="col-3 col-md-3">
        <a href="#" class="category-item">
            <div class="category-icon">
                <i class="<?= $cat['icon'] ?: 'fas fa-gamepad'; ?>"></i>
            </div>
            <span class="small fw-medium text-truncate d-block"><?= $cat['name']; ?></span>
        </a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="col-12 text-center py-3"><small class="text-muted">Belum ada kategori.</small></div>
    <?php endif; ?>
</div>

<!-- Products -->
<h6 class="fw-bold mb-3 px-1" style="font-size: 16px;">
    <?= isset($data['is_search']) && $data['is_search'] ? 'Hasil Pencarian: "' . htmlspecialchars($data['search_query']) . '"' : 'Produk Populer'; ?>
</h6>
<div class="row g-3">
    <?php if(!empty($data['products'])): ?>
    <?php foreach($data['products'] as $product): ?>
    <div class="col-6 col-md-6">
        <a href="<?= BASEURL; ?>/shop/detail/<?= $product['slug']; ?>" class="product-card">
            <?php if(isset($product['original_price']) && $product['original_price'] > $product['price']):
                $discount = round((($product['original_price'] - $product['price']) / $product['original_price']) * 100);
            ?>
            <div class="discount-badge">-<?= $discount; ?>%</div>
            <?php endif; ?>

            <img src="<?= $product['image'] ? BASEURL . '/assets/img/products/' . $product['image'] : 'https://via.placeholder.com/300x300?text=No+Image'; ?>" class="product-img" alt="<?= $product['name']; ?>">
            <div class="p-3">
                <h6 class="card-title small fw-semibold mb-2 text-truncate" style="line-height: 1.4;"><?= $product['name']; ?></h6>
                <div class="d-flex flex-column">
                     <?php if(isset($product['original_price']) && $product['original_price'] > $product['price']): ?>
                        <span class="text-decoration-line-through text-muted" style="font-size: 11px;">Rp <?= number_format($product['original_price'], 0, ',', '.'); ?></span>
                    <?php endif; ?>
                    <span class="text-primary fw-bold">Rp <?= number_format($product['price'], 0, ',', '.'); ?></span>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="col-12 text-center py-5">
        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
        <p class="text-muted">Produk tidak ditemukan.</p>
    </div>
    <?php endif; ?>
</div>
