<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
$pageTitle = 'Tambah Barang';

$kategori = $pdo->query('SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori')->fetchAll();
$data = ['kode_barang' => '', 'nama_barang' => '', 'kategori_id' => '', 'jumlah' => '0', 'harga' => '0'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf'] ?? '')) { http_response_code(403); die('Token tidak valid.'); }
    $data = validate_barang($_POST, $pdo, $errors);

    if (!$errors) {
        try {
            $stmt = $pdo->prepare('INSERT INTO barang (kode_barang, nama_barang, kategori_id, jumlah, harga)
                                   VALUES (:kode, :nama, :kat, :jml, :harga)');
            $stmt->execute([
                ':kode'  => $data['kode_barang'],
                ':nama'  => $data['nama_barang'],
                ':kat'   => (int)$data['kategori_id'],
                ':jml'   => (int)$data['jumlah'],
                ':harga' => $data['harga'],
            ]);
            set_flash('success', 'Barang berhasil ditambahkan.');
            header('Location: index.php'); exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') $errors['kode_barang'] = 'Kode barang sudah dipakai.';
            else { error_log($e->getMessage()); $errors['umum'] = 'Terjadi kesalahan database.'; }
        }
    }
}
require 'includes/header.php';
?>
<h2>Tambah Barang</h2>
<?php if (isset($errors['umum'])): ?><div class="alert error"><?= e($errors['umum']) ?></div><?php endif; ?>
<?php require 'includes/_form.php'; ?>
<?php require 'includes/footer.php'; ?>