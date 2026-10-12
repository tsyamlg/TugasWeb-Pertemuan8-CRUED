<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Sanitasi output (cegah XSS)
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function set_flash(string $type, string $msg): void { $_SESSION['flash'] = ['type' => $type, 'msg' => $msg]; }
function get_flash(): ?array {
    if (isset($_SESSION['flash'])) { $f = $_SESSION['flash']; unset($_SESSION['flash']); return $f; }
    return null;
}

function rupiah($n): string { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }

// CSRF token sederhana
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_check($t): bool {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$t);
}

// Validasi input form barang
function validate_barang(array $in, PDO $pdo, array &$errors): array {
    $d = [
        'kode_barang' => trim($in['kode_barang'] ?? ''),
        'nama_barang' => trim($in['nama_barang'] ?? ''),
        'kategori_id' => $in['kategori_id'] ?? '',
        'jumlah'      => $in['jumlah'] ?? '',
        'harga'       => $in['harga'] ?? '',
    ];
    if ($d['kode_barang'] === '' || mb_strlen($d['kode_barang']) > 20)
        $errors['kode_barang'] = 'Kode wajib diisi (maks 20 karakter).';
    if ($d['nama_barang'] === '' || mb_strlen($d['nama_barang']) > 100)
        $errors['nama_barang'] = 'Nama wajib diisi (maks 100 karakter).';
    if (filter_var($d['jumlah'], FILTER_VALIDATE_INT) === false || (int)$d['jumlah'] < 0)
        $errors['jumlah'] = 'Jumlah harus bilangan bulat >= 0.';
    if (!is_numeric($d['harga']) || (float)$d['harga'] < 0)
        $errors['harga'] = 'Harga harus angka >= 0.';

    $kid = filter_var($d['kategori_id'], FILTER_VALIDATE_INT);
    if ($kid === false) {
        $errors['kategori_id'] = 'Pilih kategori.';
    } else {
        $s = $pdo->prepare('SELECT COUNT(*) FROM kategori WHERE id = ?');
        $s->execute([$kid]);
        if (!$s->fetchColumn()) $errors['kategori_id'] = 'Kategori tidak valid.';
    }
    return $d;
}