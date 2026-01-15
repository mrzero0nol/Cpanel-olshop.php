<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Masuk (Login)</h4>
                <?php Flasher::flash(); ?>
                <form action="<?= BASEURL; ?>/user/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
                    <p class="text-center small">Belum punya akun? <a href="<?= BASEURL; ?>/user/register">Daftar</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
