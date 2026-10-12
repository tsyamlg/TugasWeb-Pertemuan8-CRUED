<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle ?? 'Inventaris') ?></title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header><h1>📦 Inventaris Barang</h1></header>
<main>
<?php if ($f = get_flash()): ?>
  <div class="alert <?= e($f['type']) ?>"><?= e($f['msg']) ?></div>
<?php endif; ?>