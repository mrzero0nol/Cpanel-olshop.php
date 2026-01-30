<?php
require_once 'layout_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$name = '';
$category_id = '';
$description = '';
$price = '';
$image = '';

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $name = $row['name'];
        $category_id = $row['category_id'];
        $description = $row['description'];
        $price = $row['price'];
        $image = $row['image'];
    }
}

// Fetch Categories for Dropdown
$cats = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($conn, $_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $description = sanitize($conn, $_POST['description']);
    $price = (float)$_POST['price'];

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        if (validate_image($_FILES['image'])) {
            $target_dir = "../assets/uploads/";
            $filename = "prod_" . time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $filename;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = "assets/uploads/" . $filename;
            }
        } else {
             // Handle error - maybe set a flash message and stop?
             // For now just skip upload or maybe error out.
             // I'll skip logic so it doesn't break, but ideally user should know.
             // But since I'm redirecting after... I'll let it fail silently or use flash?
             // Since I redirect on success at end, I should probably block the save if invalid.
             $image_error = "Format gambar tidak valid";
        }
    }

    if (isset($image_error)) {
        // Show error and don't save
        echo '<div class="bg-red-100 text-red-700 p-4 mb-4">Error: ' . $image_error . '</div>';
    } else {

    if ($id) {
        $stmt = $conn->prepare("UPDATE products SET name=?, category_id=?, description=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("sisdsi", $name, $category_id, $description, $price, $image, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, category_id, description, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisds", $name, $category_id, $description, $price, $image);
    }

        if ($stmt->execute()) {
            flash('prod_msg', 'Produk berhasil disimpan!');
            redirect('products.php');
        } else {
            echo '<div class="bg-red-100 text-red-700 p-4 mb-4">Error: ' . $conn->error . '</div>';
        }
    }
}
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold"><?php echo $id ? 'Edit' : 'Tambah'; ?> Produk</h1>
    <a href="products.php" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-700">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form method="POST" action="" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md max-w-2xl">
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Nama Produk</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Kategori</label>
        <select name="category_id" class="w-full border rounded px-3 py-2">
            <option value="">Pilih Kategori</option>
            <?php while($c = $cats->fetch_assoc()): ?>
                <option value="<?php echo $c['id']; ?>" <?php echo $c['id'] == $category_id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($c['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
        <input type="number" name="price" value="<?php echo $price; ?>" class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
        <textarea name="description" class="w-full border rounded px-3 py-2 h-32"><?php echo htmlspecialchars($description); ?></textarea>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Gambar Produk</label>
        <?php if($image): ?>
            <img src="../<?php echo $image; ?>" class="w-32 h-32 mb-2 rounded border object-cover">
        <?php endif; ?>
        <input type="file" name="image" class="w-full">
    </div>

    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
        Simpan
    </button>
</form>

<?php require_once 'layout_footer.php'; ?>
