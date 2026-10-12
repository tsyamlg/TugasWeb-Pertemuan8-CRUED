-- Database Inventaris (3NF)
CREATE DATABASE IF NOT EXISTS db_inventaris CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_inventaris;

DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS kategori;

-- Tabel master kategori (menghindari pengulangan nama kategori = 3NF)
CREATE TABLE kategori (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Tabel barang, relasi ke kategori lewat Foreign Key
CREATE TABLE barang (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(20) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  kategori_id INT UNSIGNED NOT NULL,
  jumlah INT UNSIGNED NOT NULL DEFAULT 0,
  harga DECIMAL(12,2) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_barang_kategori FOREIGN KEY (kategori_id)
    REFERENCES kategori(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO kategori (nama_kategori) VALUES ('Elektronik'), ('Alat Tulis'), ('Furnitur');

INSERT INTO barang (kode_barang, nama_barang, kategori_id, jumlah, harga) VALUES
('BRG001', 'Laptop Asus', 1, 5, 7500000),
('BRG002', 'Pulpen Hitam', 2, 100, 3500),
('BRG003', 'Kursi Kantor', 3, 12, 450000);