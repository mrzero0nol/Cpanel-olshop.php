<?php
if (!file_exists('config.php')) {
    die('<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Setup Required</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md text-center">
            <div class="text-6xl mb-4 text-yellow-500"><i class="fas fa-exclamation-circle"></i></div>
            <h1 class="text-2xl font-bold mb-4 text-gray-800">Website Belum Dikonfigurasi</h1>
            <p class="text-gray-600 mb-6">File <code>config.php</code> tidak ditemukan.</p>
            <div class="text-left bg-gray-50 p-4 rounded border text-sm mb-6">
                <strong>Cara Memperbaiki:</strong>
                <ol class="list-decimal ml-5 mt-2 space-y-1">
                    <li>Buka File Manager di cPanel.</li>
                    <li>Cari file bernama <code>config.sample.php</code>.</li>
                    <li>Rename menjadi <code>config.php</code>.</li>
                    <li>Edit file tersebut dan masukkan username, password, dan nama database Anda.</li>
                </ol>
            </div>
            <button onclick="location.reload()" class="bg-blue-500 text-white font-bold py-2 px-6 rounded hover:bg-blue-600">
                Saya Sudah Perbaiki, Refresh Halaman
            </button>
        </div>
    </body>
    </html>');
}

require_once 'includes/header.php';

// Fetch Categories
$cats = $conn->query("SELECT * FROM categories LIMIT 8");

// Fetch Products with Stock Count
$query = "SELECT p.*, COUNT(l.id) as stock
          FROM products p
          LEFT JOIN product_licenses l ON p.id = l.product_id AND l.status = 'available'
          GROUP BY p.id
          ORDER BY p.id DESC";
$products = $conn->query($query);
?>

<!-- Banner -->
<div class="p-4">
    <?php if($banner = get_setting('banner_image')): ?>
        <div class="rounded-xl overflow-hidden shadow-md">
            <img src="<?php echo $banner; ?>" class="w-full h-40 object-cover">
        </div>
    <?php else: ?>
        <div class="rounded-xl overflow-hidden shadow-md bg-blue-500 h-40 flex items-center justify-center text-white">
            <span class="font-bold">Banner Area</span>
        </div>
    <?php endif; ?>
</div>

<!-- Categories -->
<div class="px-4 mb-2">
    <div class="flex space-x-4 overflow-x-auto no-scrollbar pb-2">
        <?php while($c = $cats->fetch_assoc()): ?>
            <div class="flex-shrink-0 flex flex-col items-center w-16">
                <div class="w-12 h-12 bg-white rounded-full shadow flex items-center justify-center mb-1 overflow-hidden">
                    <?php if($c['icon']): ?>
                        <img src="<?php echo $c['icon']; ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i class="fas fa-tag text-gray-400"></i>
                    <?php endif; ?>
                </div>
                <span class="text-[10px] text-gray-600 text-center leading-tight truncate w-full"><?php echo htmlspecialchars($c['name']); ?></span>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Products Grid -->
<div class="p-4 bg-white rounded-t-3xl shadow-[0_-5px_20px_rgba(0,0,0,0.05)] min-h-[500px]">
    <h2 class="font-bold text-gray-800 mb-4 text-lg">Produk Terbaru</h2>

    <div class="grid grid-cols-2 gap-4">
        <?php while($p = $products->fetch_assoc()): ?>
            <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition p-3 relative">
                <!-- Stock Badge -->
                <?php if($p['stock'] > 0): ?>
                    <div class="absolute top-2 right-2 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded-full">
                        Sisa <?php echo $p['stock']; ?>
                    </div>
                <?php else: ?>
                    <div class="absolute top-2 right-2 bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded-full">
                        Habis
                    </div>
                <?php endif; ?>

                <div class="w-full h-24 bg-gray-100 rounded mb-2 overflow-hidden flex items-center justify-center">
                    <?php if($p['image']): ?>
                        <img src="<?php echo $p['image']; ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i class="fas fa-box text-gray-300 text-3xl"></i>
                    <?php endif; ?>
                </div>

                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 mb-1"><?php echo htmlspecialchars($p['name']); ?></h3>

                <div class="flex items-center justify-between mt-2">
                    <span class="text-blue-600 font-bold text-sm">Rp <?php echo number_format($p['price'], 0, ',', '.'); ?></span>
                </div>

                <a href="checkout.php?product_id=<?php echo $p['id']; ?>" class="block mt-2 text-center <?php echo $p['stock'] > 0 ? 'bg-blue-500 hover:bg-blue-600' : 'bg-gray-300 cursor-not-allowed'; ?> text-white text-xs font-bold py-2 rounded">
                    <?php echo $p['stock'] > 0 ? 'Beli Sekarang' : 'Stok Habis'; ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once 'includes/bottom_nav.php'; ?>
<?php require_once 'includes/footer.php'; ?>
