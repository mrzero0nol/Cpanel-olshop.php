<div class="row">
    <div class="col-md-12">
        <h2>Selamat Datang, Admin</h2>
        <p>Kelola produk dan transaksi toko Anda di sini.</p>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Produk</div>
            <div class="card-body">
                <h5 class="card-title">Kelola Produk</h5>
                <p class="card-text">Tambah, edit, atau hapus produk digital.</p>
                <a href="<?= BASEURL; ?>/product" class="btn btn-light">Ke Produk</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Transaksi</div>
            <div class="card-body">
                <h5 class="card-title">Lihat Penjualan</h5>
                <p class="card-text">Cek status pesanan dan pendapatan.</p>
                <a href="<?= BASEURL; ?>/transaction" class="btn btn-light">Lihat Transaksi</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Pendapatan</div>
            <div class="card-body">
                <h5 class="card-title">Laporan</h5>
                <p class="card-text">Total Pendapatan Bulan Ini: Rp <?= number_format($data['income_month'] ?? 0, 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>
</div>
