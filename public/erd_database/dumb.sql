create database database_ujian_online;

| pelajaran | CREATE TABLE `pelajaran` (
  `id_pelajaran` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelajaran` varchar(60) NOT NULL,
  PRIMARY KEY (`id_pelajaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci |
+-----------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.000 sec)


| data_ujian | CREATE TABLE `data_ujian` (
  `id_data_ujian` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ujian` varchar(60) DEFAULT NULL,
  `penjelasan_ujian` text DEFAULT NULL,
  `durasi_ujian` int(11) NOT NULL DEFAULT 120,
  `ujian_dibuka` datetime DEFAULT current_timestamp(),
  `ujian_ditutup` datetime DEFAULT NULL,
  `id_pelajaran` int(11) NOT NULL,
  PRIMARY KEY (`id_data_ujian`),
  KEY `fk_data_ujian_id_pelajaran_references_pelajaran_id_pelajaran` (`id_pelajaran`),
  CONSTRAINT `fk_data_ujian_id_pelajaran_references_pelajaran_id_pelajaran` FOREIGN KEY (`id_pelajaran`) REFERENCES `pelajaran` (`id_pelajaran`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci |
+------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.001 sec)


| guru  | CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(60) NOT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci |
+-------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.000 sec)


| siswa | CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(60) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_siswa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci |
+-------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.000 sec)


| user_pendidikan | CREATE TABLE `user_pendidikan` (
  `id_user_pendidikan` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `peran` enum('siswa','guru') NOT NULL DEFAULT 'siswa',
  `id_guru` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user_pendidikan`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_user_id_guru_references_guru_id_guru` (`id_guru`),
  KEY `fk_user_id_siswa_references_siswa_id_siswa` (`id_siswa`),
  CONSTRAINT `fk_user_id_guru_references_guru_id_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_id_siswa_references_siswa_id_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.000 sec)


| soal_ujian | CREATE TABLE `soal_ujian` (
  `id_soal_ujian` int(11) NOT NULL AUTO_INCREMENT,
  `pertanyaan` varchar(60) DEFAULT NULL,
  `jawaban` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '1',
  `id_guru` int(11) NOT NULL,
  `id_data_ujian` int(11) NOT NULL,
  PRIMARY KEY (`id_soal_ujian`),
  KEY `fk_soal_ujian_id_guru_references_guru_id_guru` (`id_guru`),
  KEY `fk_soal_ujian_id_data_ujian_references_data_ujian_id_data_ujian` (`id_data_ujian`),
  CONSTRAINT `fk_soal_ujian_id_data_ujian_references_data_ujian_id_data_ujian` FOREIGN KEY (`id_data_ujian`) REFERENCES `data_ujian` (`id_data_ujian`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_soal_ujian_id_guru_references_guru_id_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci |
+------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.001 sec)


| pengerjaan | CREATE TABLE `pengerjaan` (
  `id_pengerjaan` int(11) NOT NULL AUTO_INCREMENT,
  `jawaban` enum('1','2','3','4','5','6','7','8','9','10','11') NOT NULL DEFAULT '11',
  `waktu_mulai` datetime DEFAULT current_timestamp(),
  `id_soal_ujian` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  PRIMARY KEY (`id_pengerjaan`),
  KEY `fk_pengerjaan_id_soal_ujian_references_soal_ujian_id_soal_ujian` (`id_soal_ujian`),
  KEY `fk_pengerjaan_id_siswa_references_siswa_id_siswa` (`id_siswa`),
  CONSTRAINT `fk_pengerjaan_id_siswa_references_siswa_id_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pengerjaan_id_soal_ujian_references_soal_ujian_id_soal_ujian` FOREIGN KEY (`id_soal_ujian`) REFERENCES `soal_ujian` (`id_soal_ujian`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci |
+------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.000 sec)


