<?php
require_once 'layout_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$name = '';
$icon = '';

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $name = $row['name'];
        $icon = $row['icon'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($conn, $_POST['name']);

    // Handle Icon Upload
    if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
        if (validate_image($_FILES['icon'])) {
            $target_dir = "../assets/uploads/";
            $filename = "cat_" . time() . "_" . basename($_FILES["icon"]["name"]);
            $target_file = $target_dir . $filename;
            if (move_uploaded_file($_FILES["icon"]["tmp_name"], $target_file)) {
                $icon = "assets/uploads/" . $filename;
            }
        } else {
             $icon_error = "Format gambar tidak valid";
        }
    }

    if (isset($icon_error)) {
        echo '<div class="bg-red-100 text-red-700 p-4 mb-4">Error: ' . $icon_error . '</div>';
    } else {

    if ($id) {
        $stmt = $conn->prepare("UPDATE categories SET name=?, icon=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $icon, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name, icon) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $icon);
    }

        if ($stmt->execute()) {
            flash('cat_msg', 'Kategori berhasil disimpan!');
            redirect('categories.php');
        } else {
            echo '<div class="bg-red-100 text-red-700 p-4 mb-4">Error: ' . $conn->error . '</div>';
        }
    }
}
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold"><?php echo $id ? 'Edit' : 'Tambah'; ?> Kategori</h1>
    <a href="categories.php" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-700">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form method="POST" action="" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md max-w-lg">
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Icon (Upload Gambar)</label>
        <?php if($icon): ?>
            <img src="../<?php echo $icon; ?>" class="w-16 h-16 mb-2 rounded border">
        <?php endif; ?>
        <input type="file" name="icon" class="w-full">
    </div>

    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
        Simpan
    </button>
</form>

<?php require_once 'layout_footer.php'; ?>
