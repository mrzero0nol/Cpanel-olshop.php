<?php
require_once 'includes/header.php';
require_login();

$user_id = $_SESSION['user_id'];
$query = "SELECT l.license_data, p.name, o.created_at, o.id as order_id
          FROM product_licenses l
          JOIN orders o ON l.order_id = o.id
          JOIN products p ON l.product_id = p.id
          WHERE o.user_id = ? AND o.status = 'paid'
          ORDER BY o.id DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="p-4 bg-gray-50 min-h-screen pb-24">
    <h1 class="text-2xl font-bold mb-4">Aset Digital Saya</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="space-y-4">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="mb-2 border-b pb-2">
                        <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <span class="text-xs text-gray-500">Order #<?php echo $row['order_id']; ?> &bull; <?php echo date('d M Y', strtotime($row['created_at'])); ?></span>
                    </div>

                    <div class="bg-gray-800 text-green-400 p-3 rounded font-mono text-sm break-all relative group">
                        <?php echo nl2br(htmlspecialchars($row['license_data'])); ?>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 text-right">Aset ini bersifat rahasia. Jangan bagikan ke orang lain.</p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center h-64 text-gray-400">
            <i class="fas fa-key text-4xl mb-2"></i>
            <p>Belum ada aset digital</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/bottom_nav.php'; ?>
<?php require_once 'includes/footer.php'; ?>
