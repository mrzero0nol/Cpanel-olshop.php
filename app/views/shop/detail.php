<div class="row g-0">
    <div class="col-md-5 mb-3">
        <img src="<?= $data['product']['image'] ? BASEURL . '/assets/img/products/' . $data['product']['image'] : 'https://via.placeholder.com/400'; ?>" class="w-100 shadow-sm" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
    </div>
    <div class="col-md-7 px-3">
        <div class="card border-0 mb-5 bg-transparent">
            <div class="card-body p-0">
                <div class="d-flex justify-content-between align-items-start">
                    <h4 class="fw-bold mb-1"><?= $data['product']['name']; ?></h4>
                    <span class="badge bg-light text-dark border">Digital</span>
                </div>

                <div class="my-3">
                    <?php if(isset($data['product']['original_price']) && $data['product']['original_price'] > $data['product']['price']): ?>
                        <span class="text-decoration-line-through text-muted me-2">Rp <?= number_format($data['product']['original_price'], 0, ',', '.'); ?></span>
                        <span class="badge bg-danger bg-opacity-10 text-danger small">Hemat Rp <?= number_format($data['product']['original_price'] - $data['product']['price'], 0, ',', '.'); ?></span>
                    <?php endif; ?>
                    <h2 class="text-primary fw-bold mt-1">Rp <?= number_format($data['product']['price'], 0, ',', '.'); ?></h2>
                </div>

                <div class="card bg-white border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2"><i class="fas fa-align-left text-primary me-2"></i>Deskripsi</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.6;"><?= nl2br($data['product']['description']); ?></p>
                    </div>
                </div>

                <?php if(isset($data['stock_count']) && $data['stock_count'] == 0): ?>
                    <div class="alert alert-danger rounded-4 text-center fw-bold py-3">Stok Habis</div>
                <?php else: ?>

                <form action="<?= BASEURL; ?>/checkout/process" method="POST" id="checkoutForm">
                    <input type="hidden" name="product_id" value="<?= $data['product']['id']; ?>">

                    <div class="card bg-white border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="fas fa-user-circle text-primary me-2"></i>Info Pembeli</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Nomor WhatsApp</label>
                                <input type="number" name="phone" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: 08123456789" required value="<?= isset($_SESSION['user_id']) ? '' : ''; ?>">
                                <div class="form-text small">Produk akan dikirim otomatis ke nomor ini (jika fitur WA aktif) dan riwayat transaksi.</div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white border-0 shadow-sm rounded-4 mb-5">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="fas fa-wallet text-primary me-2"></i>Metode Pembayaran</h6>

                            <div class="list-group list-group-flush">
                                <label class="list-group-item d-flex align-items-center gap-3 p-3 border rounded-3 mb-2 cursor-pointer">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="qris" checked>
                                    <div class="d-flex align-items-center w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0 fw-bold">QRIS</h6>
                                            <small class="text-muted">GoPay, OVO, Dana, ShopeePay, LinkAja</small>
                                        </div>
                                        <i class="fas fa-qrcode fa-2x text-muted"></i>
                                    </div>
                                </label>

                                <label class="list-group-item d-flex align-items-center gap-3 p-3 border rounded-3 mb-2 cursor-pointer">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="bni_va">
                                    <div class="d-flex align-items-center w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0 fw-bold">BNI Virtual Account</h6>
                                            <small class="text-muted">Cek Otomatis</small>
                                        </div>
                                        <i class="fas fa-university fa-2x text-muted"></i>
                                    </div>
                                </label>

                                <label class="list-group-item d-flex align-items-center gap-3 p-3 border rounded-3 mb-2 cursor-pointer">
                                    <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="bri_va">
                                    <div class="d-flex align-items-center w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0 fw-bold">BRI Virtual Account</h6>
                                            <small class="text-muted">Cek Otomatis</small>
                                        </div>
                                        <i class="fas fa-university fa-2x text-muted"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Sticky Button -->
                    <div class="fixed-bottom bg-white border-top p-3 shadow-lg" style="z-index: 1050;">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <small class="text-muted d-block">Total Bayar</small>
                                    <h5 class="fw-bold text-primary mb-0">Rp <?= number_format($data['product']['price'], 0, ',', '.'); ?></h5>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                                        Beli Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hide bottom nav on detail page to avoid clash with sticky buy button */
    .bottom-nav { display: none !important; }
    body { padding-bottom: 100px; }
</style>
