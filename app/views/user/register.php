<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Daftar Akun</h4>
                <?php Flasher::flash(); ?>
                <form action="<?= BASEURL; ?>/user/register" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor HP (WhatsApp)</label>
                        <input type="number" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Daftar</button>
                    <p class="text-center small">Sudah punya akun? <a href="<?= BASEURL; ?>/user/login">Masuk</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
