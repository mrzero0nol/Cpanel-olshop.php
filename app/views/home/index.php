<!-- Search Bar -->
<div class="mb-3">
    <form action="<?= BASEURL; ?>" method="GET">
        <input type="text" name="q" class="search-bar" placeholder="Cari produk..." value="<?= $data['search_query'] ?? ''; ?>">
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
                <img src="<?= trim($banner); ?>" class="d-block w-100" alt="Banner">
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Categories -->
<div class="d-flex justify-content-between align-items-center mb-2">
    <h6 class="fw-bold m-0">Kategori</h6>
    <a href="#" class="text-decoration-none small">Lihat Semua</a>
</div>
<div class="row mb-4">
    <?php if(!empty($data['categories'])): ?>
    <?php foreach($data['categories'] as $cat): ?>
    <div class="col-3 col-md-2">
        <a href="#" class="category-item">
            <div class="category-icon">
                <i class="<?= $cat['icon'] ?: 'fas fa-gamepad'; ?>"></i>
            </div>
            <span class="small"><?= $cat['name']; ?></span>
        </a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="col-12"><small class="text-muted">Belum ada kategori.</small></div>
    <?php endif; ?>
</div>

<!-- Products -->
<h6 class="fw-bold mb-3">
    <?= isset($data['is_search']) && $data['is_search'] ? 'Hasil Pencarian: "' . htmlspecialchars($data['search_query']) . '"' : 'Produk Populer'; ?>
</h6>
<div class="row g-3">
    <?php if(!empty($data['products'])): ?>
    <?php foreach($data['products'] as $product): ?>
    <div class="col-6 col-md-3">
        <a href="<?= BASEURL; ?>/shop/detail/<?= $product['slug']; ?>" class="product-card">
            <img src="<?= $product['image'] ? BASEURL . '/assets/img/products/' . $product['image'] : 'https://via.placeholder.com/150'; ?>" class="product-img" alt="<?= $product['name']; ?>">
            <div class="p-2">
                <h6 class="card-title small mb-1 text-truncate"><?= $product['name']; ?></h6>
                <div class="d-flex flex-column">
                     <?php if(isset($product['original_price']) && $product['original_price'] > $product['price']): ?>
                        <span class="text-decoration-line-through text-muted" style="font-size: 10px;">Rp <?= number_format($product['original_price'], 0, ',', '.'); ?></span>
                    <?php endif; ?>
                    <span class="text-primary fw-bold small">Rp <?= number_format($product['price'], 0, ',', '.'); ?></span>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="col-12"><small class="text-muted">Produk tidak tersedia.</small></div>
    <?php endif; ?>
</div>
