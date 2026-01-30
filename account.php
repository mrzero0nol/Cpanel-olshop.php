<?php
require_once 'includes/header.php';
require_login();

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<div class="p-6 bg-white min-h-screen">
    <h1 class="text-2xl font-bold mb-6">Profil Saya</h1>

    <div class="flex items-center mb-6">
        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 text-2xl">
            <i class="fas fa-user"></i>
        </div>
        <div class="ml-4">
            <h2 class="font-bold text-lg"><?php echo htmlspecialchars($user['name']); ?></h2>
            <p class="text-gray-500 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-gray-50 p-4 rounded shadow-sm">
            <label class="block text-xs text-gray-500 uppercase">Nomor HP / WA</label>
            <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($user['phone']); ?></p>
        </div>

        <div class="bg-gray-50 p-4 rounded shadow-sm">
            <label class="block text-xs text-gray-500 uppercase">Bergabung Sejak</label>
            <p class="font-semibold text-gray-800"><?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
        </div>
    </div>

    <a href="logout.php" class="block mt-8 w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded text-center">
        Logout
    </a>
</div>

<?php require_once 'includes/bottom_nav.php'; ?>
<?php require_once 'includes/footer.php'; ?>
