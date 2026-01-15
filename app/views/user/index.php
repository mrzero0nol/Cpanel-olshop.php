<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="bg-light rounded-circle p-3 me-3">
                    <i class="fas fa-user fa-2x text-primary"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0"><?= $data['user']['name']; ?></h5>
                    <p class="text-muted small mb-0"><?= $data['user']['email']; ?></p>
                </div>
            </div>
        </div>

        <div class="list-group shadow-sm border-0 mb-4">
            <a href="<?= BASEURL; ?>/user/assets" class="list-group-item list-group-item-action py-3">
                <i class="fas fa-box-open text-primary me-2"></i> Aset Saya (Produk Digital)
            </a>
            <a href="#" class="list-group-item list-group-item-action py-3">
                <i class="fas fa-history text-primary me-2"></i> Riwayat Transaksi
            </a>
            <a href="<?= BASEURL; ?>/user/logout" class="list-group-item list-group-item-action py-3 text-danger">
                <i class="fas fa-sign-out-alt me-2"></i> Keluar
            </a>
        </div>
    </div>
</div>
