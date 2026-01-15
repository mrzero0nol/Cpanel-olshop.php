<?php
require_once 'layout_header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
    flash('prod_msg', 'Produk berhasil dihapus!');
    redirect('products.php');
}

$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
$result = $conn->query($query);
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Produk</h1>
    <a href="product_form.php" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

<?php echo flash('prod_msg'); ?>

<div class="bg-white rounded shadow-md overflow-x-auto">
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Gambar</th>
                <th class="py-3 px-6 text-left">Nama</th>
                <th class="py-3 px-6 text-left">Kategori</th>
                <th class="py-3 px-6 text-left">Harga</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap"><?php echo $row['id']; ?></td>
                <td class="py-3 px-6 text-left">
                    <?php if($row['image']): ?>
                        <img src="../<?php echo $row['image']; ?>" class="w-10 h-10 rounded border object-cover">
                    <?php else: ?>
                        <span class="text-gray-400">No Image</span>
                    <?php endif; ?>
                </td>
                <td class="py-3 px-6 text-left font-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['category_name'] ?? '-'); ?></td>
                <td class="py-3 px-6 text-left">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                <td class="py-3 px-6 text-center">
                    <div class="flex item-center justify-center">
                        <a href="product_form.php?id=<?php echo $row['id']; ?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="licenses.php?product_id=<?php echo $row['id']; ?>" class="w-4 mr-2 transform hover:text-green-500 hover:scale-110" title="Kelola Stok/Lisensi">
                            <i class="fas fa-key"></i>
                        </a>
                        <a href="products.php?delete=<?php echo $row['id']; ?>" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110" onclick="return confirm('Yakin ingin menghapus?');" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once 'layout_footer.php'; ?>
