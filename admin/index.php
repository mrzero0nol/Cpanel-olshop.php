<?php
require_once 'layout_header.php';

// Fetch Stats
$total_users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$total_products = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'];
$total_orders = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status = 'paid'")->fetch_assoc()['c'];
$total_revenue = $conn->query("SELECT SUM(total_amount) as c FROM orders WHERE status = 'paid'")->fetch_assoc()['c'] ?? 0;

?>

<h1 class="text-3xl font-bold mb-6">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card 1 -->
    <div class="bg-white rounded-lg p-6 shadow-lg border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full mr-4">
                <i class="fas fa-users text-blue-500 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total User</p>
                <p class="text-2xl font-bold text-gray-800"><?php echo $total_users; ?></p>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-lg p-6 shadow-lg border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full mr-4">
                <i class="fas fa-box text-green-500 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800"><?php echo $total_products; ?></p>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-lg p-6 shadow-lg border-l-4 border-yellow-500">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full mr-4">
                <i class="fas fa-shopping-cart text-yellow-500 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Pesanan Selesai</p>
                <p class="text-2xl font-bold text-gray-800"><?php echo $total_orders; ?></p>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-lg p-6 shadow-lg border-l-4 border-red-500">
        <div class="flex items-center">
            <div class="p-3 bg-red-100 rounded-full mr-4">
                <i class="fas fa-money-bill-wave text-red-500 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Pendapatan</p>
                <p class="text-2xl font-bold text-gray-800">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layout_footer.php'; ?>
