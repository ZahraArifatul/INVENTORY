<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Vendor / Supplier Baru</title>
</head>
<body>
    <h2>Form Tambah Vendor Baru</h2>
    <hr>
    
    <form action="index.php?action=create_vendor" method="POST" style="width: 400px; line-height: 2;">
        <label>Nama Perusahaan Vendor:</label><br>
        <input type="text" name="nama_vendor" required placeholder="Contoh: PT. Digital Jaya" style="width: 100%;"><br>

        <label>Kontak / No. Telepon:</label><br>
        <input type="text" name="kontak" required placeholder="Contoh: 08123456789" style="width: 100%;"><br>

        <label>Kategori / Nama Barang Disediakan:</label><br>
        <input type="text" name="nama_barang" required placeholder="Contoh: Perangkat Komputer" style="width: 100%;"><br><br>

        <button type="submit">Simpan Vendor Baru</button>
        <a href="index.php?action=index">Kembali</a>
    </form>
</body>
</html>