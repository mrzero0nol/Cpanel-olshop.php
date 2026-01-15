<?php
require_once 'layout_header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM categories WHERE id = $id");
    flash('cat_msg', 'Kategori berhasil dihapus!');
    redirect('categories.php');
}

$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Kategori</h1>
    <a href="category_form.php" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
</div>

<?php echo flash('cat_msg'); ?>

<div class="bg-white rounded shadow-md overflow-x-auto">
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Icon</th>
                <th class="py-3 px-6 text-left">Nama</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap"><?php echo $row['id']; ?></td>
                <td class="py-3 px-6 text-left">
                    <?php if($row['icon']): ?>
                        <img src="../<?php echo $row['icon']; ?>" class="w-10 h-10 rounded-full border">
                    <?php else: ?>
                        <span class="text-gray-400">No Icon</span>
                    <?php endif; ?>
                </td>
                <td class="py-3 px-6 text-left font-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                <td class="py-3 px-6 text-center">
                    <div class="flex item-center justify-center">
                        <a href="category_form.php?id=<?php echo $row['id']; ?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="categories.php?delete=<?php echo $row['id']; ?>" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110" onclick="return confirm('Yakin ingin menghapus?');">
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
