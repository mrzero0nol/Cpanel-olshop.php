<?php
require_once 'includes/header.php';
require_login();

$user_id = $_SESSION['user_id'];
// Get orders with product name
$query = "SELECT o.*, p.name as product_name
          FROM orders o
          LEFT JOIN products p ON o.product_id = p.id
          WHERE o.user_id = ?
          ORDER BY o.id DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="p-4 bg-gray-50 min-h-screen pb-24">
    <h1 class="text-2xl font-bold mb-4">Riwayat Pesanan</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="space-y-4">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="text-xs text-gray-500">Order #<?php echo $row['id']; ?></span>
                            <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($row['product_name']); ?></h3>
                        </div>
                        <?php
                        $status_color = 'gray';
                        $status_label = $row['status'];
                        if($row['status'] == 'paid') { $status_color = 'green'; $status_label = 'Berhasil'; }
                        if($row['status'] == 'pending') { $status_color = 'yellow'; $status_label = 'Menunggu'; }
                        if($row['status'] == 'failed') { $status_color = 'red'; $status_label = 'Gagal'; }
                        ?>
                        <span class="bg-<?php echo $status_color; ?>-100 text-<?php echo $status_color; ?>-700 text-xs font-bold px-2 py-1 rounded">
                            <?php echo $status_label; ?>
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500"><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></span>
                        <span class="font-bold text-blue-600">Rp <?php echo number_format($row['total_amount'], 0, ',', '.'); ?></span>
                    </div>

                    <?php if($row['status'] == 'pending'): ?>
                        <div class="mt-3 pt-3 border-t">
                            <a href="checkout.php?product_id=<?php echo $row['product_id']; ?>" class="block text-center text-blue-500 font-bold text-sm">Bayar Sekarang</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center h-64 text-gray-400">
            <i class="fas fa-shopping-bag text-4xl mb-2"></i>
            <p>Belum ada pesanan</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/bottom_nav.php'; ?>
<?php require_once 'includes/footer.php'; ?>
