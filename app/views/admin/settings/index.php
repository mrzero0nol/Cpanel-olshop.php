<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Settings</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <form action="<?= BASEURL; ?>/admin/settings" method="POST">
            <div class="mb-3">
                <label class="form-label">Site Title</label>
                <input type="text" class="form-control" name="site_title" value="<?= $data['settings']['site_title'] ?? ''; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">WhatsApp Admin (For Chat)</label>
                <input type="number" class="form-control" name="wa_number" value="<?= $data['settings']['wa_number'] ?? ''; ?>">
            </div>
             <div class="mb-3">
                <label class="form-label">Banner Image URLs (JSON Format)</label>
                <textarea class="form-control" name="banner_image" rows="3" placeholder='["https://example.com/1.jpg", "https://example.com/2.jpg"]'><?= $data['settings']['banner_image'] ?? ''; ?></textarea>
                <div class="form-text">Gunakan format JSON Array untuk banyak gambar. Contoh: ["url1", "url2"]</div>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</div>
