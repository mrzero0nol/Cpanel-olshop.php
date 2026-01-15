<div class="row">
    <div class="col-md-5 mb-3">
        <img src="<?= $data['product']['image'] ? BASEURL . '/assets/img/products/' . $data['product']['image'] : 'https://via.placeholder.com/400'; ?>" class="w-100 rounded shadow-sm">
    </div>
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h4 class="fw-bold"><?= $data['product']['name']; ?></h4>

                <?php if(isset($data['product']['original_price']) && $data['product']['original_price'] > $data['product']['price']): ?>
                    <div class="text-decoration-line-through text-muted">Rp <?= number_format($data['product']['original_price'], 0, ',', '.'); ?></div>
                <?php endif; ?>

                <h3 class="text-primary fw-bold my-2">Rp <?= number_format($data['product']['price'], 0, ',', '.'); ?></h3>
                <p class="text-muted"><?= nl2br($data['product']['description']); ?></p>

                <hr>

                <?php if(isset($data['stock_count']) && $data['stock_count'] == 0): ?>
                    <div class="alert alert-danger">Stok Habis</div>
                <?php else: ?>

                <form action="<?= BASEURL; ?>/checkout/process" method="POST">
                    <input type="hidden" name="product_id" value="<?= $data['product']['id']; ?>">

                    <h6 class="fw-bold">Info Kontak</h6>
                    <div class="mb-3">
                        <label class="form-label small">Nomor WhatsApp</label>
                        <input type="number" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required value="<?= isset($_SESSION['user_id']) ? '' : ''; // Could prefill if user logged in ?>">
                    </div>

                    <h6 class="fw-bold mt-4">Metode Pembayaran</h6>
                    <div class="mb-3">
                        <select class="form-select" name="payment_method" required>
                            <option value="qris">QRIS (GoPay, OVO, Dana, dll)</option>
                            <option value="bni_va">BNI Virtual Account</option>
                            <option value="bri_va">BRI Virtual Account</option>
                            <option value="cimb_niaga_va">CIMB Niaga VA</option>
                            <option value="mandiri_va">Mandiri VA</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2">
                        Beli Sekarang
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
