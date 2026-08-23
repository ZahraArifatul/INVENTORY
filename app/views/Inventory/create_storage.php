<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Gudang Cabang Baru</title>
</head>
<body>
    <h2>Form Tambah Gudang Cabang</h2>
    <hr>
    
    <form action="index.php?action=create_storage" method="POST" style="width: 400px; line-height: 2;">
        <label>Nama Gudang Cabang:</label><br>
        <input type="text" name="nama_gudang" required placeholder="Contoh: Gudang Cabang Surabaya" style="width: 100%;"><br>

        <label>Lokasi / Alamat Gudang:</label><br>
        <input type="text" name="lokasi" required placeholder="Contoh: Jl. Ahmad Yani No. 10" style="width: 100%;"><br><br>

        <button type="submit">Simpan Gudang Baru</button>
        <a href="index.php?action=index">Kembali</a>
    </form>
</body>
</html>