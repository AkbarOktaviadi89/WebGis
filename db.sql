-- Database schema for WebGIS Kriminalitas

-- 1. Tabel kriminalitas untuk menyimpan data kejadian
CREATE TABLE `kriminalitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_kejahatan` varchar(100) NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `alamat_detail` text,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `tanggal_kejadian` date NOT NULL,
  `waktu_kejadian` time DEFAULT NULL,
  `keterangan` text,
  `tingkat_bahaya` enum('rendah','sedang','tinggi') DEFAULT 'sedang',
  `status` enum('dilaporkan','proses','selesai') DEFAULT 'dilaporkan',
  `jumlah_korban` int(11) DEFAULT '0',
  `kerugian_estimasi` decimal(15,2) DEFAULT NULL,
  `pelapor` varchar(100) DEFAULT NULL,
  `nomor_laporan` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_jenis` (`jenis_kejahatan`),
  KEY `idx_lokasi` (`lokasi`),
  KEY `idx_tanggal` (`tanggal_kejadian`),
  KEY `idx_tingkat` (`tingkat_bahaya`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel wilayah untuk master data wilayah
CREATE TABLE `wilayah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_wilayah` varchar(100) NOT NULL,
  `kode_wilayah` varchar(20) UNIQUE,
  `jenis_wilayah` enum('kecamatan','kelurahan','rw','rt') DEFAULT 'kecamatan',
  `parent_id` int(11) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `luas_wilayah` decimal(10,2) DEFAULT NULL,
  `jumlah_penduduk` int(11) DEFAULT '0',
  `kepadatan_penduduk` decimal(10,2) DEFAULT NULL,
  `keterangan` text,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_nama` (`nama_wilayah`),
  KEY `idx_kode` (`kode_wilayah`),
  KEY `idx_jenis` (`jenis_wilayah`),
  KEY `fk_parent` (`parent_id`),
  CONSTRAINT `fk_wilayah_parent` FOREIGN KEY (`parent_id`) REFERENCES `wilayah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel jenis_kejahatan untuk master data jenis kejahatan
CREATE TABLE `jenis_kejahatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(100) NOT NULL,
  `kode_jenis` varchar(20) UNIQUE,
  `kategori` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `tingkat_bahaya_default` enum('rendah','sedang','tinggi') DEFAULT 'sedang',
  `warna_marker` varchar(7) DEFAULT '#007bff',
  `icon_class` varchar(50) DEFAULT 'fas fa-exclamation-triangle',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nama_jenis` (`nama_jenis`),
  KEY `idx_kategori` (`kategori`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel users untuk sistem autentikasi admin
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `level` enum('admin','operator','viewer') DEFAULT 'viewer',
  `avatar` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_username` (`username`),
  UNIQUE KEY `uk_email` (`email`),
  KEY `idx_level` (`level`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel instansi untuk data kepolisian
CREATE TABLE `instansi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_instansi` varchar(100) NOT NULL,
  `jenis_instansi` enum('polsek','polres','polda','tni','satpol_pp') DEFAULT 'polsek',
  `alamat` text,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `wilayah_id` int(11) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kepala_instansi` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_nama` (`nama_instansi`),
  KEY `idx_jenis` (`jenis_instansi`),
  KEY `fk_wilayah_instansi` (`wilayah_id`),
  CONSTRAINT `fk_instansi_wilayah` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel berita untuk highlight berita
CREATE TABLE `berita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(200) NOT NULL,
  `konten` text NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_publikasi` datetime DEFAULT CURRENT_TIMESTAMP,
  `penulis` varchar(100) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `is_highlight` tinyint(1) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_kategori` (`kategori`),
  KEY `idx_status` (`status`),
  KEY `idx_highlight` (`is_highlight`),
  KEY `idx_tanggal` (`tanggal_publikasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
-- Master data jenis kejahatan
INSERT INTO `jenis_kejahatan` (`nama_jenis`, `kode_jenis`, `kategori`, `deskripsi`, `tingkat_bahaya_default`, `warna_marker`, `icon_class`) VALUES
('Pencurian', 'CURI', 'Kriminalitas Konvensional', 'Pencurian dalam segala bentuknya', 'sedang', '#ffc107', 'fas fa-hand-paper'),
('Perampokan', 'RAMPOK', 'Kriminalitas Konvensional', 'Perampokan dengan kekerasan', 'tinggi', '#dc3545', 'fas fa-mask'),
('Penipuan', 'TIPU', 'Kriminalitas Konvensional', 'Penipuan dan penggelapan', 'rendah', '#17a2b8', 'fas fa-user-secret'),
('Narkoba', 'NARKOBA', 'Narkotika', 'Penyalahgunaan narkotika dan obat terlarang', 'tinggi', '#6f42c1', 'fas fa-pills'),
('Penganiayaan', 'ANIAYA', 'Kriminalitas Konvensional', 'Penganiayaan dan kekerasan fisik', 'sedang', '#fd7e14', 'fas fa-fist-raised'),
('Perjudian', 'JUDI', 'Pelanggaran Ketertiban', 'Perjudian dalam berbagai bentuk', 'rendah', '#20c997', 'fas fa-dice'),
('Pembunuhan', 'BUNUH', 'Kriminalitas Berat', 'Pembunuhan dan percobaan pembunuhan', 'tinggi', '#000000', 'fas fa-skull-crossbones');

-- Sample data wilayah (Kabupaten Bandung)
INSERT INTO `wilayah` (`nama_wilayah`, `kode_wilayah`, `jenis_wilayah`, `latitude`, `longitude`, `jumlah_penduduk`) VALUES
('Lembang', 'KEC-LMB', 'kecamatan', -6.8650, 107.5872, 185000),
('Parongpong', 'KEC-PRG', 'kecamatan', -6.8456, 107.5234, 95000),
('Cisarua', 'KEC-CSR', 'kecamatan', -6.7833, 107.5500, 78000),
('Cikalong Wetan', 'KEC-CKW', 'kecamatan', -6.7747, 107.6319, 65000),
('Cipeundeuy', 'KEC-CPD', 'kecamatan', -6.9167, 107.4333, 55000),
('Ngamprah', 'KEC-NGM', 'kecamatan', -6.8789, 107.4567, 125000),
('Cimenyan', 'KEC-CMN', 'kecamatan', -6.8206, 107.6581, 95000),
('Cilengkrang', 'KEC-CLK', 'kecamatan', -6.9123, 107.7234, 145000),
('Bojongsoang', 'KEC-BJS', 'kecamatan', -6.9789, 107.6456, 165000),
('Margahayu', 'KEC-MGH', 'kecamatan', -6.9456, 107.5789, 180000);

-- Sample data instansi
INSERT INTO `instansi` (`nama_instansi`, `jenis_instansi`, `alamat`, `latitude`, `longitude`, `wilayah_id`, `telepon`) VALUES
('Polsek Lembang', 'polsek', 'Jl. Raya Lembang No. 123', -6.8650, 107.5872, 1, '022-2786543'),
('Polsek Parongpong', 'polsek', 'Jl. Kolonel Masturi KM 8', -6.8456, 107.5234, 2, '022-2784321'),
('Polsek Cikalong Wetan', 'polsek', 'Jl. Raya Cikalong Wetan', -6.7747, 107.6319, 4, '022-2789876'),
('Polres Bandung Barat', 'polres', 'Jl. Raya Batujajar', -6.8789, 107.4567, 6, '022-6654321');

-- Sample data users
INSERT INTO `users` (`username`, `email`, `password`, `nama_lengkap`, `level`) VALUES
('admin', 'admin@webgis.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator WebGIS', 'admin'),
('operator1', 'operator@webgis.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Operator Polres', 'operator');

-- Sample data berita
INSERT INTO `berita` (`judul`, `konten`, `kategori`, `status`, `is_highlight`, `penulis`) VALUES
('Operasi Keamanan Terpadu di Kabupaten Bandung', 'Polres Kabupaten Bandung melakukan operasi keamanan terpadu untuk meningkatkan rasa aman masyarakat...', 'Operasi', 'published', 1, 'Humas Polres'),
('Penurunan Angka Kriminalitas', 'Berdasarkan data statistik, angka kriminalitas di Kabupaten Bandung mengalami penurunan signifikan...', 'Statistik', 'published', 1, 'Tim Analisis'),
('Sosialisasi Kamtibmas', 'Kegiatan sosialisasi keamanan dan ketertiban masyarakat dilakukan di berbagai desa...', 'Sosialisasi', 'published', 0, 'Babinkamtibmas');