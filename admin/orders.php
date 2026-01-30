<?php
require_once 'layout_header.php';

$query = "SELECT o.*, u.name as user_name, u.email as user_email, l.license_data
          FROM orders o
          JOIN users u ON o.user_id = u.id
          LEFT JOIN product_licenses l ON l.order_id = o.id
          ORDER BY o.id DESC";
$result = $conn->query($query);
?>

<h1 class="text-3xl font-bold mb-6">Daftar Pesanan</h1>

<div class="bg-white rounded shadow-md overflow-x-auto">
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">User</th>
                <th class="py-3 px-6 text-left">Total</th>
                <th class="py-3 px-6 text-center">Status</th>
                <th class="py-3 px-6 text-left">Tanggal</th>
                <th class="py-3 px-6 text-left">Pakasir Inv</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">#<?php echo $row['id']; ?></td>
                <td class="py-3 px-6 text-left">
                    <div class="font-bold"><?php echo htmlspecialchars($row['user_name']); ?></div>
                    <div class="text-xs"><?php echo htmlspecialchars($row['user_email']); ?></div>
                </td>
                <td class="py-3 px-6 text-left font-bold">Rp <?php echo number_format($row['total_amount'], 0, ',', '.'); ?></td>
                <td class="py-3 px-6 text-center">
                    <?php
                    $color = 'gray';
                    if($row['status'] == 'paid') $color = 'green';
                    if($row['status'] == 'failed') $color = 'red';
                    if($row['status'] == 'pending') $color = 'yellow';
                    ?>
                    <span class="bg-<?php echo $color; ?>-200 text-<?php echo $color; ?>-600 py-1 px-3 rounded-full text-xs capitalize">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td class="py-3 px-6 text-left"><?php echo $row['created_at']; ?></td>
                <td class="py-3 px-6 text-left text-xs">
                    <?php echo $row['pakasir_inv_id'] ? $row['pakasir_inv_id'] : '-'; ?>
                    <?php if($row['license_data']): ?>
                        <div class="mt-1 text-[10px] text-green-600 font-mono bg-green-50 p-1 rounded border border-green-200">
                            <?php echo substr($row['license_data'], 0, 20) . '...'; ?>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once 'layout_footer.php'; ?>
