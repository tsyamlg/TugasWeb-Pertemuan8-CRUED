<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

// Hanya menerima POST + token CSRF (tidak boleh lewat link GET)
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_check($_POST['csrf'] ?? '')) {
    http_response_code(403); die('Permintaan tidak valid.');
}
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM barang WHERE id = :id');
    $stmt->execute([':id' => $id]);
    set_flash('success', 'Barang berhasil dihapus.');
} else {
    set_flash('error', 'ID tidak valid.');
}
header('Location: index.php'); exit;