<?php
require_once 'layout_header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keys = ['site_title', 'site_description', 'wa_number', 'pakasir_apikey', 'pakasir_slug'];

    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            $val = sanitize($conn, $_POST[$key]);
            $conn->query("INSERT INTO site_settings (setting_key, setting_value) VALUES ('$key', '$val') ON DUPLICATE KEY UPDATE setting_value='$val'");
        }
    }

    // Handle Banner Upload
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
        if (validate_image($_FILES['banner_image'])) {
            $target_dir = "../assets/uploads/";
            $filename = "banner_" . time() . "_" . basename($_FILES["banner_image"]["name"]);
            $target_file = $target_dir . $filename;
            if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) {
                $path = "assets/uploads/" . $filename;
                $conn->query("INSERT INTO site_settings (setting_key, setting_value) VALUES ('banner_image', '$path') ON DUPLICATE KEY UPDATE setting_value='$path'");
            }
        } else {
             flash('settings_msg', 'Format banner harus gambar (jpg, png, gif, webp)', 'red');
        }
    }

    // Handle Favicon Upload
    if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] == 0) {
        if (validate_image($_FILES['favicon'])) {
            $target_dir = "../assets/uploads/";
            $filename = "favicon_" . time() . "_" . basename($_FILES["favicon"]["name"]);
            $target_file = $target_dir . $filename;
            if (move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_file)) {
                 $path = "assets/uploads/" . $filename;
                 $conn->query("INSERT INTO site_settings (setting_key, setting_value) VALUES ('favicon', '$path') ON DUPLICATE KEY UPDATE setting_value='$path'");
            }
        } else {
             flash('settings_msg', 'Format favicon harus gambar (jpg, png, gif, webp)', 'red');
        }
    }

    $message = flash('settings_msg', 'Pengaturan berhasil disimpan!', 'success');
} else {
    $message = flash('settings_msg');
}

?>

<h1 class="text-3xl font-bold mb-6">Pengaturan Website</h1>

<?php echo $message; ?>

<form method="POST" action="" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- General Settings -->
        <div>
            <h3 class="text-xl font-bold mb-4 border-b pb-2">Umum</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Judul Website</label>
                <input type="text" name="site_title" value="<?php echo get_setting('site_title'); ?>" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Deskripsi Website</label>
                <textarea name="site_description" class="w-full border rounded px-3 py-2"><?php echo get_setting('site_description'); ?></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nomor WhatsApp Admin</label>
                <input type="text" name="wa_number" value="<?php echo get_setting('wa_number'); ?>" class="w-full border rounded px-3 py-2" placeholder="628xxx">
            </div>
        </div>

        <!-- Integration Settings -->
        <div>
            <h3 class="text-xl font-bold mb-4 border-b pb-2">Integrasi Pakasir</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Pakasir API Key</label>
                <input type="text" name="pakasir_apikey" value="<?php echo get_setting('pakasir_apikey'); ?>" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Pakasir Project Slug</label>
                <input type="text" name="pakasir_slug" value="<?php echo get_setting('pakasir_slug'); ?>" class="w-full border rounded px-3 py-2">
            </div>
        </div>
    </div>

    <div class="mt-6 border-t pt-4">
        <h3 class="text-xl font-bold mb-4">Media</h3>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Banner Utama (Home)</label>
            <?php if($banner = get_setting('banner_image')): ?>
                <img src="../<?php echo $banner; ?>" class="h-24 w-auto mb-2 rounded border">
            <?php endif; ?>
            <input type="file" name="banner_image" class="w-full">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Favicon</label>
            <?php if($favicon = get_setting('favicon')): ?>
                <img src="../<?php echo $favicon; ?>" class="h-10 w-10 mb-2 rounded border">
            <?php endif; ?>
            <input type="file" name="favicon" class="w-full">
        </div>
    </div>

    <div class="mt-6">
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Simpan Pengaturan</button>
    </div>

</form>

<?php require_once 'layout_footer.php'; ?>
