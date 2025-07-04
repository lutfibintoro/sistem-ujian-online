create database database_ujian_online;

CREATE TABLE pelajaran (
  id_pelajaran int(11) NOT NULL AUTO_INCREMENT,
  nama_pelajaran varchar(60) NOT NULL,

  PRIMARY KEY (id_pelajaran)
);


CREATE TABLE data_ujian (
  id_data_ujian int(11) NOT NULL AUTO_INCREMENT,
  nama_ujian varchar(60) DEFAULT NULL,
  penjelasan_ujian text DEFAULT NULL,
  durasi_ujian int(11) NOT NULL DEFAULT 120,
  ujian_dibuka datetime DEFAULT current_timestamp(),
  ujian_ditutup datetime DEFAULT NULL,
  id_pelajaran int(11) NOT NULL,

  PRIMARY KEY (id_data_ujian),
  CONSTRAINT fk_data_ujian_id_pelajaran_references_pelajaran_id_pelajaran FOREIGN KEY (id_pelajaran) REFERENCES pelajaran (id_pelajaran) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE guru (
  id_guru int(11) NOT NULL AUTO_INCREMENT,
  nama varchar(60) NOT NULL,
  kontak varchar(20) DEFAULT NULL,
  email varchar(60) DEFAULT NULL,

  PRIMARY KEY (id_guru)
);


CREATE TABLE siswa (
  id_siswa int(11) NOT NULL AUTO_INCREMENT,
  nama varchar(60) DEFAULT NULL,
  kontak varchar(20) DEFAULT NULL,
  email varchar(60) DEFAULT NULL,

  PRIMARY KEY (id_siswa)
);


CREATE TABLE user_pendidikan (
  id_user_pendidikan int(11) NOT NULL AUTO_INCREMENT,
  username varchar(60) unique NOT NULL,
  pass varchar(60) NOT NULL,
  peran enum('siswa','guru') NOT NULL DEFAULT 'siswa',
  tanggal_dibuat datetime DEFAULT current_timestamp(),
  id_guru int(11) DEFAULT NULL,
  id_siswa int(11) DEFAULT NULL,

  PRIMARY KEY (id_user_pendidikan),
  CONSTRAINT fk_user_id_guru_references_guru_id_guru FOREIGN KEY (id_guru) REFERENCES guru (id_guru) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_user_id_siswa_references_siswa_id_siswa FOREIGN KEY (id_siswa) REFERENCES siswa (id_siswa) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE soal_ujian (
  id_soal_ujian int(11) NOT NULL AUTO_INCREMENT,
  pertanyaan text DEFAULT NULL,
  jawaban enum('1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '1',
  j1 varchar(500),
  j2 varchar(500),
  j3 varchar(500),
  j4 varchar(500),
  j5 varchar(500),
  j6 varchar(500),
  j7 varchar(500),
  j8 varchar(500),
  j9 varchar(500),
  j10 varchar(500),
  id_guru int(11) NOT NULL,
  id_data_ujian int(11) NOT NULL,

  PRIMARY KEY (id_soal_ujian),
  CONSTRAINT fk_soal_ujian_id_data_ujian_references_data_ujian_id_data_ujian FOREIGN KEY (id_data_ujian) REFERENCES data_ujian (id_data_ujian) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_soal_ujian_id_guru_references_guru_id_guru FOREIGN KEY (id_guru) REFERENCES guru (id_guru) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE pengerjaan (
  id_pengerjaan int(11) NOT NULL AUTO_INCREMENT,
  jawaban enum('1','2','3','4','5','6','7','8','9','10','11') NOT NULL DEFAULT '11',
  waktu_mulai datetime DEFAULT current_timestamp(),
  id_soal_ujian int(11) NOT NULL,
  id_siswa int(11) NOT NULL,

  PRIMARY KEY (id_pengerjaan),
  CONSTRAINT fk_pengerjaan_id_siswa_references_siswa_id_siswa FOREIGN KEY (id_siswa) REFERENCES siswa (id_siswa) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_pengerjaan_id_soal_ujian_references_soal_ujian_id_soal_ujian FOREIGN KEY (id_soal_ujian) REFERENCES soal_ujian (id_soal_ujian) ON DELETE CASCADE ON UPDATE CASCADE
);



INSERT INTO pelajaran (nama_pelajaran) VALUES
('Matematika'),
('Bahasa Inggris'),
('Kimia'),
('Ilmu Pengetahuan Alam'),
('Ilmu Pengetahuan Sosial'),
('Fisika'),
('Pendidikan Kewarganegaraan'),
('Pendidikan Jasmani dan Kesehatan'),
('Seni Budaya'),
('Prakarya'),
('Biologi'),
('Ekonomi'),
('Bahasa Indonesia'),
('Geografi'),
('Sejarah'),
('TIK (Teknologi Informasi dan Komunikasi)'),
('Bahasa Jawa'),
('Bahasa Arab'),
('Sosiologi'),
('Antropologi');