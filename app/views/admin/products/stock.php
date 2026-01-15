<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Stok: <?= $data['product']['name']; ?></h1>
    <a href="<?= BASEURL; ?>/product" class="btn btn-secondary">Kembali</a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Tambah Stok Akun</div>
            <div class="card-body">
                <form action="<?= BASEURL; ?>/product/addStock" method="POST">
                    <input type="hidden" name="product_id" value="<?= $data['product']['id']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Data Akun</label>
                        <textarea class="form-control" name="account_data" rows="5" placeholder="username:password atau lisensi key" required></textarea>
                        <div class="form-text">Data ini akan dikirim ke pembeli setelah pembayaran.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tambah Stok</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Stok Tersedia (<?= count($data['accounts']); ?>)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Ditambahkan Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['accounts'] as $acc): ?>
                            <tr>
                                <td><?= $acc['id']; ?></td>
                                <td><pre class="mb-0"><?= htmlspecialchars($acc['account_data']); ?></pre></td>
                                <td><?= $acc['created_at']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
