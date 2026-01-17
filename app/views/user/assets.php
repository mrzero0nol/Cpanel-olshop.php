<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Aset Saya</h4>
    <a href="<?= BASEURL; ?>/user" class="btn btn-sm btn-outline-secondary">Kembali</a>
</div>

<?php if(empty($data['assets'])): ?>
    <div class="alert alert-info">Anda belum membeli produk apapun.</div>
<?php else: ?>
    <?php foreach($data['assets'] as $asset): ?>
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h6 class="fw-bold"><?= $asset['product_name']; ?></h6>
                <span class="badge bg-success">Aktif</span>
            </div>
            <div class="bg-light p-3 rounded">
                <small class="text-muted d-block mb-1">Data Akun:</small>
                <pre class="mb-0 fw-bold"><?= htmlspecialchars($asset['account_data']); ?></pre>
            </div>
            <div class="mt-2 text-muted small text-end">
                ID Pesanan: <?= $asset['order_number']; ?> | Tanggal: <?= date('d M Y', strtotime($asset['created_at'])); ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
