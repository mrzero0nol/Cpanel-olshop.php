<?php
require_once 'layout_header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM product_licenses WHERE id = $id AND status = 'available'"); // Only delete available ones for safety
    flash('lic_msg', 'Lisensi berhasil dihapus!');
    // Redirect to preserve query string if possible, or just back to main
    redirect('licenses.php' . (isset($_GET['product_id']) ? '?product_id='.$_GET['product_id'] : ''));
}

// Handle Add
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product_id'];
    $data_raw = $_POST['licenses'];

    $lines = explode("\n", $data_raw);
    $count = 0;

    $stmt = $conn->prepare("INSERT INTO product_licenses (product_id, license_data, status) VALUES (?, ?, 'available')");

    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line)) {
            $stmt->bind_param("is", $product_id, $line);
            $stmt->execute();
            $count++;
        }
    }

    flash('lic_msg', "$count Stok/Lisensi berhasil ditambahkan!", 'success');
}

// Filter
$product_filter = isset($_GET['product_id']) ? (int)$_GET['product_id'] : null;
$where = $product_filter ? "WHERE l.product_id = $product_filter" : "";

$query = "SELECT l.*, p.name as product_name, u.name as buyer_name
          FROM product_licenses l
          JOIN products p ON l.product_id = p.id
          LEFT JOIN orders o ON l.order_id = o.id
          LEFT JOIN users u ON o.user_id = u.id
          $where
          ORDER BY l.id DESC LIMIT 100";
$result = $conn->query($query);

// Fetch Products for Dropdown
$prods = $conn->query("SELECT id, name FROM products");
?>

<h1 class="text-3xl font-bold mb-6">Kelola Stok / Lisensi</h1>

<?php echo flash('lic_msg'); ?>

<!-- Add Form -->
<div class="bg-white p-6 rounded shadow-md mb-8">
    <h3 class="text-xl font-bold mb-4">Tambah Stok</h3>
    <form method="POST" action="">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Pilih Produk</label>
                <select name="product_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php
                    $prods->data_seek(0);
                    while($p = $prods->fetch_assoc()):
                    ?>
                        <option value="<?php echo $p['id']; ?>" <?php echo $product_filter == $p['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($p['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Data Lisensi / Akun</label>
                <textarea name="licenses" class="w-full border rounded px-3 py-2 h-24" placeholder="Masukkan data satu per baris (contoh: user|pass)"></textarea>
                <p class="text-xs text-gray-500 mt-1">Satu baris = satu stok.</p>
            </div>
        </div>
        <button type="submit" class="mt-4 bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
            Tambah Stok
        </button>
    </form>
</div>

<!-- List -->
<div class="bg-white rounded shadow-md overflow-x-auto">
    <div class="p-4 border-b">
        <h3 class="text-lg font-bold">Daftar Stok Terakhir (Max 100)</h3>
        <?php if($product_filter): ?>
            <a href="licenses.php" class="text-blue-500 text-sm">Lihat Semua</a>
        <?php endif; ?>
    </div>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Produk</th>
                <th class="py-3 px-6 text-left">Data</th>
                <th class="py-3 px-6 text-center">Status</th>
                <th class="py-3 px-6 text-left">Pembeli</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap"><?php echo $row['id']; ?></td>
                <td class="py-3 px-6 text-left font-bold"><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td class="py-3 px-6 text-left font-mono text-xs">
                    <?php echo substr(htmlspecialchars($row['license_data']), 0, 50) . (strlen($row['license_data'])>50 ? '...' : ''); ?>
                </td>
                <td class="py-3 px-6 text-center">
                    <?php if($row['status'] == 'available'): ?>
                        <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Available</span>
                    <?php else: ?>
                        <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Sold</span>
                    <?php endif; ?>
                </td>
                <td class="py-3 px-6 text-left">
                    <?php echo $row['buyer_name'] ? htmlspecialchars($row['buyer_name']) : '-'; ?>
                </td>
                <td class="py-3 px-6 text-center">
                    <?php if($row['status'] == 'available'): ?>
                        <a href="licenses.php?delete=<?php echo $row['id']; ?>&product_id=<?php echo $product_filter; ?>" class="transform hover:text-red-500 hover:scale-110" onclick="return confirm('Hapus stok ini?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    <?php else: ?>
                        <span class="text-gray-400"><i class="fas fa-lock"></i></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once 'layout_footer.php'; ?>
