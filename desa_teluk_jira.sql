-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Agu 2023 pada 05.26
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa_teluk_jira`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bpd`
--

CREATE TABLE `bpd` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_sk` varchar(64) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'profile.png',
  `awal_masa_bakti` year(4) NOT NULL,
  `akhir_masa_bakti` year(4) NOT NULL,
  `no_hp` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bpd`
--

INSERT INTO `bpd` (`id`, `nama`, `jabatan`, `no_sk`, `foto`, `awal_masa_bakti`, `akhir_masa_bakti`, `no_hp`) VALUES
(1, 'AJMAIN, S.Si', 'KETUA BPD', 'Kpts. 265/III/HK.2021', 'profile.png', '2021', '2027', '085376951727'),
(2, 'HIPNI', 'WAKIL', 'Kpts. 265/III/HK.2021', 'profile.png', '2021', '2027', '085376951735'),
(3, 'RAHMALINDA', 'BENDAHARA', 'Kpts. 265/III/HK.2021', 'profile.png', '2021', '2027', '085265261517'),
(4, 'ZAHRAINI', 'SEKRETARIS', 'Kpts. 265/III/HK.2021', 'profile.png', '2021', '2027', '082260174697'),
(5, 'ABD.MUIN', 'ANGGOTA', 'Kpts. 265/III/HK.2021', 'profile.png', '2021', '2027', '082239615445'),
(6, 'DANO PUTRA', 'ANGGOTA', 'Kpts. 265/III/HK.2021', 'profile.png', '2021', '2027', '082317174151'),
(7, 'M.RIDHA', 'ANGGOTA', 'Kpts. 265/III/HK.2021', 'profile.png', '2021', '2027', '085213922819');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lokasi` varchar(200) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diperbarui_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `publikasi` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `nama`, `deskripsi`, `waktu`, `lokasi`, `foto`, `video`, `dibuat_pada`, `diperbarui_pada`, `publikasi`) VALUES
(7, 'Musyawarah Desa RKPDes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel lacus sed odio consectetur porta id nec metus. Nullam ut nisl lacinia, posuere odio vel, sollicitudin nisl. Donec felis sapien, lacinia sed nibh id, interdum luctus ligula. Fusce arcu nunc, molestie et risus eu, posuere ornare ante. Sed vestibulum dui ipsum, eu euismod ipsum sollicitudin at. Proin dignissim felis sit amet ante vehicula imperdiet. Praesent ipsum ligula, convallis porta nibh elementum, eleifend euismod libero. Nulla facilisi. Nullam at sem sed urna sagittis interdum. Donec viverra, nulla eu pellentesque euismod, magna lorem vehicula purus, et sagittis ante lorem eu erat. Nunc varius orci sed est luctus, ac vehicula lectus dictum. Quisque elementum ultrices mi, a tincidunt nibh. Quisque et hendrerit lacus, in malesuada magna.\r\n\r\nDuis volutpat justo a ligula interdum laoreet. In scelerisque purus ut lacinia maximus. Phasellus ac tincidunt odio. Suspendisse tempor magna purus, in aliquet ante tincidunt vel. Donec dictum malesuada condimentum. Donec pellentesque leo ut velit finibus, quis pellentesque magna pharetra. Vivamus non leo interdum, tincidunt dolor id, semper quam. Nullam iaculis vehicula diam, sit amet lobortis nulla molestie ut. Morbi congue hendrerit odio, in finibus diam egestas sit amet. Cras at turpis ut erat porttitor consectetur. In eu molestie metus. Donec sed nisl consectetur, vulputate nisi nec, lacinia orci.\r\n\r\nUt posuere id lacus sed malesuada. In vel ultrices neque, at sagittis turpis. Mauris neque enim, posuere eleifend mi sed, rhoncus facilisis metus. Nullam placerat sapien quam, ut dictum justo consectetur at. Suspendisse porttitor tincidunt est condimentum tempor. In et massa dui. Fusce magna erat, iaculis non iaculis sit amet, tincidunt vitae purus. Duis varius mauris feugiat, ullamcorper arcu et, condimentum eros. Vivamus dapibus, lorem vitae pharetra varius, risus erat dignissim ante, ac porta nibh justo sit amet nunc. Pellentesque at risus sed tellus egestas eleifend.', '2023-08-18 01:00:00', 'Balai Desa Teluk Jira', '64e6d7d67f643-WhatsApp Image 2023-08-24 at 11.08.20.jpeg', 'https://youtu.be/sNooYOy-Dhk?si=guAPWZK-3Zi01mc7', '2023-08-22 12:59:45', '2023-08-28 03:20:54', 1),
(8, 'Upacara 17 Agustus 2023', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel lacus sed odio consectetur porta id nec metus. Nullam ut nisl lacinia, posuere odio vel, sollicitudin nisl. Donec felis sapien, lacinia sed nibh id, interdum luctus ligula. Fusce arcu nunc, molestie et risus eu, posuere ornare ante. Sed vestibulum dui ipsum, eu euismod ipsum sollicitudin at. Proin dignissim felis sit amet ante vehicula imperdiet. Praesent ipsum ligula, convallis porta nibh elementum, eleifend euismod libero. Nulla facilisi. Nullam at sem sed urna sagittis interdum. Donec viverra, nulla eu pellentesque euismod, magna lorem vehicula purus, et sagittis ante lorem eu erat. Nunc varius orci sed est luctus, ac vehicula lectus dictum. Quisque elementum ultrices mi, a tincidunt nibh. Quisque et hendrerit lacus, in malesuada magna.\r\n\r\nDuis volutpat justo a ligula interdum laoreet. In scelerisque purus ut lacinia maximus. Phasellus ac tincidunt odio. Suspendisse tempor magna purus, in aliquet ante tincidunt vel. Donec dictum malesuada condimentum. Donec pellentesque leo ut velit finibus, quis pellentesque magna pharetra. Vivamus non leo interdum, tincidunt dolor id, semper quam. Nullam iaculis vehicula diam, sit amet lobortis nulla molestie ut. Morbi congue hendrerit odio, in finibus diam egestas sit amet. Cras at turpis ut erat porttitor consectetur. In eu molestie metus. Donec sed nisl consectetur, vulputate nisi nec, lacinia orci.\r\n\r\nUt posuere id lacus sed malesuada. In vel ultrices neque, at sagittis turpis. Mauris neque enim, posuere eleifend mi sed, rhoncus facilisis metus. Nullam placerat sapien quam, ut dictum justo consectetur at. Suspendisse porttitor tincidunt est condimentum tempor. In et massa dui. Fusce magna erat, iaculis non iaculis sit amet, tincidunt vitae purus. Duis varius mauris feugiat, ullamcorper arcu et, condimentum eros. Vivamus dapibus, lorem vitae pharetra varius, risus erat dignissim ante, ac porta nibh justo sit amet nunc. Pellentesque at risus sed tellus egestas eleifend.', '2023-08-17 02:00:00', 'Kantor Camat Tempuling', '64e6da8f73c4d-IMG20230817093657.jpg', '', '2023-08-22 14:01:00', '2023-08-28 02:00:44', 0),
(9, 'Pembukaan Perlombaan Voli 17 Agustus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel lacus sed odio consectetur porta id nec metus. Nullam ut nisl lacinia, posuere odio vel, sollicitudin nisl. Donec felis sapien, lacinia sed nibh id, interdum luctus ligula. Fusce arcu nunc, molestie et risus eu, posuere ornare ante. Sed vestibulum dui ipsum, eu euismod ipsum sollicitudin at. Proin dignissim felis sit amet ante vehicula imperdiet. Praesent ipsum ligula, convallis porta nibh elementum, eleifend euismod libero. Nulla facilisi. Nullam at sem sed urna sagittis interdum. Donec viverra, nulla eu pellentesque euismod, magna lorem vehicula purus, et sagittis ante lorem eu erat. Nunc varius orci sed est luctus, ac vehicula lectus dictum. Quisque elementum ultrices mi, a tincidunt nibh. Quisque et hendrerit lacus, in malesuada magna.\r\n\r\nDuis volutpat justo a ligula interdum laoreet. In scelerisque purus ut lacinia maximus. Phasellus ac tincidunt odio. Suspendisse tempor magna purus, in aliquet ante tincidunt vel. Donec dictum malesuada condimentum. Donec pellentesque leo ut velit finibus, quis pellentesque magna pharetra. Vivamus non leo interdum, tincidunt dolor id, semper quam. Nullam iaculis vehicula diam, sit amet lobortis nulla molestie ut. Morbi congue hendrerit odio, in finibus diam egestas sit amet. Cras at turpis ut erat porttitor consectetur. In eu molestie metus. Donec sed nisl consectetur, vulputate nisi nec, lacinia orci.\r\n\r\nUt posuere id lacus sed malesuada. In vel ultrices neque, at sagittis turpis. Mauris neque enim, posuere eleifend mi sed, rhoncus facilisis metus. Nullam placerat sapien quam, ut dictum justo consectetur at. Suspendisse porttitor tincidunt est condimentum tempor. In et massa dui. Fusce magna erat, iaculis non iaculis sit amet, tincidunt vitae purus. Duis varius mauris feugiat, ullamcorper arcu et, condimentum eros. Vivamus dapibus, lorem vitae pharetra varius, risus erat dignissim ante, ac porta nibh justo sit amet nunc. Pellentesque at risus sed tellus egestas eleifend.', '2023-08-10 09:00:00', 'Jl. Bandes RT 05', '64e6de9b5cebc-WhatsApp Image 2023-08-24 at 11.36.10.jpeg', '', '2023-08-22 14:01:45', '2023-08-24 04:38:28', 1),
(11, 'Penerimaan Mahasiswa KKN UIN SUSKA Riau', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel lacus sed odio consectetur porta id nec metus. Nullam ut nisl lacinia, posuere odio vel, sollicitudin nisl. Donec felis sapien, lacinia sed nibh id, interdum luctus ligula. Fusce arcu nunc, molestie et risus eu, posuere ornare ante. Sed vestibulum dui ipsum, eu euismod ipsum sollicitudin at. Proin dignissim felis sit amet ante vehicula imperdiet. Praesent ipsum ligula, convallis porta nibh elementum, eleifend euismod libero. Nulla facilisi. Nullam at sem sed urna sagittis interdum. Donec viverra, nulla eu pellentesque euismod, magna lorem vehicula purus, et sagittis ante lorem eu erat. Nunc varius orci sed est luctus, ac vehicula lectus dictum. Quisque elementum ultrices mi, a tincidunt nibh. Quisque et hendrerit lacus, in malesuada magna.\r\n\r\nDuis volutpat justo a ligula interdum laoreet. In scelerisque purus ut lacinia maximus. Phasellus ac tincidunt odio. Suspendisse tempor magna purus, in aliquet ante tincidunt vel. Donec dictum malesuada condimentum. Donec pellentesque leo ut velit finibus, quis pellentesque magna pharetra. Vivamus non leo interdum, tincidunt dolor id, semper quam. Nullam iaculis vehicula diam, sit amet lobortis nulla molestie ut. Morbi congue hendrerit odio, in finibus diam egestas sit amet. Cras at turpis ut erat porttitor consectetur. In eu molestie metus. Donec sed nisl consectetur, vulputate nisi nec, lacinia orci.\r\n\r\nUt posuere id lacus sed malesuada. In vel ultrices neque, at sagittis turpis. Mauris neque enim, posuere eleifend mi sed, rhoncus facilisis metus. Nullam placerat sapien quam, ut dictum justo consectetur at. Suspendisse porttitor tincidunt est condimentum tempor. In et massa dui. Fusce magna erat, iaculis non iaculis sit amet, tincidunt vitae purus. Duis varius mauris feugiat, ullamcorper arcu et, condimentum eros. Vivamus dapibus, lorem vitae pharetra varius, risus erat dignissim ante, ac porta nibh justo sit amet nunc. Pellentesque at risus sed tellus egestas eleifend.', '2023-07-24 02:00:00', 'Kantor Desa Teluk Jira', '64e6ddb0c9015-WhatsApp Image 2023-08-24 at 11.32.12.jpeg', '', '2023-08-24 04:33:52', '2023-08-24 04:34:33', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`) VALUES
(15, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perangkat_desa`
--

CREATE TABLE `perangkat_desa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_sk` varchar(64) NOT NULL,
  `no_hp` varchar(16) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nipd` varchar(25) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'profile.png',
  `periode_awal` year(4) DEFAULT NULL,
  `periode_akhir` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perangkat_desa`
--

INSERT INTO `perangkat_desa` (`id`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jabatan`, `no_sk`, `no_hp`, `alamat`, `nipd`, `foto`, `periode_awal`, `periode_akhir`) VALUES
(1, 'Suryadi Nata', 'Teluk Jira', '1974-12-31', 'Kepala Desa', 'Kpts.1014/XII/HK.2021', '085265639579', 'JL. Propinsi RT 03 RW 01', '19741231052007 1 0031', 'profile.png', '2022', '2027'),
(2, 'SUSESWO HUSODO, S.Kom', '', '0000-00-00', 'Sekretaris Desa', 'Kpts.6/PEM-DTJ/III/2018  tanggal 07 Maret 2018', '082299758078', 'Parit no. 07 RT 011 RW 004', '1989041105007 2 0280', '64e6e420db6b3-photo_6284887848704391127_y.jpg', '0000', '0000'),
(9, 'AZHARI, S.Kom', '', '0000-00-00', 'Kaur Keuangan ', 'Kpts.7/PEM-DTJ/III/2018 Tanggal 07 Maret 2018', '081275385559', 'Jl. Propinsi RT 001 RW 001\r\n', '19940410052007 2 0281', 'profile.png', '0000', '0000'),
(10, 'SYAFRI, S.Pd.I', '', '0000-00-00', 'Kaur Tata Usaha dan Umum', 'Kpts.9/PEM-DTJ/III/2018  Tanggal 07 Maret 2018', '082173042362', 'Lr. Manggis RT 006 RW 002 \r\n', '19910831052007 2 0286', '64e6e2f31d4fb-photo_6284887848704391115_y.jpg', '0000', '0000'),
(11, 'ARSAD', '', '0000-00-00', 'Kaur Perencanaan', 'Kpts.8/PEM-DTJ/III/2018  Tanggal 07 maret 2018', '081378866488', 'Jl. Inpres RT 004 RW 002\r\n', '19800705052007 2 0283', 'profile.png', '0000', '0000'),
(12, 'ERMAWATI, SP', '', '0000-00-00', 'Kasi Pelayanan Masyarakat', 'Kpts.12/PEM-DTJ/III/2018  Tanggal 07 maret 2018 ', '082297807864', 'Jl. Proipinsi RT 005 RW 002\r\n', '19850418052007 2 0284', '64e6e39868551-photo_6284887848704391126_y.jpg', '0000', '0000'),
(13, 'MUHAMMAD ARBAIN', '', '0000-00-00', 'Kasi Pemerintahan ', 'Kpts.11/PEM-DTJ/III/2018  Tanggal 07 maret 2018 ', '08126470712', 'Jl. Propinsi RT 003 RW 001\r\n', '19861005052007 2 0285', '64e6e6cef1fa2-photo_6284887848704391131_y.jpg', '0000', '0000'),
(14, 'AGUS SUGIHARTO', '', '0000-00-00', 'Kasi Pemberdayaan Masyarakat ', 'Kpts.10/PEM-DTJ/III/2018  Tanggal 07 Maret 2018', '085213311771', 'Jl. Propinsi RT 001 RW 001\r\n', '19850913052007 2 0286', '64e6e23560229-WhatsApp Image 2023-08-24 at 11.51.06.jpeg', '0000', '0000'),
(15, 'YANSAH', '', '0000-00-00', 'Kepala Dusun Karya Baru', 'Kpts.13/PEM-DTJ/III/2018 Tanggal 07 Maret 2018', '085278746038', 'Parit no. 10 RT 007 RW 003\r\n', '19761020052007 2 0291', '64e6e64f46f43-photo_6284887848704391130_y.jpg', '0000', '0000'),
(16, 'MAHYUDI', '', '0000-00-00', 'Kepala Dusun Kapal Pecah ', 'Kpts.15/PEM-DTJ/III/2018  Tanggal 07 maret 2018 ', '085278054916', 'Jl. Propinsi RT 003 RW 001\r\n', '19790626052007 2 0288', '64e6e57ad6bef-photo_6284887848704391128_y.jpg', '0000', '0000'),
(17, 'IBRAHIM', '', '0000-00-00', 'Kepala Dusun Harapan ', 'Kpts.14/PEM-DTJ/III/2018 Tanggal 07 Maret 2018 ', '081268365150', 'Parit no. 06 RT 012 RW 004\r\n', '19821231052007 2 0299', 'profile.png', '0000', '0000'),
(18, 'SYAHRILAWATI, S.Pd.I', '', '0000-00-00', 'Staf Kaur Keuangan ', 'Kpts: 04/PEM-DTJ/Dk/I/2023', '082335829919', 'Lr. Sukun RT 006 RW 002\r\n', '-', '64e6e5fc33425-photo_6284887848704391129_y.jpg', '0000', '0000'),
(19, 'HARIANTO , ST', '', '0000-00-00', 'Operator ', 'Kpts: 07/PEM-DTJ/Dk/I/2023', '085264861259', 'Lr. Sukun RT 006 RW 002\r\n', '-', 'profile.png', '0000', '0000');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bpd`
--
ALTER TABLE `bpd`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bpd`
--
ALTER TABLE `bpd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
