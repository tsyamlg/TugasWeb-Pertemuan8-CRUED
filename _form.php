<form method="post" novalidate>
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

  <label>Kode Barang
    <input type="text" name="kode_barang" maxlength="20" value="<?= e($data['kode_barang']) ?>">
    <?php if (isset($errors['kode_barang'])): ?><small class="err"><?= e($errors['kode_barang']) ?></small><?php endif; ?>
  </label>

  <label>Nama Barang
    <input type="text" name="nama_barang" maxlength="100" value="<?= e($data['nama_barang']) ?>">
    <?php if (isset($errors['nama_barang'])): ?><small class="err"><?= e($errors['nama_barang']) ?></small><?php endif; ?>
  </label>

  <label>Kategori
    <select name="kategori_id">
      <option value="">-- Pilih --</option>
      <?php foreach ($kategori as $k): ?>
        <option value="<?= e($k['id']) ?>" <?= (string)$data['kategori_id'] === (string)$k['id'] ? 'selected' : '' ?>>
          <?= e($k['nama_kategori']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <?php if (isset($errors['kategori_id'])): ?><small class="err"><?= e($errors['kategori_id']) ?></small><?php endif; ?>
  </label>

  <label>Jumlah
    <input type="number" name="jumlah" min="0" value="<?= e($data['jumlah']) ?>">
    <?php if (isset($errors['jumlah'])): ?><small class="err"><?= e($errors['jumlah']) ?></small><?php endif; ?>
  </label>

  <label>Harga (Rp)
    <input type="number" name="harga" min="0" step="0.01" value="<?= e($data['harga']) ?>">
    <?php if (isset($errors['harga'])): ?><small class="err"><?= e($errors['harga']) ?></small><?php endif; ?>
  </label>

  <div class="actions">
    <button type="submit" class="btn primary">Simpan</button>
    <a href="index.php" class="btn">Batal</a>
  </div>
</form>