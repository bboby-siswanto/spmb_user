-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 08:25 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmb_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `dikti_wilayah`
--

CREATE TABLE `dikti_wilayah` (
  `id_wilayah` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id_negara` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `nama_wilayah` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dikti_wilayah_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_academic_history`
--

CREATE TABLE `dt_academic_history` (
  `academic_history_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `institution_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `occupation_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_history_graduation_year` int(4) DEFAULT NULL,
  `academic_history_major` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_history_gpa` decimal(4,2) DEFAULT NULL,
  `academic_year_start_date` date DEFAULT NULL,
  `academic_year_end_date` date DEFAULT NULL,
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dt_academic_history`
--

INSERT INTO `dt_academic_history` (`academic_history_id`, `institution_id`, `personal_data_id`, `occupation_id`, `academic_history_graduation_year`, `academic_history_major`, `academic_history_gpa`, `academic_year_start_date`, `academic_year_end_date`, `portal_sync`, `date_added`, `timestamp`) VALUES
('23524ee8-1a0c-48d2-abd1-e7ec23a0994f', 'f167e1ab-d157-4ea1-a902-992b754a05f5', 'e72d599b-64a7-43f2-8ae4-b6fb26ba5e0e', NULL, NULL, NULL, NULL, NULL, NULL, '1', '2024-10-01 09:44:47', '2024-10-01 07:44:47'),
('2c924dff-26c6-4e7e-9ffe-d1cd24f0b65a', '43f24432-d2cf-4d95-b101-b52188018462', '0dffb294-0ff2-493d-8003-afdd2820f111', NULL, 2023, 'IPA', NULL, NULL, NULL, '1', '2024-10-01 10:00:48', '2024-10-01 08:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `dt_academic_year`
--

CREATE TABLE `dt_academic_year` (
  `academic_year_id` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `academic_year_intake_status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `academic_year_candidates_counter` int(11) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dt_academic_year`
--

INSERT INTO `dt_academic_year` (`academic_year_id`, `academic_year_intake_status`, `academic_year_candidates_counter`, `date_added`, `timestamp`) VALUES
('2025', 'active', 4, '2024-09-30 19:41:57', '2024-10-01 07:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log`
--

CREATE TABLE `dt_access_log` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202112`
--

CREATE TABLE `dt_access_log_202112` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202201`
--

CREATE TABLE `dt_access_log_202201` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202202`
--

CREATE TABLE `dt_access_log_202202` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202203`
--

CREATE TABLE `dt_access_log_202203` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202204`
--

CREATE TABLE `dt_access_log_202204` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202205`
--

CREATE TABLE `dt_access_log_202205` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202206`
--

CREATE TABLE `dt_access_log_202206` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202207`
--

CREATE TABLE `dt_access_log_202207` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202208`
--

CREATE TABLE `dt_access_log_202208` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202209`
--

CREATE TABLE `dt_access_log_202209` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202210`
--

CREATE TABLE `dt_access_log_202210` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202211`
--

CREATE TABLE `dt_access_log_202211` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_access_log_202212`
--

CREATE TABLE `dt_access_log_202212` (
  `access_log_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_source_ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_referrer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_session_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_module` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_uri_string` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_log_post_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_php_raw_input` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_get_data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_log_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_address`
--

CREATE TABLE `dt_address` (
  `address_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dikti_wilayah_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_rt` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_rw` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_province` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_city` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_zipcode` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_street` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_district` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_sub_district` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_phonenumber` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_cellular` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dt_address`
--

INSERT INTO `dt_address` (`address_id`, `dikti_wilayah_id`, `country_id`, `address_rt`, `address_rw`, `address_province`, `address_city`, `address_zipcode`, `address_street`, `address_district`, `address_sub_district`, `address_phonenumber`, `address_cellular`, `portal_sync`, `date_added`, `timestamp`) VALUES
('6282d499-e7f6-4e50-ae96-dfa26cf06b44', NULL, '9bb722f5-8b22-11e9-973e-52540001273f', NULL, NULL, NULL, 'TANGERANG', NULL, NULL, NULL, NULL, NULL, NULL, '1', '2024-10-01 10:05:22', '2024-10-01 08:05:22'),
('89109332-9b66-4163-ba63-676c2883cb67', NULL, '9bb722f5-8b22-11e9-973e-52540001273f', NULL, NULL, 'BANTEN', 'TANGERANG', '', '', NULL, NULL, NULL, NULL, '1', '0000-00-00 00:00:00', '2024-10-01 08:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `dt_api`
--

CREATE TABLE `dt_api` (
  `api_access_token` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_mode` enum('live','sandbox') COLLATE utf8_unicode_ci DEFAULT 'live',
  `api_secret_token` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_whitelist_ip` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_candidate_answer`
--

CREATE TABLE `dt_candidate_answer` (
  `exam_candidate_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `exam_question_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `question_option_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_event`
--

CREATE TABLE `dt_event` (
  `event_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `event_slug` varchar(50) NOT NULL,
  `event_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `event_venue` text DEFAULT NULL,
  `event_run_down` text DEFAULT NULL,
  `event_start_date` datetime NOT NULL,
  `event_end_date` datetime NOT NULL,
  `event_is_public` tinyint(1) NOT NULL DEFAULT 1,
  `event_type` enum('pmb','general') NOT NULL DEFAULT 'pmb',
  `event_has_bookings` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_event_bookings`
--

CREATE TABLE `dt_event_bookings` (
  `booking_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `event_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `booking_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `booking_photo` mediumtext DEFAULT NULL,
  `booking_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `booking_phone` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `booking_seat` tinyint(4) NOT NULL,
  `booking_participation` enum('pending','present') NOT NULL DEFAULT 'pending',
  `booking_origin` varchar(200) DEFAULT NULL,
  `booking_reference` text DEFAULT NULL,
  `booking_grade` enum('x','xi','xii','graduated') DEFAULT NULL,
  `booking_gradute_year` year(4) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_exam_candidate`
--

CREATE TABLE `dt_exam_candidate` (
  `exam_candidate_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `exam_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `total_time` time DEFAULT NULL,
  `correct_answer` tinyint(3) DEFAULT NULL,
  `wrong_answer` tinyint(3) DEFAULT NULL,
  `total_question` tinyint(3) DEFAULT NULL,
  `filled_question` tinyint(3) DEFAULT NULL,
  `token` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `candidate_exam_status` enum('FINISH','CANCEL','PENDING','PROGRESS') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PENDING',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_exam_period`
--

CREATE TABLE `dt_exam_period` (
  `exam_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `exam_period_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exam_start_time` datetime NOT NULL,
  `exam_end_time` datetime NOT NULL,
  `exam_listening_file` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exam_random_question` enum('TRUE','FALSE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FALSE',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_exam_question`
--

CREATE TABLE `dt_exam_question` (
  `exam_question_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `exam_question_number` int(11) NOT NULL,
  `exam_question_section` tinyint(2) DEFAULT NULL,
  `exam_question_type` enum('LISTENING','NONLISTENING') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NONLISTENING',
  `exam_question_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `exam_question_file` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exam_question_status` enum('ACTIVE','INACTIVE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_exam_question_option`
--

CREATE TABLE `dt_exam_question_option` (
  `question_option_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `exam_question_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `exam_question_option_number` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `question_option_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `option_this_answer` enum('TRUE','FALSE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FALSE',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_family`
--

CREATE TABLE `dt_family` (
  `family_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dt_family`
--

INSERT INTO `dt_family` (`family_id`, `portal_sync`, `date_added`, `timestamp`) VALUES
('0d734c3a-d8bf-463f-b072-6df44d98aa3f', '1', '2024-10-01 09:43:22', '2024-10-01 07:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `dt_family_member`
--

CREATE TABLE `dt_family_member` (
  `family_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `family_member_status` enum('father','mother','guardian','child') COLLATE utf8_unicode_ci NOT NULL,
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dt_family_member`
--

INSERT INTO `dt_family_member` (`family_id`, `personal_data_id`, `family_member_status`, `portal_sync`, `date_added`, `timestamp`) VALUES
('0d734c3a-d8bf-463f-b072-6df44d98aa3f', '0dffb294-0ff2-493d-8003-afdd2820f111', 'child', '1', '0000-00-00 00:00:00', '2024-10-01 07:43:22'),
('0d734c3a-d8bf-463f-b072-6df44d98aa3f', 'e72d599b-64a7-43f2-8ae4-b6fb26ba5e0e', 'father', '1', '2024-10-01 09:44:47', '2024-10-01 07:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `dt_institution_contact`
--

CREATE TABLE `dt_institution_contact` (
  `institution_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `personal_data_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_personal_address`
--

CREATE TABLE `dt_personal_address` (
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `personal_address_type` enum('primary','alternative') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'primary',
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dt_personal_address`
--

INSERT INTO `dt_personal_address` (`personal_data_id`, `address_id`, `personal_address_type`, `portal_sync`, `date_added`, `timestamp`) VALUES
('0dffb294-0ff2-493d-8003-afdd2820f111', '6282d499-e7f6-4e50-ae96-dfa26cf06b44', 'primary', '1', '2024-10-01 00:00:00', '2024-10-01 08:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `dt_personal_data`
--

CREATE TABLE `dt_personal_data` (
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country_of_birth` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'country_id',
  `citizenship_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'country_id',
  `religion_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ocupation_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_title_prefix` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `personal_data_title_suffix` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `personal_data_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_cellular` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_id_card_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_id_card_type` enum('national_id','driver_license','passport') COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_place_of_birth` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_date_of_birth` date DEFAULT NULL,
  `personal_data_gender` enum('M','F') COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_nationality` enum('WNI','WNA') COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_marital_status` enum('single','married') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'single',
  `personal_data_mother_maiden_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_password_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_password_token_expired` datetime DEFAULT NULL,
  `personal_data_email_confirmation` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `personal_data_email_confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_data_reference_code` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_completed_personal_data` tinyint(4) DEFAULT NULL,
  `has_completed_parents_data` tinyint(4) DEFAULT NULL,
  `has_completed_school_data` tinyint(4) DEFAULT NULL,
  `has_completed_employment_data` tinyint(4) DEFAULT NULL,
  `portal_status` enum('open','blocked') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dt_personal_data`
--

INSERT INTO `dt_personal_data` (`personal_data_id`, `country_of_birth`, `citizenship_id`, `religion_id`, `ocupation_id`, `personal_data_title_prefix`, `personal_data_name`, `personal_data_title_suffix`, `personal_data_email`, `personal_data_phone`, `personal_data_cellular`, `personal_data_id_card_number`, `personal_data_id_card_type`, `personal_data_place_of_birth`, `personal_data_date_of_birth`, `personal_data_gender`, `personal_data_nationality`, `personal_data_marital_status`, `personal_data_mother_maiden_name`, `personal_data_password`, `personal_data_password_token`, `personal_data_password_token_expired`, `personal_data_email_confirmation`, `personal_data_email_confirmation_token`, `personal_data_reference_code`, `has_completed_personal_data`, `has_completed_parents_data`, `has_completed_school_data`, `has_completed_employment_data`, `portal_status`, `portal_sync`, `date_added`, `timestamp`) VALUES
('0dffb294-0ff2-493d-8003-afdd2820f111', '9bb722f5-8b22-11e9-973e-52540001273f', '9bb722f5-8b22-11e9-973e-52540001273f', '53b17ff0-e4c0-4fc9-8735-bbb8c7054048', NULL, NULL, 'BUDI SISWANTO', NULL, 'budi.siswanto1450@gmail.com', NULL, '0192801729', '1234567890123456', NULL, 'TANGERANG', '1997-03-09', 'M', 'WNI', 'single', 'IBU KANDUNG', '$2y$10$qF65XSoo6E/oU4sFtEyPBeax7URNdyUhNsYt7hMR0/OaVz6mILGR.', NULL, NULL, 'no', '507546675a1f539a6b19ffca120a1a17', NULL, 0, 0, 0, NULL, 'open', '1', '2024-10-01 09:43:22', '2024-10-01 08:05:22'),
('e72d599b-64a7-43f2-8ae4-b6fb26ba5e0e', NULL, NULL, NULL, 'f098fae0-d1e0-4961-8805-c2255e2d8e56', NULL, 'NAMA AYAH', NULL, 'ortu@gmail.com', NULL, '91028091', NULL, NULL, NULL, NULL, NULL, NULL, 'single', NULL, NULL, NULL, NULL, 'no', NULL, NULL, NULL, NULL, NULL, NULL, 'open', '1', '2024-10-01 09:44:47', '2024-10-01 07:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `dt_personal_data_document`
--

CREATE TABLE `dt_personal_data_document` (
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `document_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `document_requirement_link` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `document_mime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_questionnaire_answers`
--

CREATE TABLE `dt_questionnaire_answers` (
  `question_answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_section_id` int(11) NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `answer_value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_question_section_group`
--

CREATE TABLE `dt_question_section_group` (
  `question_section_group_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_section_id` int(11) NOT NULL,
  `question_section_number_order` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_reference`
--

CREATE TABLE `dt_reference` (
  `referrer_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'personal_data_id',
  `referenced_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'personal_data_id',
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dt_registration_scholarship`
--

CREATE TABLE `dt_registration_scholarship` (
  `registration_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `personal_data_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `scholarship_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `academic_year_id` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_student`
--

CREATE TABLE `dt_student` (
  `student_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `personal_data_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `program_id` int(11) DEFAULT 1,
  `study_program_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_program_id_alt_1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_program_id_alt_2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_year_id` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `finance_year_id` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `student_registration_scholarship_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_nisn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_date_enrollment` datetime DEFAULT NULL,
  `student_type` enum('regular','transfer','exchange') COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_class_type` enum('karyawan','regular','course') COLLATE utf8_unicode_ci DEFAULT 'regular',
  `student_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_alumni_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `graduated_year_id` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_date_graduated` date DEFAULT NULL,
  `student_ipk` decimal(4,2) DEFAULT NULL,
  `student_un_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `student_status` enum('register','candidate','pending','active','inactive','dropout','resign') COLLATE utf8_unicode_ci DEFAULT 'register',
  `has_to_pay_enrollment_fee` enum('no','yes') COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_portal_blocked` enum('TRUE','FALSE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FALSE',
  `student_send_transcript` enum('TRUE','FALSE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TRUE',
  `student_ofse_eligibility` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dt_student`
--

INSERT INTO `dt_student` (`student_id`, `personal_data_id`, `program_id`, `study_program_id`, `study_program_id_alt_1`, `study_program_id_alt_2`, `academic_year_id`, `finance_year_id`, `student_registration_scholarship_id`, `student_number`, `student_nisn`, `student_date_enrollment`, `student_type`, `student_class_type`, `student_email`, `student_alumni_email`, `graduated_year_id`, `student_date_graduated`, `student_ipk`, `student_un_status`, `student_status`, `has_to_pay_enrollment_fee`, `student_portal_blocked`, `student_send_transcript`, `student_ofse_eligibility`, `portal_sync`, `date_added`, `timestamp`) VALUES
('05440ae2-01d6-4c2f-9010-126debb49895', '0dffb294-0ff2-493d-8003-afdd2820f111', 1, '51ce53bf-7fc2-11ef-87c0-0068eb6957a0', '51ce2d58-7fc2-11ef-87c0-0068eb6957a0', NULL, '2025', '2025', NULL, NULL, '1234545', '2024-10-01 09:43:22', 'regular', 'regular', NULL, NULL, NULL, NULL, NULL, '', 'candidate', NULL, 'FALSE', 'TRUE', 'no', '1', '2024-10-01 09:43:22', '2024-10-01 08:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `dt_testimonial`
--

CREATE TABLE `dt_testimonial` (
  `testimonial_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `testimoni` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_country`
--

CREATE TABLE `ref_country` (
  `country_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ref_country`
--

INSERT INTO `ref_country` (`country_id`, `country_code`, `country_name`, `date_added`, `timestamp`) VALUES
('9bb7205c-8b22-11e9-973e-52540001273f', 'AF', 'Afghanistan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb721d3-8b22-11e9-973e-52540001273f', 'AR', 'Argentina', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72248-8b22-11e9-973e-52540001273f', 'IS', 'Iceland', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7229f-8b22-11e9-973e-52540001273f', 'IN', 'India', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb722f5-8b22-11e9-973e-52540001273f', 'ID', 'Indonesia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72345-8b22-11e9-973e-52540001273f', 'IR', 'Iran', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72398-8b22-11e9-973e-52540001273f', 'IQ', 'Iraq', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb723ea-8b22-11e9-973e-52540001273f', 'IE', 'Ireland', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72438-8b22-11e9-973e-52540001273f', 'IL', 'Israel', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7248b-8b22-11e9-973e-52540001273f', 'IT', 'Italy', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb724dc-8b22-11e9-973e-52540001273f', 'JM', 'Jamaica', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7252d-8b22-11e9-973e-52540001273f', 'JP', 'Japan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7257a-8b22-11e9-973e-52540001273f', 'AM', 'Armenia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb725cc-8b22-11e9-973e-52540001273f', 'XJ', 'Jersey', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7261c-8b22-11e9-973e-52540001273f', 'JO', 'Jordan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7266d-8b22-11e9-973e-52540001273f', 'KZ', 'Kazakhstan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb726bd-8b22-11e9-973e-52540001273f', 'KE', 'Kenya', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7270d-8b22-11e9-973e-52540001273f', 'KI', 'Kiribati', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7275e-8b22-11e9-973e-52540001273f', 'KP', 'Korea North', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb727b0-8b22-11e9-973e-52540001273f', 'KR', 'Korea South', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7284e-8b22-11e9-973e-52540001273f', 'KW', 'Kuwait', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb728a4-8b22-11e9-973e-52540001273f', 'KG', 'Kyrgyzstan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb728f6-8b22-11e9-973e-52540001273f', 'LA', 'Laos', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72946-8b22-11e9-973e-52540001273f', 'AW', 'Aruba', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72993-8b22-11e9-973e-52540001273f', 'LV', 'Latvia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb729e2-8b22-11e9-973e-52540001273f', 'LB', 'Lebanon', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72a35-8b22-11e9-973e-52540001273f', 'LS', 'Lesotho', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72a86-8b22-11e9-973e-52540001273f', 'LR', 'Liberia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72ad5-8b22-11e9-973e-52540001273f', 'LY', 'Libya', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72b23-8b22-11e9-973e-52540001273f', 'LI', 'Liechtenstein', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72b78-8b22-11e9-973e-52540001273f', 'LT', 'Lithuania', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72bc9-8b22-11e9-973e-52540001273f', 'LU', 'Luxembourg', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72d9c-8b22-11e9-973e-52540001273f', 'MO', 'Macau S.A.R.', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72df4-8b22-11e9-973e-52540001273f', 'MK', 'Macedonia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72e47-8b22-11e9-973e-52540001273f', 'AU', 'Australia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72e98-8b22-11e9-973e-52540001273f', 'MG', 'Madagascar', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72ee6-8b22-11e9-973e-52540001273f', 'MW', 'Malawi', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72f36-8b22-11e9-973e-52540001273f', 'MY', 'Malaysia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72f87-8b22-11e9-973e-52540001273f', 'MV', 'Maldives', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb72fd8-8b22-11e9-973e-52540001273f', 'ML', 'Mali', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73026-8b22-11e9-973e-52540001273f', 'MT', 'Malta', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73075-8b22-11e9-973e-52540001273f', 'XM', 'Man (Isle of)', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb730c7-8b22-11e9-973e-52540001273f', 'MH', 'Marshall Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb735bd-8b22-11e9-973e-52540001273f', 'MQ', 'Martinique', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7363e-8b22-11e9-973e-52540001273f', 'MR', 'Mauritania', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb736a2-8b22-11e9-973e-52540001273f', 'AT', 'Austria', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73707-8b22-11e9-973e-52540001273f', 'MU', 'Mauritius', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73768-8b22-11e9-973e-52540001273f', 'YT', 'Mayotte', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb737b9-8b22-11e9-973e-52540001273f', 'MX', 'Mexico', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7380b-8b22-11e9-973e-52540001273f', 'FM', 'Micronesia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7385f-8b22-11e9-973e-52540001273f', 'MD', 'Moldova', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb738b2-8b22-11e9-973e-52540001273f', 'MC', 'Monaco', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73902-8b22-11e9-973e-52540001273f', 'MN', 'Mongolia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73953-8b22-11e9-973e-52540001273f', 'MS', 'Montserrat', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb739a8-8b22-11e9-973e-52540001273f', 'MA', 'Morocco', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb739fb-8b22-11e9-973e-52540001273f', 'MZ', 'Mozambique', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73a4d-8b22-11e9-973e-52540001273f', 'AZ', 'Azerbaijan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73a9f-8b22-11e9-973e-52540001273f', 'MM', 'Myanmar', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73af2-8b22-11e9-973e-52540001273f', 'NA', 'Namibia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73b44-8b22-11e9-973e-52540001273f', 'NR', 'Nauru', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73b96-8b22-11e9-973e-52540001273f', 'NP', 'Nepal', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73be7-8b22-11e9-973e-52540001273f', 'AN', 'Netherlands Antilles', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73c3d-8b22-11e9-973e-52540001273f', 'NL', 'Netherlands The', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73c90-8b22-11e9-973e-52540001273f', 'NC', 'New Caledonia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73ce3-8b22-11e9-973e-52540001273f', 'NZ', 'New Zealand', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb73d38-8b22-11e9-973e-52540001273f', 'NI', 'Nicaragua', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7404d-8b22-11e9-973e-52540001273f', 'NE', 'Niger', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb740a4-8b22-11e9-973e-52540001273f', 'BS', 'Bahamas The', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb740f6-8b22-11e9-973e-52540001273f', 'NG', 'Nigeria', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7414a-8b22-11e9-973e-52540001273f', 'NU', 'Niue', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb741f0-8b22-11e9-973e-52540001273f', 'NF', 'Norfolk Island', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74258-8b22-11e9-973e-52540001273f', 'MP', 'Northern Mariana Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb742ac-8b22-11e9-973e-52540001273f', 'NO', 'Norway', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74300-8b22-11e9-973e-52540001273f', 'OM', 'Oman', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74352-8b22-11e9-973e-52540001273f', 'PK', 'Pakistan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb743a4-8b22-11e9-973e-52540001273f', 'PW', 'Palau', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb743f4-8b22-11e9-973e-52540001273f', 'PS', 'Palestinian Territory Occupied', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74449-8b22-11e9-973e-52540001273f', 'PA', 'Panama', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7449b-8b22-11e9-973e-52540001273f', 'BH', 'Bahrain', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb744ee-8b22-11e9-973e-52540001273f', 'PG', 'Papua new Guinea', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7453e-8b22-11e9-973e-52540001273f', 'PY', 'Paraguay', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74590-8b22-11e9-973e-52540001273f', 'PE', 'Peru', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb745e4-8b22-11e9-973e-52540001273f', 'PH', 'Philippines', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74638-8b22-11e9-973e-52540001273f', 'PN', 'Pitcairn Island', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7468a-8b22-11e9-973e-52540001273f', 'PL', 'Poland', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb746da-8b22-11e9-973e-52540001273f', 'PT', 'Portugal', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7472d-8b22-11e9-973e-52540001273f', 'PR', 'Puerto Rico', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7477f-8b22-11e9-973e-52540001273f', 'QA', 'Qatar', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb747ce-8b22-11e9-973e-52540001273f', 'RE', 'Reunion', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74820-8b22-11e9-973e-52540001273f', 'BD', 'Bangladesh', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74875-8b22-11e9-973e-52540001273f', 'RO', 'Romania', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb748c7-8b22-11e9-973e-52540001273f', 'RU', 'Russia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74917-8b22-11e9-973e-52540001273f', 'RW', 'Rwanda', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74968-8b22-11e9-973e-52540001273f', 'SH', 'Saint Helena', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb749be-8b22-11e9-973e-52540001273f', 'KN', 'Saint Kitts And Nevis', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74a12-8b22-11e9-973e-52540001273f', 'LC', 'Saint Lucia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74a62-8b22-11e9-973e-52540001273f', 'PM', 'Saint Pierre and Miquelon', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74ab7-8b22-11e9-973e-52540001273f', 'VC', 'Saint Vincent And The Grenadines', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74b0b-8b22-11e9-973e-52540001273f', 'WS', 'Samoa', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74b5d-8b22-11e9-973e-52540001273f', 'SM', 'San Marino', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74baf-8b22-11e9-973e-52540001273f', 'BB', 'Barbados', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74c03-8b22-11e9-973e-52540001273f', 'ST', 'Sao Tome and Principe', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74c58-8b22-11e9-973e-52540001273f', 'SA', 'Saudi Arabia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb74cae-8b22-11e9-973e-52540001273f', 'SN', 'Senegal', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb750cc-8b22-11e9-973e-52540001273f', 'RS', 'Serbia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb75128-8b22-11e9-973e-52540001273f', 'SC', 'Seychelles', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7517d-8b22-11e9-973e-52540001273f', 'SL', 'Sierra Leone', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb751d2-8b22-11e9-973e-52540001273f', 'SG', 'Singapore', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb75224-8b22-11e9-973e-52540001273f', 'SK', 'Slovakia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb75275-8b22-11e9-973e-52540001273f', 'SI', 'Slovenia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb752c6-8b22-11e9-973e-52540001273f', 'XG', 'Smaller Territories of the UK', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7531b-8b22-11e9-973e-52540001273f', 'AL', 'Albania', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7536b-8b22-11e9-973e-52540001273f', 'BY', 'Belarus', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb753bd-8b22-11e9-973e-52540001273f', 'SB', 'Solomon Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb75413-8b22-11e9-973e-52540001273f', 'SO', 'Somalia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb75465-8b22-11e9-973e-52540001273f', 'ZA', 'South Africa', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb754b7-8b22-11e9-973e-52540001273f', 'GS', 'South Georgia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb75508-8b22-11e9-973e-52540001273f', 'SS', 'South Sudan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7555b-8b22-11e9-973e-52540001273f', 'ES', 'Spain', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb755ad-8b22-11e9-973e-52540001273f', 'LK', 'Sri Lanka', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb755ff-8b22-11e9-973e-52540001273f', 'SD', 'Sudan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7564f-8b22-11e9-973e-52540001273f', 'SR', 'Suriname', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb756a3-8b22-11e9-973e-52540001273f', 'SJ', 'Svalbard And Jan Mayen Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb756f8-8b22-11e9-973e-52540001273f', 'BE', 'Belgium', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7574a-8b22-11e9-973e-52540001273f', 'SZ', 'Swaziland', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb7579c-8b22-11e9-973e-52540001273f', 'SE', 'Sweden', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bb757ef-8b22-11e9-973e-52540001273f', 'CH', 'Switzerland', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc621e3-8b22-11e9-973e-52540001273f', 'SY', 'Syria', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc622f5-8b22-11e9-973e-52540001273f', 'TW', 'Taiwan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62357-8b22-11e9-973e-52540001273f', 'TJ', 'Tajikistan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc623b3-8b22-11e9-973e-52540001273f', 'TZ', 'Tanzania', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6240e-8b22-11e9-973e-52540001273f', 'TH', 'Thailand', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62465-8b22-11e9-973e-52540001273f', 'TG', 'Togo', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc624b8-8b22-11e9-973e-52540001273f', 'TK', 'Tokelau', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62512-8b22-11e9-973e-52540001273f', 'BZ', 'Belize', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62568-8b22-11e9-973e-52540001273f', 'TO', 'Tonga', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc625bb-8b22-11e9-973e-52540001273f', 'TT', 'Trinidad And Tobago', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62610-8b22-11e9-973e-52540001273f', 'TN', 'Tunisia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62665-8b22-11e9-973e-52540001273f', 'TR', 'Turkey', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc626ba-8b22-11e9-973e-52540001273f', 'TM', 'Turkmenistan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6270f-8b22-11e9-973e-52540001273f', 'TC', 'Turks And Caicos Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62766-8b22-11e9-973e-52540001273f', 'TV', 'Tuvalu', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc627bc-8b22-11e9-973e-52540001273f', 'UG', 'Uganda', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62811-8b22-11e9-973e-52540001273f', 'UA', 'Ukraine', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6286a-8b22-11e9-973e-52540001273f', 'AE', 'United Arab Emirates', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc628c5-8b22-11e9-973e-52540001273f', 'BJ', 'Benin', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62ce1-8b22-11e9-973e-52540001273f', 'GB', 'United Kingdom', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62d3e-8b22-11e9-973e-52540001273f', 'US', 'United States', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62d92-8b22-11e9-973e-52540001273f', 'UM', 'United States Minor Outlying Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62de8-8b22-11e9-973e-52540001273f', 'UY', 'Uruguay', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62e3d-8b22-11e9-973e-52540001273f', 'UZ', 'Uzbekistan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62e93-8b22-11e9-973e-52540001273f', 'VU', 'Vanuatu', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62ee3-8b22-11e9-973e-52540001273f', 'VA', 'Vatican City State (Holy See)', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62f39-8b22-11e9-973e-52540001273f', 'VE', 'Venezuela', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62f8f-8b22-11e9-973e-52540001273f', 'VN', 'Vietnam', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc62fe4-8b22-11e9-973e-52540001273f', 'VG', 'Virgin Islands (British)', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63037-8b22-11e9-973e-52540001273f', 'BM', 'Bermuda', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6308b-8b22-11e9-973e-52540001273f', 'VI', 'Virgin Islands (US)', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc630e1-8b22-11e9-973e-52540001273f', 'WF', 'Wallis And Futuna Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63138-8b22-11e9-973e-52540001273f', 'EH', 'Western Sahara', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6318b-8b22-11e9-973e-52540001273f', 'YE', 'Yemen', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc631dd-8b22-11e9-973e-52540001273f', 'YU', 'Yugoslavia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63234-8b22-11e9-973e-52540001273f', 'ZM', 'Zambia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63288-8b22-11e9-973e-52540001273f', 'ZW', 'Zimbabwe', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc632db-8b22-11e9-973e-52540001273f', 'BT', 'Bhutan', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6332d-8b22-11e9-973e-52540001273f', 'BO', 'Bolivia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63382-8b22-11e9-973e-52540001273f', 'BA', 'Bosnia and Herzegovina', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc633d7-8b22-11e9-973e-52540001273f', 'BW', 'Botswana', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63429-8b22-11e9-973e-52540001273f', 'BV', 'Bouvet Island', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6347a-8b22-11e9-973e-52540001273f', 'DZ', 'Algeria', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc634ce-8b22-11e9-973e-52540001273f', 'BR', 'Brazil', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63520-8b22-11e9-973e-52540001273f', 'IO', 'British Indian Ocean Territory', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63572-8b22-11e9-973e-52540001273f', 'BN', 'Brunei', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63642-8b22-11e9-973e-52540001273f', 'BG', 'Bulgaria', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc636aa-8b22-11e9-973e-52540001273f', 'BF', 'Burkina Faso', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc636ff-8b22-11e9-973e-52540001273f', 'BI', 'Burundi', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63751-8b22-11e9-973e-52540001273f', 'KH', 'Cambodia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc637a3-8b22-11e9-973e-52540001273f', 'CM', 'Cameroon', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc637f7-8b22-11e9-973e-52540001273f', 'CA', 'Canada', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6384d-8b22-11e9-973e-52540001273f', 'CV', 'Cape Verde', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6389d-8b22-11e9-973e-52540001273f', 'AS', 'American Samoa', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc638f3-8b22-11e9-973e-52540001273f', 'KY', 'Cayman Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63947-8b22-11e9-973e-52540001273f', 'CF', 'Central African Republic', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6399e-8b22-11e9-973e-52540001273f', 'TD', 'Chad', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc639ef-8b22-11e9-973e-52540001273f', 'CL', 'Chile', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63a41-8b22-11e9-973e-52540001273f', 'CN', 'China', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63a93-8b22-11e9-973e-52540001273f', 'CX', 'Christmas Island', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63ae7-8b22-11e9-973e-52540001273f', 'CC', 'Cocos (Keeling) Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63b39-8b22-11e9-973e-52540001273f', 'CO', 'Colombia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63b8b-8b22-11e9-973e-52540001273f', 'KM', 'Comoros', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63bdf-8b22-11e9-973e-52540001273f', 'CG', 'Congo', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc63c35-8b22-11e9-973e-52540001273f', 'AD', 'Andorra', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6403d-8b22-11e9-973e-52540001273f', 'CD', 'Congo The Democratic Republic Of The', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64095-8b22-11e9-973e-52540001273f', 'CK', 'Cook Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc640eb-8b22-11e9-973e-52540001273f', 'CR', 'Costa Rica', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64140-8b22-11e9-973e-52540001273f', 'CI', 'Cote D\'Ivoire (Ivory Coast)', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64194-8b22-11e9-973e-52540001273f', 'HR', 'Croatia (Hrvatska)', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc641ea-8b22-11e9-973e-52540001273f', 'CU', 'Cuba', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64240-8b22-11e9-973e-52540001273f', 'CY', 'Cyprus', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64293-8b22-11e9-973e-52540001273f', 'CZ', 'Czech Republic', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc642e4-8b22-11e9-973e-52540001273f', 'DK', 'Denmark', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6437f-8b22-11e9-973e-52540001273f', 'DJ', 'Djibouti', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc643da-8b22-11e9-973e-52540001273f', 'AO', 'Angola', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6442d-8b22-11e9-973e-52540001273f', 'DM', 'Dominica', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6447f-8b22-11e9-973e-52540001273f', 'DO', 'Dominican Republic', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc644d4-8b22-11e9-973e-52540001273f', 'TP', 'East Timor', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64529-8b22-11e9-973e-52540001273f', 'EC', 'Ecuador', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6457d-8b22-11e9-973e-52540001273f', 'EG', 'Egypt', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc645ce-8b22-11e9-973e-52540001273f', 'SV', 'El Salvador', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64621-8b22-11e9-973e-52540001273f', 'GQ', 'Equatorial Guinea', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64675-8b22-11e9-973e-52540001273f', 'ER', 'Eritrea', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc646c9-8b22-11e9-973e-52540001273f', 'EE', 'Estonia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6471a-8b22-11e9-973e-52540001273f', 'ET', 'Ethiopia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6476c-8b22-11e9-973e-52540001273f', 'AI', 'Anguilla', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc647bf-8b22-11e9-973e-52540001273f', 'XA', 'External Territories of Australia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64815-8b22-11e9-973e-52540001273f', 'FK', 'Falkland Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64866-8b22-11e9-973e-52540001273f', 'FO', 'Faroe Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc648b9-8b22-11e9-973e-52540001273f', 'FJ', 'Fiji Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6490d-8b22-11e9-973e-52540001273f', 'FI', 'Finland', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64960-8b22-11e9-973e-52540001273f', 'FR', 'France', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc649b1-8b22-11e9-973e-52540001273f', 'GF', 'French Guiana', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64a03-8b22-11e9-973e-52540001273f', 'PF', 'French Polynesia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64a57-8b22-11e9-973e-52540001273f', 'TF', 'French Southern Territories', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64aab-8b22-11e9-973e-52540001273f', 'GA', 'Gabon', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64afc-8b22-11e9-973e-52540001273f', 'AQ', 'Antarctica', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64b50-8b22-11e9-973e-52540001273f', 'GM', 'Gambia The', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64ba4-8b22-11e9-973e-52540001273f', 'GE', 'Georgia', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64bf8-8b22-11e9-973e-52540001273f', 'DE', 'Germany', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64c49-8b22-11e9-973e-52540001273f', 'GH', 'Ghana', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64c9a-8b22-11e9-973e-52540001273f', 'GI', 'Gibraltar', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64cee-8b22-11e9-973e-52540001273f', 'GR', 'Greece', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64d42-8b22-11e9-973e-52540001273f', 'GL', 'Greenland', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64d93-8b22-11e9-973e-52540001273f', 'GD', 'Grenada', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64de4-8b22-11e9-973e-52540001273f', 'GP', 'Guadeloupe', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64e38-8b22-11e9-973e-52540001273f', 'GU', 'Guam', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc64e8c-8b22-11e9-973e-52540001273f', 'AG', 'Antigua And Barbuda', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6531a-8b22-11e9-973e-52540001273f', 'GT', 'Guatemala', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc65372-8b22-11e9-973e-52540001273f', 'XU', 'Guernsey and Alderney', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc653c6-8b22-11e9-973e-52540001273f', 'GN', 'Guinea', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6541a-8b22-11e9-973e-52540001273f', 'GW', 'Guinea-Bissau', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6546a-8b22-11e9-973e-52540001273f', 'GY', 'Guyana', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc654bd-8b22-11e9-973e-52540001273f', 'HT', 'Haiti', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc65511-8b22-11e9-973e-52540001273f', 'HM', 'Heard and McDonald Islands', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc65567-8b22-11e9-973e-52540001273f', 'HN', 'Honduras', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc655b8-8b22-11e9-973e-52540001273f', 'HK', 'Hong Kong S.A.R.', '2019-06-10 08:52:19', '2019-06-10 01:53:56'),
('9bc6560b-8b22-11e9-973e-52540001273f', 'HU', 'Hungary', '2019-06-10 08:52:19', '2019-06-10 01:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `ref_document`
--

CREATE TABLE `ref_document` (
  `document_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `document_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `document_weight` int(11) NOT NULL DEFAULT 999,
  `document_general` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'yes',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_document_type`
--

CREATE TABLE `ref_document_type` (
  `document_type_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `document_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `document_type_name` enum('general','un','non_un','transfer_student','international_school') COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_faculty`
--

CREATE TABLE `ref_faculty` (
  `faculty_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `faculty_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `faculty_abbreviation` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ref_faculty`
--

INSERT INTO `ref_faculty` (`faculty_id`, `faculty_name`, `faculty_abbreviation`, `date_added`, `timestamp`) VALUES
('2de874e6-7fbf-11ef-87c0-0068eb6957a0', 'Faculty of Economics and Business', 'FEB', '2024-10-01 13:34:15', '2024-10-01 06:34:15'),
('4a3a699e-7fbf-11ef-87c0-0068eb6957a0', 'Faculty of Computer Science', 'FIK', '2024-10-01 08:34:24', '2024-10-01 06:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `ref_institution`
--

CREATE TABLE `ref_institution` (
  `institution_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `institution_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution_phone_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution_type` enum('highschool','university','office') COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution_is_international` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT NULL,
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ref_institution`
--

INSERT INTO `ref_institution` (`institution_id`, `address_id`, `institution_name`, `institution_email`, `institution_phone_number`, `institution_type`, `institution_is_international`, `portal_sync`, `date_added`, `timestamp`) VALUES
('43f24432-d2cf-4d95-b101-b52188018462', '89109332-9b66-4163-ba63-676c2883cb67', 'SEKOLAH MENENGAH ATAS', '', '', 'highschool', NULL, '1', '2024-10-01 10:00:48', '2024-10-01 08:00:48'),
('f167e1ab-d157-4ea1-a902-992b754a05f5', NULL, 'PT SEMOGA BERKAH', NULL, NULL, NULL, NULL, '1', '2024-10-01 09:44:47', '2024-10-01 07:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `ref_ocupation`
--

CREATE TABLE `ref_ocupation` (
  `ocupation_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ocupation_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `portal_sync` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=sudah sync',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ref_ocupation`
--

INSERT INTO `ref_ocupation` (`ocupation_id`, `ocupation_name`, `portal_sync`, `date_added`, `timestamp`) VALUES
('f098fae0-d1e0-4961-8805-c2255e2d8e56', 'STAFF', '1', '2024-10-01 09:44:47', '2024-10-01 07:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `ref_program`
--

CREATE TABLE `ref_program` (
  `program_id` int(11) NOT NULL,
  `program_code` char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `program_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `program_level` enum('undergraduate','graduate','post-graduate','non-graduate') NOT NULL DEFAULT 'undergraduate',
  `program_main_id` int(11) DEFAULT NULL,
  `type_of_admission_code` varchar(5) DEFAULT NULL,
  `type_of_admission_name` varchar(50) DEFAULT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_program`
--

INSERT INTO `ref_program` (`program_id`, `program_code`, `program_name`, `program_level`, `program_main_id`, `type_of_admission_code`, `type_of_admission_name`, `is_active`, `date_added`, `timestamp`) VALUES
(1, 'S1', 'Sarjana', 'undergraduate', NULL, NULL, NULL, 'yes', '2024-10-01 13:32:43', '2024-10-01 06:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `ref_program_study_program`
--

CREATE TABLE `ref_program_study_program` (
  `program_id` int(11) NOT NULL,
  `study_program_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ref_program_study_program`
--

INSERT INTO `ref_program_study_program` (`program_id`, `study_program_id`, `is_active`, `date_added`, `timestamp`) VALUES
(1, '51ce2d58-7fc2-11ef-87c0-0068eb6957a0', 'yes', '2024-10-01 09:00:28', '2024-10-01 07:01:32'),
(1, '51ce7c24-7fc2-11ef-87c0-0068eb6957a0', 'yes', '2024-10-01 09:00:28', '2024-10-01 07:01:32'),
(1, '51ce53bf-7fc2-11ef-87c0-0068eb6957a0', 'yes', '2024-10-01 09:00:28', '2024-10-01 07:01:32'),
(1, '825456e9-7fc1-11ef-87c0-0068eb6957a0', 'yes', '2024-10-01 09:00:28', '2024-10-01 07:01:32'),
(1, '82543233-7fc1-11ef-87c0-0068eb6957a0', 'yes', '2024-10-01 09:00:28', '2024-10-01 07:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `ref_questions`
--

CREATE TABLE `ref_questions` (
  `question_id` int(11) NOT NULL,
  `question_content` varchar(100) NOT NULL,
  `question_has_free_text` enum('yes','no') NOT NULL DEFAULT 'no',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_question_sections`
--

CREATE TABLE `ref_question_sections` (
  `question_section_id` int(11) NOT NULL,
  `question_section_name` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_religion`
--

CREATE TABLE `ref_religion` (
  `religion_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `religion_feeder_id` int(11) NOT NULL,
  `religion_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ref_religion`
--

INSERT INTO `ref_religion` (`religion_id`, `religion_feeder_id`, `religion_name`, `date_added`, `timestamp`) VALUES
('223e769b-cc54-48e4-8446-574377083120', 4, 'Hindu', '2019-05-29 10:31:30', '2019-05-29 03:31:30'),
('53b17ff0-e4c0-4fc9-8735-bbb8c7054048', 1, 'Islam', '2019-05-29 10:31:30', '2019-05-29 03:31:30'),
('d5c8f0fd-fdb0-4dfa-8e2f-e863d96e98cd', 3, 'Katholik', '2019-05-29 10:31:30', '2019-05-29 03:31:30'),
('e3e29f7e-400b-49d9-88b2-760f8ce26cb5', 6, 'Konghucu', '2019-05-29 10:31:30', '2019-05-29 03:31:30'),
('e703430a-e6bc-491b-8d75-75024ed80551', 2, 'Kristen', '2019-05-29 10:31:30', '2019-05-29 03:31:30'),
('fc389367-54a8-42a4-99bc-7ffa2d1a3e42', 5, 'Budha', '2019-05-29 10:31:30', '2019-05-29 03:31:30'),
('fc865c74-a84f-41f5-953b-30ced05bfa77', 99, 'Lainnya', '2019-05-29 10:31:30', '2019-05-29 03:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `ref_scholarship`
--

CREATE TABLE `ref_scholarship` (
  `scholarship_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `scholarship_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `scholarship_description` varchar(100) DEFAULT NULL,
  `scholarship_status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `specific_user` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `scholarship_fee_type` enum('main','additional') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'additional',
  `scholarship_target` enum('student','candidate') NOT NULL DEFAULT 'candidate',
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_study_program`
--

CREATE TABLE `ref_study_program` (
  `study_program_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `faculty_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_program_main_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_program_code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `study_program_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_program_name_feeder` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_program_gii_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'gii: German International Institute',
  `study_program_ni_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ni: National Institute ',
  `study_program_abbreviation` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_program_ni_abbreviation` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_program_is_active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `study_program_dikti_code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ref_study_program`
--

INSERT INTO `ref_study_program` (`study_program_id`, `faculty_id`, `study_program_main_id`, `study_program_code`, `study_program_name`, `study_program_name_feeder`, `study_program_gii_name`, `study_program_ni_name`, `study_program_abbreviation`, `study_program_ni_abbreviation`, `study_program_is_active`, `study_program_dikti_code`, `date_added`, `timestamp`) VALUES
('51ce2d58-7fc2-11ef-87c0-0068eb6957a0', '4a3a699e-7fbf-11ef-87c0-0068eb6957a0', NULL, '03', 'Computer Science', 'Ilmu Komputer', 'Computer Science', NULL, 'IK', NULL, 'yes', '55208', '2024-10-01 08:51:23', '2024-10-01 06:57:55'),
('51ce53bf-7fc2-11ef-87c0-0068eb6957a0', '4a3a699e-7fbf-11ef-87c0-0068eb6957a0', NULL, '04', 'Information System and Technology', 'Sistem Teknologi Informasi', 'Information System and Technology', NULL, 'STI', NULL, 'yes', '59201', '2024-10-01 08:51:23', '2024-10-01 06:58:14'),
('51ce7c24-7fc2-11ef-87c0-0068eb6957a0', '4a3a699e-7fbf-11ef-87c0-0068eb6957a0', NULL, '05', 'Data Science', 'Sains Data', 'Data Science', NULL, 'SD', NULL, 'yes', '49202', '2024-10-01 08:51:23', '2024-10-01 06:58:20'),
('82543233-7fc1-11ef-87c0-0068eb6957a0', '2de874e6-7fbf-11ef-87c0-0068eb6957a0', NULL, '01', 'Digital Business', 'Bisnis Digital', 'Digital Business', NULL, 'BD', NULL, 'yes', '61209', '2024-10-01 08:33:15', '2024-10-01 06:58:35'),
('825456e9-7fc1-11ef-87c0-0068eb6957a0', '2de874e6-7fbf-11ef-87c0-0068eb6957a0', NULL, '02', 'Finance', 'Keuangan dan Investasi', 'Keuangan dan Investasi', NULL, 'EKP', NULL, 'yes', '87222', '2024-10-01 08:33:15', '2024-10-01 06:58:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dikti_wilayah`
--
ALTER TABLE `dikti_wilayah`
  ADD PRIMARY KEY (`id_wilayah`);

--
-- Indexes for table `dt_academic_history`
--
ALTER TABLE `dt_academic_history`
  ADD PRIMARY KEY (`academic_history_id`),
  ADD KEY `personal_data_id` (`personal_data_id`),
  ADD KEY `institution_id` (`institution_id`),
  ADD KEY `occupation_id` (`occupation_id`);

--
-- Indexes for table `dt_academic_year`
--
ALTER TABLE `dt_academic_year`
  ADD PRIMARY KEY (`academic_year_id`);

--
-- Indexes for table `dt_access_log`
--
ALTER TABLE `dt_access_log`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202112`
--
ALTER TABLE `dt_access_log_202112`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202201`
--
ALTER TABLE `dt_access_log_202201`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202202`
--
ALTER TABLE `dt_access_log_202202`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202203`
--
ALTER TABLE `dt_access_log_202203`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202204`
--
ALTER TABLE `dt_access_log_202204`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202205`
--
ALTER TABLE `dt_access_log_202205`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202206`
--
ALTER TABLE `dt_access_log_202206`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202207`
--
ALTER TABLE `dt_access_log_202207`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202208`
--
ALTER TABLE `dt_access_log_202208`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202209`
--
ALTER TABLE `dt_access_log_202209`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202210`
--
ALTER TABLE `dt_access_log_202210`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202211`
--
ALTER TABLE `dt_access_log_202211`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_access_log_202212`
--
ALTER TABLE `dt_access_log_202212`
  ADD PRIMARY KEY (`access_log_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_address`
--
ALTER TABLE `dt_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `dikti_wilayah_id` (`dikti_wilayah_id`);

--
-- Indexes for table `dt_api`
--
ALTER TABLE `dt_api`
  ADD PRIMARY KEY (`api_access_token`);

--
-- Indexes for table `dt_candidate_answer`
--
ALTER TABLE `dt_candidate_answer`
  ADD KEY `exam_question_id` (`exam_question_id`),
  ADD KEY `question_option_id` (`question_option_id`),
  ADD KEY `dt_candidate_answer_ibfk_1` (`exam_candidate_id`);

--
-- Indexes for table `dt_event`
--
ALTER TABLE `dt_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `dt_event_bookings`
--
ALTER TABLE `dt_event_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `dt_exam_candidate`
--
ALTER TABLE `dt_exam_candidate`
  ADD PRIMARY KEY (`exam_candidate_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `dt_exam_period`
--
ALTER TABLE `dt_exam_period`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `dt_exam_question`
--
ALTER TABLE `dt_exam_question`
  ADD PRIMARY KEY (`exam_question_id`);

--
-- Indexes for table `dt_exam_question_option`
--
ALTER TABLE `dt_exam_question_option`
  ADD PRIMARY KEY (`question_option_id`),
  ADD KEY `exam_question_id` (`exam_question_id`);

--
-- Indexes for table `dt_family`
--
ALTER TABLE `dt_family`
  ADD PRIMARY KEY (`family_id`);

--
-- Indexes for table `dt_family_member`
--
ALTER TABLE `dt_family_member`
  ADD KEY `personal_data_id` (`personal_data_id`),
  ADD KEY `family_id` (`family_id`);

--
-- Indexes for table `dt_institution_contact`
--
ALTER TABLE `dt_institution_contact`
  ADD KEY `institution_id` (`institution_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_personal_address`
--
ALTER TABLE `dt_personal_address`
  ADD KEY `personal_data_id` (`personal_data_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `dt_personal_data`
--
ALTER TABLE `dt_personal_data`
  ADD PRIMARY KEY (`personal_data_id`),
  ADD KEY `citizenship_id` (`citizenship_id`),
  ADD KEY `country_of_birth` (`country_of_birth`),
  ADD KEY `religion_id` (`religion_id`),
  ADD KEY `ocupation_id` (`ocupation_id`);

--
-- Indexes for table `dt_personal_data_document`
--
ALTER TABLE `dt_personal_data_document`
  ADD KEY `document_type_id` (`document_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_questionnaire_answers`
--
ALTER TABLE `dt_questionnaire_answers`
  ADD PRIMARY KEY (`question_answer_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `question_section_id` (`question_section_id`),
  ADD KEY `personal_data_id` (`personal_data_id`);

--
-- Indexes for table `dt_question_section_group`
--
ALTER TABLE `dt_question_section_group`
  ADD PRIMARY KEY (`question_section_group_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `question_section_id` (`question_section_id`);

--
-- Indexes for table `dt_reference`
--
ALTER TABLE `dt_reference`
  ADD KEY `referrer_id` (`referrer_id`),
  ADD KEY `referenced_id` (`referenced_id`);

--
-- Indexes for table `dt_registration_scholarship`
--
ALTER TABLE `dt_registration_scholarship`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `personal_data_id` (`personal_data_id`),
  ADD KEY `scholarship_id` (`scholarship_id`);

--
-- Indexes for table `dt_student`
--
ALTER TABLE `dt_student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `study_program_id` (`study_program_id`),
  ADD KEY `dt_student_ibfk_2` (`personal_data_id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `finance_year_id` (`finance_year_id`),
  ADD KEY `student_registration_scholarship_id` (`student_registration_scholarship_id`),
  ADD KEY `study_program_id_alt_1` (`study_program_id_alt_1`),
  ADD KEY `study_program_id_alt_2` (`study_program_id_alt_2`);

--
-- Indexes for table `ref_country`
--
ALTER TABLE `ref_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `ref_document`
--
ALTER TABLE `ref_document`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `ref_document_type`
--
ALTER TABLE `ref_document_type`
  ADD PRIMARY KEY (`document_type_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Indexes for table `ref_faculty`
--
ALTER TABLE `ref_faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `ref_institution`
--
ALTER TABLE `ref_institution`
  ADD PRIMARY KEY (`institution_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `ref_ocupation`
--
ALTER TABLE `ref_ocupation`
  ADD PRIMARY KEY (`ocupation_id`);

--
-- Indexes for table `ref_program`
--
ALTER TABLE `ref_program`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `program_main_id` (`program_main_id`);

--
-- Indexes for table `ref_program_study_program`
--
ALTER TABLE `ref_program_study_program`
  ADD KEY `program_id` (`program_id`),
  ADD KEY `study_program_id` (`study_program_id`);

--
-- Indexes for table `ref_questions`
--
ALTER TABLE `ref_questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `ref_question_sections`
--
ALTER TABLE `ref_question_sections`
  ADD PRIMARY KEY (`question_section_id`);

--
-- Indexes for table `ref_religion`
--
ALTER TABLE `ref_religion`
  ADD PRIMARY KEY (`religion_id`);

--
-- Indexes for table `ref_scholarship`
--
ALTER TABLE `ref_scholarship`
  ADD PRIMARY KEY (`scholarship_id`);

--
-- Indexes for table `ref_study_program`
--
ALTER TABLE `ref_study_program`
  ADD PRIMARY KEY (`study_program_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `study_program_main_id` (`study_program_main_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dt_access_log`
--
ALTER TABLE `dt_access_log`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202112`
--
ALTER TABLE `dt_access_log_202112`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202201`
--
ALTER TABLE `dt_access_log_202201`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202202`
--
ALTER TABLE `dt_access_log_202202`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202203`
--
ALTER TABLE `dt_access_log_202203`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202204`
--
ALTER TABLE `dt_access_log_202204`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202205`
--
ALTER TABLE `dt_access_log_202205`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202206`
--
ALTER TABLE `dt_access_log_202206`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202207`
--
ALTER TABLE `dt_access_log_202207`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202208`
--
ALTER TABLE `dt_access_log_202208`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202209`
--
ALTER TABLE `dt_access_log_202209`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202210`
--
ALTER TABLE `dt_access_log_202210`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202211`
--
ALTER TABLE `dt_access_log_202211`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_access_log_202212`
--
ALTER TABLE `dt_access_log_202212`
  MODIFY `access_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_questionnaire_answers`
--
ALTER TABLE `dt_questionnaire_answers`
  MODIFY `question_answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_question_section_group`
--
ALTER TABLE `dt_question_section_group`
  MODIFY `question_section_group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_program`
--
ALTER TABLE `ref_program`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ref_questions`
--
ALTER TABLE `ref_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_question_sections`
--
ALTER TABLE `ref_question_sections`
  MODIFY `question_section_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dt_academic_history`
--
ALTER TABLE `dt_academic_history`
  ADD CONSTRAINT `dt_academic_history_ibfk_1` FOREIGN KEY (`personal_data_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_academic_history_ibfk_2` FOREIGN KEY (`institution_id`) REFERENCES `ref_institution` (`institution_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_academic_history_ibfk_3` FOREIGN KEY (`occupation_id`) REFERENCES `ref_ocupation` (`ocupation_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dt_address`
--
ALTER TABLE `dt_address`
  ADD CONSTRAINT `dt_address_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `ref_country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_address_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `ref_country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_address_ibfk_3` FOREIGN KEY (`dikti_wilayah_id`) REFERENCES `dikti_wilayah` (`id_wilayah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_candidate_answer`
--
ALTER TABLE `dt_candidate_answer`
  ADD CONSTRAINT `dt_candidate_answer_ibfk_1` FOREIGN KEY (`exam_candidate_id`) REFERENCES `dt_exam_candidate` (`exam_candidate_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_candidate_answer_ibfk_2` FOREIGN KEY (`exam_question_id`) REFERENCES `dt_exam_question` (`exam_question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_candidate_answer_ibfk_3` FOREIGN KEY (`question_option_id`) REFERENCES `dt_exam_question_option` (`question_option_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_event_bookings`
--
ALTER TABLE `dt_event_bookings`
  ADD CONSTRAINT `dt_event_bookings_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `dt_event` (`event_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dt_exam_candidate`
--
ALTER TABLE `dt_exam_candidate`
  ADD CONSTRAINT `dt_exam_candidate_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `dt_exam_period` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_exam_candidate_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `dt_student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_exam_question_option`
--
ALTER TABLE `dt_exam_question_option`
  ADD CONSTRAINT `dt_exam_question_option_ibfk_1` FOREIGN KEY (`exam_question_id`) REFERENCES `dt_exam_question` (`exam_question_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_family_member`
--
ALTER TABLE `dt_family_member`
  ADD CONSTRAINT `dt_family_member_ibfk_1` FOREIGN KEY (`personal_data_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_family_member_ibfk_2` FOREIGN KEY (`family_id`) REFERENCES `dt_family` (`family_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_institution_contact`
--
ALTER TABLE `dt_institution_contact`
  ADD CONSTRAINT `dt_institution_contact_ibfk_1` FOREIGN KEY (`institution_id`) REFERENCES `ref_institution` (`institution_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_institution_contact_ibfk_2` FOREIGN KEY (`personal_data_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_personal_address`
--
ALTER TABLE `dt_personal_address`
  ADD CONSTRAINT `dt_personal_address_ibfk_1` FOREIGN KEY (`personal_data_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_personal_address_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `dt_address` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_personal_data`
--
ALTER TABLE `dt_personal_data`
  ADD CONSTRAINT `dt_personal_data_ibfk_1` FOREIGN KEY (`citizenship_id`) REFERENCES `ref_country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_personal_data_ibfk_2` FOREIGN KEY (`country_of_birth`) REFERENCES `ref_country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_personal_data_ibfk_3` FOREIGN KEY (`religion_id`) REFERENCES `ref_religion` (`religion_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_personal_data_ibfk_4` FOREIGN KEY (`ocupation_id`) REFERENCES `ref_ocupation` (`ocupation_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_personal_data_document`
--
ALTER TABLE `dt_personal_data_document`
  ADD CONSTRAINT `dt_personal_data_document_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `ref_document` (`document_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_personal_data_document_ibfk_2` FOREIGN KEY (`personal_data_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_questionnaire_answers`
--
ALTER TABLE `dt_questionnaire_answers`
  ADD CONSTRAINT `dt_questionnaire_answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `ref_questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_questionnaire_answers_ibfk_2` FOREIGN KEY (`question_section_id`) REFERENCES `ref_question_sections` (`question_section_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_questionnaire_answers_ibfk_3` FOREIGN KEY (`personal_data_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_question_section_group`
--
ALTER TABLE `dt_question_section_group`
  ADD CONSTRAINT `dt_question_section_group_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `ref_questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_question_section_group_ibfk_2` FOREIGN KEY (`question_section_id`) REFERENCES `ref_question_sections` (`question_section_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_reference`
--
ALTER TABLE `dt_reference`
  ADD CONSTRAINT `dt_reference_ibfk_1` FOREIGN KEY (`referrer_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_reference_ibfk_2` FOREIGN KEY (`referenced_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_registration_scholarship`
--
ALTER TABLE `dt_registration_scholarship`
  ADD CONSTRAINT `dt_registration_scholarship_ibfk_1` FOREIGN KEY (`academic_year_id`) REFERENCES `dt_academic_year` (`academic_year_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_registration_scholarship_ibfk_2` FOREIGN KEY (`personal_data_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_registration_scholarship_ibfk_3` FOREIGN KEY (`scholarship_id`) REFERENCES `ref_scholarship` (`scholarship_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dt_student`
--
ALTER TABLE `dt_student`
  ADD CONSTRAINT `dt_student_ibfk_1` FOREIGN KEY (`study_program_id`) REFERENCES `ref_study_program` (`study_program_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_student_ibfk_2` FOREIGN KEY (`personal_data_id`) REFERENCES `dt_personal_data` (`personal_data_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_student_ibfk_3` FOREIGN KEY (`academic_year_id`) REFERENCES `dt_academic_year` (`academic_year_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_student_ibfk_4` FOREIGN KEY (`program_id`) REFERENCES `ref_program` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_student_ibfk_5` FOREIGN KEY (`finance_year_id`) REFERENCES `dt_academic_year` (`academic_year_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_student_ibfk_6` FOREIGN KEY (`student_registration_scholarship_id`) REFERENCES `ref_scholarship` (`scholarship_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_student_ibfk_7` FOREIGN KEY (`study_program_id_alt_1`) REFERENCES `ref_study_program` (`study_program_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dt_student_ibfk_8` FOREIGN KEY (`study_program_id_alt_2`) REFERENCES `ref_study_program` (`study_program_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ref_document_type`
--
ALTER TABLE `ref_document_type`
  ADD CONSTRAINT `ref_document_type_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `ref_document` (`document_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ref_institution`
--
ALTER TABLE `ref_institution`
  ADD CONSTRAINT `ref_institution_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `dt_address` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ref_program`
--
ALTER TABLE `ref_program`
  ADD CONSTRAINT `ref_program_ibfk_1` FOREIGN KEY (`program_main_id`) REFERENCES `ref_program` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ref_program_study_program`
--
ALTER TABLE `ref_program_study_program`
  ADD CONSTRAINT `ref_program_study_program_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `ref_program` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ref_program_study_program_ibfk_2` FOREIGN KEY (`study_program_id`) REFERENCES `ref_study_program` (`study_program_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ref_study_program`
--
ALTER TABLE `ref_study_program`
  ADD CONSTRAINT `ref_study_program_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `ref_faculty` (`faculty_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ref_study_program_ibfk_2` FOREIGN KEY (`study_program_main_id`) REFERENCES `ref_study_program` (`study_program_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
