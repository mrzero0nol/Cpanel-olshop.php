<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Konfirmasi Pembayaran</h5>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">ID Pesanan: <?= $data['order']['order_number']; ?></p>
                <h2 class="fw-bold text-primary">Rp <?= number_format($data['payment']['total_payment'], 0, ',', '.'); ?></h2>
                <p class="small text-danger">Mohon bayar sesuai nominal hingga digit terakhir.</p>

                <hr>

                <?php if($data['payment']['payment_method'] == 'qris'): ?>
                    <h5>Scan QRIS</h5>
                    <div class="my-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= urlencode($data['payment']['payment_number']); ?>" alt="QR Code" class="img-fluid border p-2">
                    </div>
                    <p class="small text-muted">Mendukung GoPay, OVO, Dana, ShopeePay, BCA, dll.</p>
                <?php else: ?>
                    <h5>Nomor Virtual Account</h5>
                    <div class="alert alert-secondary fs-4 fw-bold">
                        <?= $data['payment']['payment_number']; ?>
                    </div>
                    <p class="small text-muted">Bank: <?= strtoupper(str_replace('_va', '', $data['payment']['payment_method'])); ?></p>
                <?php endif; ?>

                <div class="alert alert-warning small">
                    Berakhir: <?= date('d M Y H:i', strtotime($data['payment']['expired_at'])); ?>
                </div>

                <a href="<?= BASEURL; ?>/checkout/pay/<?= $data['order']['order_number']; ?>" class="btn btn-outline-primary w-100">Cek Status</a>
            </div>
        </div>
    </div>
</div>
