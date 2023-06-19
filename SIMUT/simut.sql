-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.epizy.com
-- Waktu pembuatan: 19 Jun 2023 pada 03.20
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_34319348_simut`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_bahan`
--

CREATE TABLE `kategori_bahan` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(30) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori_bahan`
--

INSERT INTO `kategori_bahan` (`id_kategori`, `nama_kategori`, `harga`) VALUES
(1, 'Denim', 50000),
(2, 'Tunik', 20000),
(3, 'Katun', 35000),
(4, 'Sutra', 35000),
(5, 'Flanel', 50000),
(6, 'Batik', 50000),
(7, 'Polyester', 45000),
(8, 'Tenun', 75000),
(10, 'Tenun Asri', 79000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `nama_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id_status`, `nama_status`) VALUES
(1, 'Ada'),
(2, 'Kosong');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_bahan`
--

CREATE TABLE `stok_bahan` (
  `id_stok` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stok_bahan`
--

INSERT INTO `stok_bahan` (`id_stok`, `jumlah`, `id_status`, `id_kategori`) VALUES
(1, 82, 1, 1),
(2, 70, 1, 2),
(3, 10, 1, 3),
(4, 0, 2, 4),
(5, 10, 1, 5),
(6, 10, 1, 6),
(7, 10, 1, 7),
(20, 10, 1, 8),
(24, 65, 1, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_order`
--

CREATE TABLE `tabel_order` (
  `id_order` int(11) NOT NULL,
  `nama_pemesan` varchar(50) NOT NULL,
  `nama_order` varchar(50) NOT NULL,
  `jumlah_pesanan` int(11) NOT NULL,
  `id_stok` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `tenggat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_order`
--

INSERT INTO `tabel_order` (`id_order`, `nama_pemesan`, `nama_order`, `jumlah_pesanan`, `id_stok`, `deskripsi`, `tenggat`) VALUES
(2, 'Muhid', 'Baju Kerja', 1, 6, 'Baju kerja batik untuk pak Muhid', '2023-06-29'),
(3, 'Rahman', 'Celana Jeans', 1, 1, 'Celana jeans untuk pemakaian sehari-hari Rahman', '2023-06-28'),
(5, 'Rendra', 'Baju Tentara', 1, 4, 'Baju angkatan darat', '2023-06-29'),
(6, 'Budi', 'Baju Tentara', 4, 1, 'Baju milik tentara', '2023-06-28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `jumlah_bahan` int(11) NOT NULL,
  `harga_bahan` int(11) NOT NULL,
  `tanggal_transaksi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_kategori`, `jumlah_bahan`, `harga_bahan`, `tanggal_transaksi`) VALUES
(42, 5, 30, 50000, '2023-06-11'),
(43, 10, 65, 79000, '2023-05-10'),
(45, 1, 2, 50000, '2023-06-12'),
(46, 2, 60, 20000, '2023-06-07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori_bahan`
--
ALTER TABLE `kategori_bahan`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `stok_bahan`
--
ALTER TABLE `stok_bahan`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_status` (`id_status`);

--
-- Indeks untuk tabel `tabel_order`
--
ALTER TABLE `tabel_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_stok` (`id_stok`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori_bahan`
--
ALTER TABLE `kategori_bahan`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `stok_bahan`
--
ALTER TABLE `stok_bahan`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `tabel_order`
--
ALTER TABLE `tabel_order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `stok_bahan`
--
ALTER TABLE `stok_bahan`
  ADD CONSTRAINT `stok_bahan_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_bahan` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stok_bahan_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tabel_order`
--
ALTER TABLE `tabel_order`
  ADD CONSTRAINT `tabel_order_ibfk_1` FOREIGN KEY (`id_stok`) REFERENCES `stok_bahan` (`id_stok`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_bahan` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
