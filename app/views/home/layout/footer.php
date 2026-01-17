</div> <!-- Container end -->

<div class="bottom-nav">
    <a href="<?= BASEURL; ?>" class="nav-item <?= (!isset($_GET['url']) || $_GET['url'] == 'home') ? 'active' : ''; ?>">
        <i class="fas fa-home"></i> Beranda
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-search"></i> Cari
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-receipt"></i> Pesanan
    </a>
    <a href="<?= BASEURL; ?>/user" class="nav-item">
        <i class="fas fa-user"></i> Saya
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
