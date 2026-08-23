// Konfirmasi Hapus Data
function confirmDelete(event) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        event.preventDefault();
    }
}

// Menampilkan Alert Stok Habis saat Halaman Dimuat
document.addEventListener("DOMContentLoaded", function() {
    const alertDataContainer = document.getElementById("alert-data");
    
    if (alertDataContainer) {
        const outOfStockItems = JSON.parse(alertDataContainer.getAttribute("data-items"));
        
        if (outOfStockItems.length > 0) {
            alert(" PERINGATAN SISTEM INVENTORY:\n\nStok untuk barang berikut telah HABIS (0):\n- " + 
                  outOfStockItems.join("\n- ") + 
                  "\n\nHarap segera hubungi vendor terkait untuk melakukan restock!");
        }
    }
});