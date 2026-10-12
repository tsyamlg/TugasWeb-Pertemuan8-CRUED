<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
$pageTitle = 'Edit Barang';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { set_flash('error', 'ID tidak valid.'); header('Location: index.php'); exit; }

$stmt = $pdo->prepare('SELECT kode_barang, nama_barang, kategori_id, jumlah, harga FROM barang WHERE id = :id');
$stmt->execute([':id' => $id]);
$data = $stmt->fetch();
if (!$data) { set_flash('error', 'Data tidak ditemukan.'); header('Location: index.php'); exit; }

$kategori = $pdo->query('SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori')->fetchAll();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf'] ?? '')) { http_response_code(403); die('Token tidak valid.'); }
    $data = validate_barang($_POST, $pdo, $errors);

    if (!$errors) {
        try {
            $stmt = $pdo->prepare('UPDATE barang
                SET kode_barang = :kode, nama_barang = :nama, kategori_id = :kat, jumlah = :jml, harga = :harga
                WHERE id = :id');
            $stmt->execute([
                ':kode'  => $data['kode_barang'],
                ':nama'  => $data['nama_barang'],
                ':kat'   => (int)$data['kategori_id'],
                ':jml'   => (int)$data['jumlah'],
                ':harga' => $data['harga'],
                ':id'    => $id,
            ]);
            set_flash('success', 'Barang berhasil diperbarui.');
            header('Location: index.php'); exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') $errors['kode_barang'] = 'Kode barang sudah dipakai.';
            else { error_log($e->getMessage()); $errors['umum'] = 'Terjadi kesalahan database.'; }
        }
    }
}
require 'includes/header.php';
?>
<h2>Edit Barang</h2>
<?php if (isset($errors['umum'])): ?><div class="alert error"><?= e($errors['umum']) ?></div><?php endif; ?>
<?php require 'includes/_form.php'; ?>
<?php require 'includes/footer.php'; ?>