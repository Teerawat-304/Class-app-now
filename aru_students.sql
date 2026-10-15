-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 15, 2026 at 07:04 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aru_students`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` bigint UNSIGNED NOT NULL,
  `faculty_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `faculty_name`, `faculty_id`, `created_at`, `updated_at`) VALUES
(2, 'วิทย์ศาสตร์เเละเทคโนโลยี', '106', '2026-07-13 02:38:38', '2026-08-23 20:24:07'),
(4, 'มนุษย์ศาสตร์เเละสังคมศาสตร์', '107', '2026-08-23 20:33:51', '2026-09-20 21:33:51'),
(5, 'วิทยาการจัดการ', '3', '2026-09-20 21:33:19', '2026-09-20 21:33:19'),
(6, 'ครุศาสตร์', '4', '2026-09-20 21:34:09', '2026-09-20 21:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_29_031925_create_faculty_table', 2),
(5, '2026_06_29_033020_create_program_table', 3),
(6, '2026_06_29_033306_create_students_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` bigint UNSIGNED NOT NULL,
  `program_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `program_name`, `program_id`, `faculty_id`, `created_at`, `updated_at`) VALUES
(1, 'วิทยาการคอมพิวเตอร์', 'CS103', '106', '2026-07-13 02:38:38', '2026-10-15 10:19:54'),
(3, 'ai', 'CS102', '106', '2026-07-19 19:21:49', '2026-07-19 19:21:49'),
(4, 'เคมี', 'CS106', '106', '2026-08-23 20:21:20', '2026-08-23 20:21:20'),
(5, 'กฏหมาย1', 'CS107', '107', '2026-08-23 20:35:01', '2026-09-20 20:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `register_id` int NOT NULL,
  `register_date` date NOT NULL,
  `student_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`register_id`, `register_date`, `student_id`, `semester`) VALUES
(1, '2026-09-21', '16732011', '1/2569'),
(2, '2026-09-21', '16732012', '1/2569'),
(3, '2026-10-15', '16732000', '1/2569'),
(4, '2026-10-15', '16732072', '1/2569'),
(5, '2026-10-15', '16732114', '1/2569'),
(6, '2026-10-15', '16732072', '2/2569');

-- --------------------------------------------------------

--
-- Table structure for table `registerr_detail`
--

CREATE TABLE `registerr_detail` (
  `detail_id` int NOT NULL,
  `register_id` int NOT NULL,
  `subject_code` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` int NOT NULL,
  `subscore` int NOT NULL,
  `midterm_score` int NOT NULL,
  `final_score` int NOT NULL,
  `total_score` int NOT NULL,
  `grade` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registerr_detail`
--

INSERT INTO `registerr_detail` (`detail_id`, `register_id`, `subject_code`, `teacher_id`, `subscore`, `midterm_score`, `final_score`, `total_score`, `grade`) VALUES
(1, 1, '110', 15456625, 20, 20, 20, 60, 'C'),
(2, 2, '110', 15456625, 30, 20, 10, 60, 'C'),
(3, 3, 'CS1016', 15456630, 20, 20, 10, 50, 'D'),
(4, 4, 'CS1016', 15456630, 0, 0, 0, 0, ''),
(5, 4, '110', 15456625, 0, 0, 0, 0, ''),
(6, 4, 'cs105', 15456631, 20, 15, 25, 60, 'C'),
(7, 4, '109', 15456621, 0, 0, 0, 0, ''),
(8, 4, 'CS1003', 15456631, 15, 20, 25, 60, 'C'),
(9, 5, 'cs105', 15456631, 25, 10, 30, 65, 'C+'),
(10, 5, '110', 15456631, 20, 15, 20, 55, 'D+'),
(11, 5, 'CS1003', 15456631, 20, 25, 20, 65, 'C+'),
(12, 6, 'cs105', 15456631, 20, 20, 20, 60, 'C'),
(13, 6, '109', 15456631, 20, 20, 40, 80, 'A'),
(14, 6, '110', 15456631, 21, 23, 40, 84, 'A'),
(15, 6, 'CS1016', 15456631, 30, 24, 28, 82, 'A'),
(16, 6, 'CS1003', 15456631, 30, 20, 25, 75, 'B+');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gZ7E0pFxHqOQ41O9oIVR2SDCz2oEiWbxqwQ1EJLm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.142.0 Chrome/150.0.7871.250 Electron/43.7.7 Safari/537.36', 'eyJfdG9rZW4iOiJxQVZEU2lDNG5oZEt1NVNMenp6TUlHcERENXUwNnFybFdYODA1V1RSIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3N0dWRlbnRcL2Rhc2hib2FyZCIsInJvdXRlIjoic3R1ZGVudC5kYXNoYm9hcmQifSwibG9naW5fc3R1ZGVudF81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoiMTY3MzIwNzIifQ==', 1792090425);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `student_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `student_id`, `faculty_id`, `program_id`, `birth_date`, `email`, `address`, `username`, `password`, `created_at`, `updated_at`) VALUES
(7, 'พุฒิชัย', '16732011', '106', 'CS103', '2005-03-31', '16732011@aru.ac.th', '47/1', 'Ton', '$2y$12$apz4hAXETgpLcFAWJgzDrOCTbK3wiMfjFi3Fk3VTF/XGMrA1pEO2O', '2026-09-13 19:00:26', '2026-10-14 19:51:13'),
(8, 'นาย ภูผา', '16732012', '106', 'CS103', '2005-03-11', 'phonebell444@gmail.com', '47/1', 'aum', '$2y$12$PIJK5WQvhCv/VQl7/mxfNut74g/QRotviu2ew2aXVt5CsPuKVZLXO', '2026-09-20 21:13:39', '2026-09-20 21:16:31'),
(9, 'ชัย', '16732000', '106', 'CS103', '2005-03-31', '16732000@aru.ac.th', '47/1', 'Lom', '$2y$12$dtPrr6o62XH9vpfVGcT6feeCfQnR5wIb0mAN59ivJJ9VgfkCJfMaC', '2026-10-14 19:57:00', '2026-10-15 10:26:35'),
(10, 'นายธีรวัจน์ นุฤทธิ์จิรยศ', '16732072', '106', 'CS103', '2005-06-21', '16732072@aru.ac.th', 'Ayuthaya', 'Teerawat', '$2y$12$tR6/TVfJ3U3liprEzzVsNu.SFN5apojIFxgA.hfm1Ch20Ii/B0UMW', '2026-10-15 10:12:33', '2026-10-15 10:12:33'),
(11, 'นาย นนท์', '16732114', '106', 'CS103', '2005-06-21', '16732114@aru.ac.th', 'Ayuthaya', 'Arnon', '$2y$12$AhSUx153zyDd4nw3tEwjN.X7YfoECq9T/jVniVH.b9/6Khm2m0yze', '2026-10-15 11:03:11', '2026-10-15 11:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_code` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_name`, `subject_code`, `credit`) VALUES
('ภาษาอังกฤษ', '109', 3),
('web app', '110', 3),
('OS', 'CS1003', 3),
('วิศวกรรมซอฟต์แวร์และการวิเคราะห์ระบบ', 'CS1016', 3),
('ภาษา c', 'cs105', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subject_teacher`
--

CREATE TABLE `subject_teacher` (
  `id` int NOT NULL,
  `subject_code` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject_teacher`
--

INSERT INTO `subject_teacher` (`id`, `subject_code`, `teacher_id`, `created_at`, `updated_at`) VALUES
(2, '110', 15456625, '2026-09-14 04:39:15', '2026-09-14 04:39:15'),
(3, '110', 15456624, '2026-10-14 18:41:24', '2026-10-15 10:28:12'),
(4, 'CS1016', 15456630, '2026-10-14 20:27:26', '2026-10-14 20:27:26'),
(5, 'cs105', 15456631, '2026-10-15 10:30:15', '2026-10-15 10:30:15'),
(6, '109', 15456621, '2026-10-15 10:30:35', '2026-10-15 10:30:35'),
(7, '109', 15456631, '2026-10-15 10:41:01', '2026-10-15 10:41:01'),
(8, '110', 15456631, '2026-10-15 10:41:08', '2026-10-15 10:41:08'),
(9, 'CS1016', 15456631, '2026-10-15 10:41:13', '2026-10-15 10:41:13'),
(10, 'CS1003', 15456631, '2026-10-15 10:45:03', '2026-10-15 10:45:03'),
(11, 'CS1003', 15456630, '2026-10-15 10:45:08', '2026-10-15 10:45:08');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` int NOT NULL,
  `t_program_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_faculty_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_role` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_name`, `teacher_id`, `t_program_id`, `t_faculty_id`, `t_email`, `t_address`, `t_username`, `t_password`, `t_role`, `created_at`, `updated_at`) VALUES
('สมชาย', 15456621, 'CS106', '107', 'phone@gmail.com', '47/1', 'som', '123456789', 1, NULL, NULL),
('นายสมชาย ใจดี', 15456624, 'CS103', '106', '16732012@aru.ac.th', '47/5', 'so', '$2y$12$7hduB37xcxdaXeUVhiqQ4e8.VIvXba57QzNtRROoO5XH8jj.gLWDm', 1, '2026-09-13 21:02:10', '2026-09-13 21:02:10'),
('โอม', 15456625, 'CS103', '106', 'phonebell555@gmail.com', '45/2', 'ohm', '$2y$12$yFp8MFvDZ7pZGNiaKeJ6AuZLtKkIMe4rP62AlLHL3aPSnz2fyaJg2', 1, '2026-09-13 21:30:47', '2026-09-13 21:30:47'),
('ต้น', 15456628, 'CS102', '106', '16732011@aru.ac.th', '47/5', 'Ton', '$2y$12$5wllLMB0hoal4Jtcruyn7u3MGge35V6rj4Up5Ae8HaorIakm8ktV2', 1, '2026-10-14 18:30:49', '2026-10-14 18:30:49'),
('aum1', 15456630, 'CS102', '106', '16732022@aru.ac.th', '47/5', 'Aum', '$2y$12$chCHWLlfzdwqfk6sAkWxSeD.lubcVBLZHNzzQ.9mZGksFkLlAK4tC', 1, '2026-10-14 20:12:46', '2026-10-14 20:24:07'),
('นายธีรวัจน์ นุฤทธิ์จิรยศ', 15456631, 'CS103', '106', '16732072@aru.ac.th', 'Ayuthaya', 'Teerawat', '$2y$12$/7waA37qD4cjKMEnjkbs5.5nQ7E2rbmIJT1vakuSOwgIWuuNolQ2e', 1, '2026-10-15 10:16:33', '2026-10-15 10:16:33'),
('Admin', 15456632, 'CS103', '106', 'Admin@aru.ac.th', 'Ayuthaya', 'Admin', '$2y$12$VKF.pwvjCgnm4rHFWxEKA.bk287/FbfyXnCXR5qkrt/W73uj9uIze', 0, '2026-10-15 10:36:11', '2026-10-15 10:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculty_faculty_id_unique` (`faculty_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_program_id_unique` (`program_id`),
  ADD KEY `program_faculty` (`faculty_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`register_id`),
  ADD KEY `register_student` (`student_id`);

--
-- Indexes for table `registerr_detail`
--
ALTER TABLE `registerr_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `detail_subject` (`subject_code`),
  ADD KEY `detail_register` (`register_id`),
  ADD KEY `detail_teacher` (`teacher_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_id_unique` (`student_id`),
  ADD UNIQUE KEY `students_username_unique` (`username`),
  ADD KEY `students_faculty_id_foreign` (`faculty_id`),
  ADD KEY `students_program_id_foreign` (`program_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_code`);

--
-- Indexes for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_teacher1` (`subject_code`),
  ADD KEY `subject_teacher2` (`teacher_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `program_teacher` (`t_program_id`),
  ADD KEY `faculty_teacher` (`t_faculty_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `register_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registerr_detail`
--
ALTER TABLE `registerr_detail`
  MODIFY `detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15456633;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `program_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `register`
--
ALTER TABLE `register`
  ADD CONSTRAINT `register_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `registerr_detail`
--
ALTER TABLE `registerr_detail`
  ADD CONSTRAINT `detail_register` FOREIGN KEY (`register_id`) REFERENCES `register` (`register_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detail_subject` FOREIGN KEY (`subject_code`) REFERENCES `subject` (`subject_code`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detail_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `program` (`program_id`) ON DELETE SET NULL;

--
-- Constraints for table `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD CONSTRAINT `subject_teacher1` FOREIGN KEY (`subject_code`) REFERENCES `subject` (`subject_code`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `subject_teacher2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `faculty_teacher` FOREIGN KEY (`t_faculty_id`) REFERENCES `faculty` (`faculty_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `program_teacher` FOREIGN KEY (`t_program_id`) REFERENCES `program` (`program_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
