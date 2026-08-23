<?php
// Tentukan path absolut menuju InventoryController.php
$controllerPath = __DIR__ . '/../app/controllers/InventoryController.php';

// Cek apakah filenya benar-benar ada sebelum di-require
if (file_exists($controllerPath)) {
    require_once $controllerPath;
} else {
    die("Error: File controller tidak ditemukan di path: " . $controllerPath);
}

// Inisialisasi controller
$controller = new InventoryController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'create_storage':
        $controller->createStorage();
        break;
    case 'create_vendor':
        $controller->createVendor();
        break;
    case 'index':
    default:
        $controller->index();
        break;
}