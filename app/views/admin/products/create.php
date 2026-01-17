<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Produk</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="<?= BASEURL; ?>/product/store" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <div class="input-group">
                    <select class="form-select" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach($data['categories'] as $cat): ?>
                            <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Tambah Kategori</button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" name="price" required>
            </div>
             <div class="mb-3">
                <label class="form-label">Harga Asli (Coret) - Opsional</label>
                <input type="number" class="form-control" name="original_price" placeholder="Isi jika ada diskon">
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="is_active" id="isActive" checked>
                <label class="form-check-label" for="isActive">Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Produk</button>
            <a href="<?= BASEURL; ?>/product" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<!-- Modal Add Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= BASEURL; ?>/product/addCategory" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" name="name" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
