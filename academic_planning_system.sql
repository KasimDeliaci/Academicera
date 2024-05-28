-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 28 May 2024, 20:03:46
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `academic_planning_system`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `due_date` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_name` varchar(100) NOT NULL,
  `instructor` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `courses`
--

INSERT INTO `courses` (`id`, `user_id`, `course_name`, `instructor`, `start_date`, `end_date`, `description`, `tag_id`) VALUES
(1, 7, 'alskjf', 'das.nd', '2024-05-09', '2024-05-03', 'asdas', 2),
(10, 7, 'Web Tabanlı Programlama', 'Turgay Tugay Bilgin', '2024-05-01', '2024-05-31', 'HTML, CSS, JS konuları\r\nBootstrap vs.\r\nYouTube: bilmemnevideo.link.com', 11),
(11, 7, 'Makine Öğrenmesi', 'Ergün Gümüş', '2024-05-01', '2024-06-28', 'Falan filan\r\ncoursera bak\r\nçalış\r\ndeneme', 12),
(12, 7, 'deneme7', 'falan hoca', '2024-05-01', '2024-05-29', 'ailknfjikLAS\r\nİLKANSFİLKJN\r\nASLŞMF;ŞLSAM\r\nASLŞFSA\r\nASFKLNAS\r\nAS;ŞLFJM', 13),
(17, 10, 'ELEC 230', 'Egitmen1', '2024-05-09', '2024-05-29', 'C dersi bu açıklama yatay olarak çok uzun ve çok çok çok saçma bir aciklamna olacak ama denemek icin yapmak zorundayım\r\n', 18),
(18, 10, 'HIST 300', 'Eda Daloğlu', '2024-05-09', '2024-05-21', 'Bu dersin allah belasını versin essay yazılan tarih dersi mi olurmuş ne kastınız yahu bu aciklama yatay olarak\r\ncok\r\nCok\r\nCok\r\nÇok\r\nCOOOOK\r\nuzun\r\n', 19),
(19, 10, 'deneme3', 'denem3', '2024-05-17', '2024-05-29', 'akjsfnnasf\r\nFLŞAJ\r\n-Bu dersin allah belasını versin essay yazılan tarih dersi mi olurmuş ne kastınız yahu bu aciklama yatay olarak cok Cok Cok Çok COOOOK uzun\r\n-Bu dersin allah belasını versin essay yazılan tarih dersi mi olurmuş ne kastınız yahu bu aciklama yatay olarak cok Cok Cok Çok COOOOK uzun', 20),
(20, 10, 'deneme4', 'deneme4', '2024-05-01', '2024-05-31', 'a', 21),
(21, 10, 'deneme5', 'aras', '2024-05-16', '2024-05-19', 'afasfa', 22),
(22, 10, 'deneme6', 'afaosfals', '2024-05-01', '2024-05-25', 'sladgkmALŞG', 23),
(23, 10, 'selam', 'selam1', '2024-05-08', '2024-05-29', 'lsikdNFGKNSDGİKLNSlsikndgiklsndn\r\n', 24),
(24, 10, 'selam 2', 'selam2', '2024-05-17', '2024-05-31', 'dalfjaislfmmsilakmsfASF', 25),
(25, 10, 'SELAM 3', 'falanfilam', '2024-05-05', '2024-05-23', 'afnANSİLKNfilknsNFİLŞKNSDF', 26),
(36, 12, 'HIST300', 'Eda Daloğlu', '2024-05-09', '2024-05-23', 'Dünyanın en kötü zııırrs', 37),
(39, 7, 'COMP341', 'Bilmiyoruz', '2024-05-08', '2024-05-17', 'ne yabayi? \r\nuzun\r\naçıklama\r\nhidden\r\nYap', 40),
(40, 7, 'Comp1', 'fatma Güney', '2024-05-22', '2024-05-23', 'wow', 41),
(41, 12, 'MBGE200', 'Uğur Şahin', '2024-05-02', '2024-05-10', 'Hazır tag kullanımı denemesi\r\n', 37),
(42, 13, 'CENG102', 'Turgay Tugay Bilgim', '2024-05-09', '2024-05-23', '0', 42),
(43, 13, 'CENG304', 'Hatırlamıyorum', '2024-05-16', '2024-06-10', 'Görüntü işleme\r\nzor ders, sıkı tut', 42),
(57, 11, 'asdas', 'sdasdasdasd', '2024-05-15', '2024-05-09', 'afsas', 43);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `study_plans`
--

CREATE TABLE `study_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `plan_date` date DEFAULT NULL,
  `goals` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tag_name` varchar(50) NOT NULL,
  `color` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tags`
--

INSERT INTO `tags` (`id`, `user_id`, `tag_name`, `color`) VALUES
(1, 7, 'asd', '#583400'),
(2, 7, 'asd', '#583400'),
(3, 8, 'YouTube', '#d95000'),
(4, 8, 'udemy', '#f9d3e0'),
(5, 9, 'üniversite', '#00c7fc'),
(6, 9, 'Üniversite', '#7c2a00'),
(7, 9, 'deneme', '#9aa60e'),
(8, 9, 'deneme 2 tag', '#9a244f'),
(9, 9, 'deneme3 tag', '#be38f3'),
(10, 9, 'deneme 4 tag', '#4f7a28'),
(11, 7, 'Üniversite', '#cce8b5'),
(12, 7, 'Üniversite', '#cce8b5'),
(13, 7, 'üniversite', '#a96800'),
(14, 9, 'Üniversite', '#a77b00'),
(15, 9, 'Üniversite', '#0061ff'),
(16, 8, 'hahah', '#aa7942'),
(17, 8, 'alakns', '#f5ec00'),
(18, 10, 'Üniversite', '#ff6a00'),
(19, 10, 'Üniversite', '#c3d117'),
(20, 10, 'Üniversite', '#74a7fe'),
(21, 10, 'macnookl', '#785700'),
(22, 10, 'afsfa', '#ff4013'),
(23, 10, 'aflkma', '#ed719e'),
(24, 10, 'Udemy', '#9a244f'),
(25, 10, 'falan', '#7a4a00'),
(26, 10, 'zaxdzırt', '#ff6a00'),
(27, 9, 'selam', '#9a244f'),
(28, 11, 'Üniversite', '#b18cfe'),
(29, 11, 'Üniversite', '#b18cfe'),
(30, 11, 'Üniversite', '#b18cfe'),
(31, 11, 'Üniversite', '#b18cfe'),
(32, 11, 'Üniversite', '#b18cfe'),
(33, 11, 'Üniversite', '#b18cfe'),
(34, 11, 'Üniversite', '#b18cfe'),
(35, 11, 'Üniversite', '#b18cfe'),
(36, 11, 'Üniversite', '#b18cfe'),
(37, 12, 'Koç Üniversitesi', '#669c35'),
(38, 12, 'Koç Üniversitesi', '#669c35'),
(39, 12, 'Koç Üniversitesi', '#669c35'),
(40, 7, 'Yuno', '#be38f3'),
(41, 7, 'adası', '#b92d5d'),
(42, 13, 'BTU', '#74a7fe'),
(43, 11, 'Bursa Teknik', '#ed719e'),
(44, 11, 'merhaba', '#9aa60e'),
(45, 11, '', '#000000'),
(46, 11, '', '#000000'),
(47, 11, '', '#000000'),
(48, 9, 'POST', '#ffa57d'),
(49, 9, 'LUTFEN', '#00a3d7'),
(50, 9, 'asdas', '#e32400'),
(51, 11, '', '#000000'),
(52, 9, 'laf', '#0433ff'),
(53, 9, 'asffsafasf', '#4d22b3'),
(54, 11, '', '#000000'),
(55, 11, '', '#000000'),
(56, 11, 'BTÜ', '#53d5fd'),
(57, 12, '', '#000000'),
(58, 12, '', '#000000'),
(59, 11, 'asdasd', '#ff8c82');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `password`, `email`, `created_at`) VALUES
(7, 'kasimx', 'kasim', 'deliaci', '$2y$10$zuQSI2TdgZnZQAxCzDm82.YvgqSQCIOKUdc6VWVOYcGUDJow49r4y', 'kasimdeliaci067@gmail.com', '2024-05-22 23:37:43'),
(8, 'mof', 'muhammed', 'selvi', '$2y$10$.3ZwKfMwisy36eCaV8wpk.doqMoDModE0hbaR.jwh1Yeq2.bHRS7a', 'kasimdel@gmail.com', '2024-05-23 10:28:41'),
(9, 'ykorkmaz', 'yunus emre ', 'korkmaz', '$2y$10$CByCwYQqvpd0xP7haHx7sOV/WtEo4tQySd2N.USA92vRP8UEwKtba', 'ynskrkmz@gmail.com', '2024-05-23 12:18:23'),
(10, 'pelboz', 'pelinsu', 'bozkus', '$2y$10$FG61eXAQN91qA1roz8.Rtuta0/dNX29ufVsqEPztnqFgVvJSVpZaK', 'pel@gmail.com', '2024-05-24 05:41:53'),
(11, 'ablam', 'gülsüm', 'karci', '$2y$10$1/R/KoIA0MUb1kDqDd1P.OsHAxso6yIDu4nNf38bexpiGzK39yp8a', 'falanfilan@gmail.com', '2024-05-25 07:11:27'),
(12, 'efeyök', 'efe', 'yörük', '$2y$10$kPuYfT7O3PDrjUcCPKca7eYKodTekk3iShftIW.Se0CYYGpTn2/0i', 'efe@gmail.com', '2024-05-25 14:58:51'),
(13, 'eroz', 'eren', 'ozer', '$2y$10$wL3FekVZsi9.IObLBUR0UeDjYHSPGsmP/qJ2T7xG3/76wAC6Wqclq', 'eren@gmail.com', '2024-05-27 09:51:49');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Tablo için indeksler `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Tablo için indeksler `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Tablo için indeksler `study_plans`
--
ALTER TABLE `study_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Tablo için indeksler `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Tablo için AUTO_INCREMENT değeri `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `study_plans`
--
ALTER TABLE `study_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Tablo kısıtlamaları `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Tablo kısıtlamaları `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Tablo kısıtlamaları `study_plans`
--
ALTER TABLE `study_plans`
  ADD CONSTRAINT `study_plans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `study_plans_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Tablo kısıtlamaları `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
