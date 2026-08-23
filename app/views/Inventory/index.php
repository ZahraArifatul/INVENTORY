<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitoring Inventory</title>
    <!-- Framework Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen p-6">

    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6 border border-slate-200">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between pb-5 border-b border-slate-200 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Dashboard Inventory</h1>
                <p class="text-sm text-slate-500">Monitoring stok barang, lokasi gudang, dan vendor real-time.</p>
            </div>
            
            <!-- Tombol Aksi Cepat -->
            <div class="flex flex-wrap gap-2">
                <a href="index.php?action=create" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200">
                    + Tambah Barang
                </a>
                <a href="index.php?action=create_storage" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg border border-slate-300 transition-all duration-200">
                    + Gudang Baru
                </a>
                <a href="index.php?action=create_vendor" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg border border-slate-300 transition-all duration-200">
                    + Vendor Baru
                </a>
            </div>
        </div>

        <!-- Form Pencarian -->
        <div class="my-5">
            <form action="index.php" method="GET" class="flex gap-2">
                <input type="hidden" name="action" value="index">
                <div class="relative flex-1">
                    <input type="text" name="search" placeholder="Cari berdasarkan nama barang, jenis, atau serial number..." 
                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                           class="w-full pl-4 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
                <button type="submit" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition-all duration-200">
                    Cari
                </button>
            </form>
        </div>

        <!-- Tabel Monitoring Data -->
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Serial Number</th>
                        <th class="px-4 py-3">Nama Barang</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3">Stok</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Gudang</th>
                        <th class="px-4 py-3">Vendor</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-slate-400">
                                Tidak ada data barang yang ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($items as $row): ?>
                            <tr class="hover:bg-slate-50 transition-colors <?php echo ($row['kuantitas_stok'] <= 0) ? 'bg-red-50/60' : ''; ?>">
                                <td class="px-4 py-3 font-mono text-xs font-bold text-slate-700">
                                    <?php echo htmlspecialchars($row['serial_number'] ?? ''); ?>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    <?php echo htmlspecialchars($row['nama_barang'] ?? ''); ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php echo htmlspecialchars($row['jenis_barang'] ?? ''); ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if ($row['kuantitas_stok'] <= 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            HABIS
                                        </span>
                                    <?php else: ?>
                                        <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($row['kuantitas_stok']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-700">
                                    Rp <?php echo number_format($row['harga'] ?? 0, 0, ',', '.'); ?>
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    <?php echo htmlspecialchars($row['nama_gudang'] ?? '-'); ?>
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    <?php echo htmlspecialchars($row['nama_vendor'] ?? '-'); ?>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <?php 
                                        // Cari ID secara dinamis
                                        $idVal = $row['id_inventory'] ?? $row['id_barang'] ?? $row['id'] ?? '';
                                    ?>
                                    <div class="inline-flex gap-2">
                                        <a href="index.php?action=edit&id=<?php echo htmlspecialchars($idVal); ?>" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                        <span class="text-slate-300">|</span>
                                        <a href="index.php?action=delete&id=<?php echo htmlspecialchars($idVal); ?>" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('Yakin hapus barang ini?');">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script Alert Stok Habis -->
    <?php if (!empty($alertItems)): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let listBarang = <?php echo json_encode(array_column($alertItems, 'nama_barang')); ?>;
                alert("PERINGATAN STOK HABIS:\n\nBarang berikut stoknya 0:\n- " + listBarang.join("\n- ") + "\n\nHarap segera lakukan restock!");
            });
        </script>
    <?php endif; ?>
</body>
</html>