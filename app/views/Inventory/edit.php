<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang Inventory</title>
</head>
<body>
    <h2>Form Edit Data Barang</h2>
    <hr>
    
    <form action="index.php?action=edit&id=<?= $item['id_inventory']; ?>" method="POST" style="width: 400px; line-height: 2;">
        <label>Serial Number (Barcode Unik):</label><br>
        <input type="text" name="serial_number" value="<?= htmlspecialchars($item['serial_number']); ?>" required style="width: 100%;"><br>

        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" value="<?= htmlspecialchars($item['nama_barang']); ?>" required style="width: 100%;"><br>

        <label>Jenis Barang:</label><br>
        <input type="text" name="jenis_barang" value="<?= htmlspecialchars($item['jenis_barang']); ?>" required style="width: 100%;"><br>

        <label>Kuantitas Stok:</label><br>
        <input type="number" name="kuantitas_stok" min="0" value="<?= $item['kuantitas_stok']; ?>" required style="width: 100%;"><br>

        <label>Harga Barang:</label><br>
        <input type="number" name="harga" min="0" value="<?= $item['harga']; ?>" required style="width: 100%;"><br>

        <label>Pilih Lokasi Gudang:</label><br>
        <select name="id_gudang" style="width: 100%;">
            <option value="">-- Pilih Gudang Penyimpanan --</option>
            <?php foreach($gudangList as $g): ?>
                <option value="<?= $g['id_gudang']; ?>" <?= $g['id_gudang'] == $item['id_gudang'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($g['nama_gudang']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Pilih Vendor / Supplier:</label><br>
        <select name="id_vendor" style="width: 100%;">
            <option value="">-- Pilih Vendor Asal --</option>
            <?php foreach($vendorList as $v): ?>
                <option value="<?= $v['id_vendor']; ?>" <?= $v['id_vendor'] == $item['id_vendor'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($v['nama_vendor']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Update Data Barang</button>
        <a href="index.php?action=index">Batal</a>
    </form>
</body>
</html>