<?php
$current_page = basename($_SERVER['PHP_SELF']);
$wa_number = get_setting('wa_number');
// Remove non-numeric characters for WA link
$wa_clean = preg_replace('/[^0-9]/', '', $wa_number);
$chat_url = "https://wa.me/" . $wa_clean;
?>
<div class="fixed bottom-0 w-full max-w-[480px] bg-white border-t border-gray-200 flex justify-around items-center py-2 z-50" style="margin: 0 auto; left: 0; right: 0;">
    <a href="index.php" class="flex flex-col items-center text-gray-500 hover:text-blue-500 <?php echo $current_page == 'index.php' ? 'text-blue-500' : ''; ?>">
        <i class="fas fa-home text-xl mb-1"></i>
        <span class="text-[10px]">Home</span>
    </a>

    <a href="orders.php" class="flex flex-col items-center text-gray-500 hover:text-blue-500 <?php echo $current_page == 'orders.php' ? 'text-blue-500' : ''; ?>">
        <i class="fas fa-history text-xl mb-1"></i>
        <span class="text-[10px]">Riwayat</span>
    </a>

    <a href="<?php echo $chat_url; ?>" target="_blank" class="flex flex-col items-center text-gray-500 hover:text-green-500">
        <div class="bg-green-500 text-white rounded-full p-2 -mt-6 border-4 border-white shadow-lg">
            <i class="fab fa-whatsapp text-2xl"></i>
        </div>
        <span class="text-[10px] mt-1">Chat</span>
    </a>

    <a href="my_assets.php" class="flex flex-col items-center text-gray-500 hover:text-blue-500 <?php echo $current_page == 'my_assets.php' ? 'text-blue-500' : ''; ?>">
        <i class="fas fa-wallet text-xl mb-1"></i>
        <span class="text-[10px]">Aset</span>
    </a>

    <a href="account.php" class="flex flex-col items-center text-gray-500 hover:text-blue-500 <?php echo $current_page == 'account.php' ? 'text-blue-500' : ''; ?>">
        <i class="fas fa-user text-xl mb-1"></i>
        <span class="text-[10px]">Saya</span>
    </a>
</div>
