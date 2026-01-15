<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body">
                <div class="text-success mb-3">
                    <i class="fas fa-check-circle fa-4x"></i>
                </div>
                <h4 class="fw-bold">Pembayaran Berhasil!</h4>
                <p class="text-muted">Terima kasih telah berbelanja.</p>

                <div class="card bg-light border-0 mt-4 text-start">
                    <div class="card-body">
                        <h6 class="fw-bold">Detail Produk Anda:</h6>
                        <?php if($data['account']): ?>
                            <div class="alert alert-info mb-0">
                                <pre class="mb-0 fs-5"><?= htmlspecialchars($data['account']['account_data']); ?></pre>
                            </div>
                            <p class="small text-muted mt-2">Simpan informasi ini dengan aman. Anda juga bisa melihatnya di menu 'Saya' jika sudah login.</p>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Sedang memproses pengiriman produk... Jika tidak muncul, hubungi admin dengan Order ID: <?= $data['order']['order_number']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="<?= BASEURL; ?>" class="btn btn-primary w-100">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>
