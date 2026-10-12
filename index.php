<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
$pageTitle = 'Daftar Barang';

// READ + JOIN + pencarian (semua pakai prepared statement)
$q = trim($_GET['q'] ?? '');
$sql = 'SELECT b.id, b.kode_barang, b.nama_barang, k.nama_kategori, b.jumlah, b.harga
        FROM barang b
        INNER JOIN kategori k ON b.kategori_id = k.id';
$params = [];
if ($q !== '') {
    $sql .= ' WHERE b.nama_barang LIKE :q OR b.kode_barang LIKE :q';
    $params[':q'] = '%' . $q . '%';
}
$sql .= ' ORDER BY b.id DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

require 'includes/header.php';
?>
<div class="toolbar">
  <form method="get" class="search">
    <input type="text" name="q" placeholder="Cari nama / kode..." value="<?= e($q) ?>">
    <button class="btn">Cari</button>
  </form>
  <a href="create.php" class="btn primary">+ Tambah Barang</a>
</div>

<table>
  <thead>
    <tr><th>#</th><th>Kode</th><th>Nama</th><th>Kategori</th><th>Jumlah</th><th>Harga</th><th>Aksi</th></tr>
  </thead>
  <tbody>
  <?php if (!$rows): ?>
    <tr><td colspan="7" class="center">Belum ada data.</td></tr>
  <?php endif; ?>
  <?php foreach ($rows as $i => $r): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= e($r['kode_barang']) ?></td>
      <td><?= e($r['nama_barang']) ?></td>
      <td><?= e($r['nama_kategori']) ?></td>
      <td><?= e($r['jumlah']) ?></td>
      <td><?= e(rupiah($r['harga'])) ?></td>
      <td class="aksi">
        <a href="edit.php?id=<?= e($r['id']) ?>" class="btn small">Edit</a>
        <form method="post" action="delete.php" onsubmit="return confirm('Hapus barang ini?')">
          <input type="hidden" name="id" value="<?= e($r['id']) ?>">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <button class="btn small danger">Hapus</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php require 'includes/footer.php'; ?>