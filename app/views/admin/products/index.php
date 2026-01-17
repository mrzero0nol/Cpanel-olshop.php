<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Produk</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASEURL; ?>/product/create" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['products'] as $product): ?>
            <tr>
                <td><?= $product['id']; ?></td>
                <td>
                    <?php if($product['image']): ?>
                        <img src="<?= BASEURL; ?>/assets/img/products/<?= $product['image']; ?>" width="50">
                    <?php endif; ?>
                </td>
                <td><?= $product['name']; ?></td>
                <td><?= $product['category_name']; ?></td>
                <td>Rp <?= number_format($product['price'], 0, ',', '.'); ?></td>
                <td>
                    <a href="<?= BASEURL; ?>/product/stock/<?= $product['id']; ?>" class="btn btn-sm btn-info text-white">Stok</a>
                    <a href="#" class="btn btn-sm btn-warning text-white">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
