-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2020 at 10:09 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrm_dk`
--

-- --------------------------------------------------------

--
-- Table structure for table `addition`
--

CREATE TABLE `addition` (
  `addi_id` int(14) NOT NULL,
  `salary_id` int(14) NOT NULL,
  `basic` varchar(128) DEFAULT NULL,
  `medical` varchar(64) DEFAULT NULL,
  `house_rent` varchar(64) DEFAULT NULL,
  `conveyance` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `addition`
--

INSERT INTO `addition` (`addi_id`, `salary_id`, `basic`, `medical`, `house_rent`, `conveyance`) VALUES
(1, 1, '25000', '0', '0', '0'),
(26, 26, '14000', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL,
  `type` enum('Present','Permanent') DEFAULT 'Present'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `ass_id` int(14) NOT NULL,
  `catid` varchar(14) NOT NULL,
  `ass_name` varchar(256) DEFAULT NULL,
  `ass_brand` varchar(128) DEFAULT NULL,
  `ass_model` varchar(256) DEFAULT NULL,
  `ass_code` varchar(256) DEFAULT NULL,
  `configuration` varchar(512) DEFAULT NULL,
  `purchasing_date` varchar(128) DEFAULT NULL,
  `ass_price` varchar(128) DEFAULT NULL,
  `ass_qty` varchar(64) DEFAULT NULL,
  `in_stock` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assets_category`
--

CREATE TABLE `assets_category` (
  `cat_id` int(14) NOT NULL,
  `cat_status` enum('ASSETS','LOGISTIC') NOT NULL DEFAULT 'ASSETS',
  `cat_name` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assets_category`
--

INSERT INTO `assets_category` (`cat_id`, `cat_status`, `cat_name`) VALUES
(1, 'ASSETS', 'TAB'),
(2, 'ASSETS', 'Computer'),
(3, 'ASSETS', 'Laptop'),
(4, 'LOGISTIC', 'tab');

-- --------------------------------------------------------

--
-- Table structure for table `assign_leave`
--

CREATE TABLE `assign_leave` (
  `id` int(14) NOT NULL,
  `app_id` varchar(11) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `type_id` int(14) NOT NULL,
  `day` varchar(256) DEFAULT NULL,
  `hour` varchar(255) NOT NULL,
  `total_day` varchar(64) DEFAULT NULL,
  `dateyear` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assign_task`
--

CREATE TABLE `assign_task` (
  `id` int(14) NOT NULL,
  `task_id` int(14) NOT NULL,
  `project_id` int(14) NOT NULL,
  `assign_user` varchar(64) DEFAULT NULL,
  `user_type` enum('Team Head','Collaborators') NOT NULL DEFAULT 'Collaborators'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `atten_date` varchar(64) DEFAULT NULL,
  `signin_time` time DEFAULT NULL,
  `signout_time` time DEFAULT NULL,
  `working_hour` varchar(64) DEFAULT NULL,
  `place` varchar(255) NOT NULL,
  `absence` varchar(128) DEFAULT NULL,
  `overtime` varchar(128) DEFAULT NULL,
  `earnleave` varchar(128) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_info`
--

CREATE TABLE `bank_info` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `holder_name` varchar(256) DEFAULT NULL,
  `bank_name` varchar(256) DEFAULT NULL,
  `branch_name` varchar(256) DEFAULT NULL,
  `account_number` varchar(256) DEFAULT NULL,
  `ifsc` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img_src` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `img_src`, `created_at`, `updated_at`) VALUES
(4, 'Agro health', 'brands/eYL2skKt2FV4HnWjebqpMTPFH2loghPSHREw4u2V.jpeg', '2020-10-06 02:00:13', '2020-10-06 02:00:13'),
(5, 'Parle Agro', 'brands/2OAm6aJbzB2AtlplRrY9WaJ5FtpSBTZwv1uowtZv.png', '2020-10-05 02:00:24', '2020-10-06 02:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(255) NOT NULL,
  `img_src` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `img_src`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(79, 'Agro products', 0, 'categories/iFWj2l8vI3zaC79tqgAK0VtcPKkgP0ZG94W4dbfn.jpeg', 'agro-products', NULL, '2020-10-02 02:35:40', '2020-10-02 02:35:40'),
(80, 'Health products', 0, 'categories/X15lcmsVSsnnsGDqZZaM936FY1pwBjFTI8xdEWYp.jpeg', 'health-products', NULL, '2020-10-02 02:35:53', '2020-10-02 02:35:53'),
(81, 'Organic fertilizers', 79, NULL, 'organic-fertilizers', NULL, '2020-10-02 02:36:07', '2020-10-02 02:36:07'),
(82, 'Immunity boosters', 80, NULL, 'immunity-boosters', NULL, '2020-10-02 02:36:21', '2020-10-02 02:36:21'),
(83, 'D100', 81, NULL, 'd100', NULL, '2020-10-06 05:44:49', '2020-10-06 05:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `contact_no` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `gst_no` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

CREATE TABLE `deduction` (
  `de_id` int(14) NOT NULL,
  `salary_id` int(14) NOT NULL,
  `provident_fund` varchar(64) DEFAULT NULL,
  `bima` varchar(64) DEFAULT NULL,
  `tax` varchar(64) DEFAULT NULL,
  `others` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deduction`
--

INSERT INTO `deduction` (`de_id`, `salary_id`, `provident_fund`, `bima`, `tax`, `others`) VALUES
(1, 1, '0', '0', '0', '0'),
(26, 26, '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `dep_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dep_name`) VALUES
(2, 'Administration'),
(5, 'Development'),
(9, 'Design'),
(10, 'News');

-- --------------------------------------------------------

--
-- Table structure for table `desciplinary`
--

CREATE TABLE `desciplinary` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `action` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(11) NOT NULL,
  `des_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `des_name`) VALUES
(3, 'Chief Executive Officer (CEO)'),
(13, 'Web Developer'),
(15, 'News Editor'),
(16, 'Graphics designer'),
(17, 'Content Manager');

-- --------------------------------------------------------

--
-- Table structure for table `earned_leave`
--

CREATE TABLE `earned_leave` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `present_date` varchar(64) DEFAULT NULL,
  `hour` varchar(64) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `earned_leave`
--

INSERT INTO `earned_leave` (`id`, `em_id`, `present_date`, `hour`, `status`) VALUES
(26, 'Mir1685', '0', '0', '1'),
(27, 'Rah1682', '0', '0', '1'),
(28, 'edr1432', '0', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(128) DEFAULT NULL,
  `edu_type` varchar(256) DEFAULT NULL,
  `institute` varchar(256) DEFAULT NULL,
  `result` varchar(64) DEFAULT NULL,
  `year` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `em_code` varchar(64) DEFAULT NULL,
  `des_id` int(11) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `em_email` varchar(64) DEFAULT NULL,
  `em_password` varchar(512) NOT NULL,
  `em_role` enum('ADMIN','EMPLOYEE','SUPER ADMIN') NOT NULL DEFAULT 'EMPLOYEE',
  `em_address` varchar(512) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `em_gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `em_phone` varchar(64) DEFAULT NULL,
  `em_birthday` varchar(128) DEFAULT NULL,
  `em_blood_group` enum('O+','O-','A+','A-','B+','B-','AB+','OB+') DEFAULT NULL,
  `em_joining_date` varchar(128) DEFAULT NULL,
  `em_contact_end` varchar(128) DEFAULT NULL,
  `em_image` varchar(128) DEFAULT NULL,
  `em_nid` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `em_id`, `em_code`, `des_id`, `dep_id`, `first_name`, `last_name`, `em_email`, `em_password`, `em_role`, `em_address`, `status`, `em_gender`, `em_phone`, `em_birthday`, `em_blood_group`, `em_joining_date`, `em_contact_end`, `em_image`, `em_nid`) VALUES
(36, 'Adm1106', '123456', 2, 2, 'Admin', 'DK HRM', 'admin@gmail.com', 'cd5ea73cd58f827fa78eef7197b8ee606c99b2e6', 'ADMIN', NULL, 'ACTIVE', 'Male', '8888888888', '2019-02-13', 'O+', '2019-02-15', '2019-02-22', 'Doe1753.jpg', '01253568955555'),
(38, 'Agr1106', '', 13, 5, 'Ankur', 'Agrawal', 'ankur.agr32@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'EMPLOYEE', NULL, 'ACTIVE', 'Male', '8871192502', '1994-02-18', 'O+', '2019-09-03', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_file`
--

CREATE TABLE `employee_file` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `file_title` varchar(512) DEFAULT NULL,
  `file_url` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emp_assets`
--

CREATE TABLE `emp_assets` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `assets_id` int(11) NOT NULL,
  `given_date` date NOT NULL,
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emp_experience`
--

CREATE TABLE `emp_experience` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(256) DEFAULT NULL,
  `exp_company` varchar(128) DEFAULT NULL,
  `exp_com_position` varchar(128) DEFAULT NULL,
  `exp_com_address` varchar(128) DEFAULT NULL,
  `exp_workduration` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emp_leave`
--

CREATE TABLE `emp_leave` (
  `id` int(11) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `typeid` int(14) NOT NULL,
  `leave_type` varchar(64) DEFAULT NULL,
  `start_date` varchar(64) DEFAULT NULL,
  `end_date` varchar(64) DEFAULT NULL,
  `leave_duration` varchar(128) DEFAULT NULL,
  `apply_date` varchar(64) DEFAULT NULL,
  `reason` varchar(1024) DEFAULT NULL,
  `leave_status` enum('Approve','Not Approve','Rejected') NOT NULL DEFAULT 'Not Approve'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_penalty`
--

CREATE TABLE `emp_penalty` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `penalty_id` int(11) NOT NULL,
  `penalty_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary`
--

CREATE TABLE `emp_salary` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `total` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp_salary`
--

INSERT INTO `emp_salary` (`id`, `emp_id`, `type_id`, `total`) VALUES
(1, 'Adm1106', 1, '25000'),
(26, 'Agr1106', 1, '14000');

-- --------------------------------------------------------

--
-- Table structure for table `emp_training`
--

CREATE TABLE `emp_training` (
  `id` int(11) NOT NULL,
  `trainig_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `field_visit`
--

CREATE TABLE `field_visit` (
  `id` int(14) NOT NULL,
  `project_id` varchar(256) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `field_location` varchar(512) NOT NULL,
  `start_date` varchar(64) DEFAULT NULL,
  `approx_end_date` varchar(28) NOT NULL,
  `total_days` varchar(64) DEFAULT NULL,
  `notes` varchar(500) NOT NULL,
  `actual_return_date` varchar(28) NOT NULL,
  `status` enum('Approved','Not Approve','Rejected') NOT NULL DEFAULT 'Not Approve',
  `attendance_updated` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `holiday_name` varchar(256) DEFAULT NULL,
  `from_date` varchar(64) DEFAULT NULL,
  `to_date` varchar(64) DEFAULT NULL,
  `number_of_days` varchar(64) DEFAULT NULL,
  `year` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `type_id` int(14) NOT NULL,
  `name` varchar(64) NOT NULL,
  `leave_day` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`type_id`, `name`, `leave_day`, `status`) VALUES
(1, 'Casual Leave', '21', 1),
(2, 'Sick Leave', '15', 1),
(3, 'Maternity Leave', '90', 1),
(4, 'Paternal Leave', '7', 1),
(5, 'Earned leave', '', 1),
(7, 'Public Holiday', '', 1),
(8, 'Optional Leave', '', 1),
(9, 'Leave without Pay', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(256) DEFAULT NULL,
  `amount` varchar(256) DEFAULT NULL,
  `interest_percentage` varchar(256) DEFAULT NULL,
  `total_amount` varchar(64) DEFAULT NULL,
  `total_pay` varchar(64) DEFAULT NULL,
  `total_due` varchar(64) DEFAULT NULL,
  `installment` varchar(256) DEFAULT NULL,
  `loan_number` varchar(256) DEFAULT NULL,
  `loan_details` varchar(256) DEFAULT NULL,
  `approve_date` varchar(256) DEFAULT NULL,
  `install_period` varchar(256) DEFAULT NULL,
  `status` enum('Granted','Deny','Pause','Done') NOT NULL DEFAULT 'Pause'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loan_installment`
--

CREATE TABLE `loan_installment` (
  `id` int(14) NOT NULL,
  `loan_id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `loan_number` varchar(256) DEFAULT NULL,
  `install_amount` varchar(256) DEFAULT NULL,
  `pay_amount` varchar(64) DEFAULT NULL,
  `app_date` varchar(256) DEFAULT NULL,
  `receiver` varchar(256) DEFAULT NULL,
  `install_no` varchar(256) DEFAULT NULL,
  `notes` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loan_installment`
--

INSERT INTO `loan_installment` (`id`, `loan_id`, `emp_id`, `loan_number`, `install_amount`, `pay_amount`, `app_date`, `receiver`, `install_no`, `notes`) VALUES
(27, 33, 'Isl1385', '4008291', '5000', NULL, '2018-04-21', 'dsf dsf ds fds fdsf ds', '1', 'sf ds fsd fds fsd fdsf ds fsd'),
(28, 33, 'Isl1385', '4008291', '5000', NULL, '2018-04-04', 'dsdsff dsf ds f', '0', 'f dsfdsf dsfs'),
(29, 34, 'EMP1254478', '18194827', '5000', NULL, '2018-04-05', NULL, '4', NULL),
(30, 34, 'EMP1254478', '18194827', '5000', NULL, '2018-06-05', NULL, '3', NULL),
(31, 34, 'EMP1254478', '18194827', '5000', NULL, '2018-06-07', NULL, '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logistic_asset`
--

CREATE TABLE `logistic_asset` (
  `log_id` int(14) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `qty` varchar(64) DEFAULT NULL,
  `entry_date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logistic_asset`
--

INSERT INTO `logistic_asset` (`log_id`, `name`, `qty`, `entry_date`) VALUES
(1, 'Lubricant', '30', '12/25/17');

-- --------------------------------------------------------

--
-- Table structure for table `logistic_assign`
--

CREATE TABLE `logistic_assign` (
  `ass_id` int(14) NOT NULL,
  `asset_id` int(14) NOT NULL,
  `assign_id` varchar(64) DEFAULT NULL,
  `project_id` int(14) NOT NULL,
  `task_id` int(14) NOT NULL,
  `log_qty` varchar(64) DEFAULT NULL,
  `start_date` varchar(64) DEFAULT NULL,
  `end_date` varchar(64) DEFAULT NULL,
  `back_date` varchar(64) DEFAULT NULL,
  `back_qty` varchar(64) DEFAULT NULL,
  `remarks` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(19, '2014_10_12_000000_create_users_table', 1),
(20, '2014_10_12_100000_create_password_resets_table', 1),
(21, '2019_08_19_000000_create_failed_jobs_table', 1),
(22, '2020_04_18_101953_create_products_table', 1),
(23, '2020_04_18_132841_create_profiles_table', 1),
(24, '2020_04_21_154729_create_stocks_table', 1),
(25, '2020_04_24_084350_create_orders_table', 1),
(26, '2020_04_26_123151_create_reminders_table', 1),
(27, '2020_04_27_044831_create_newsletters_table', 1),
(28, '2020_09_28_115317_create_categories_table', 2),
(29, '2020_10_07_104409_create_payment_table', 3),
(30, '2020_10_12_075024_create_attributes_table', 4),
(31, '2020_10_12_075202_create_attribute_details_table', 4),
(32, '2020_10_12_075345_create_product_attributes_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_url` varchar(256) DEFAULT NULL,
  `date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `zipcode` int(11) NOT NULL,
  `is_paid` tinyint(4) NOT NULL DEFAULT 1,
  `payment_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `order_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ORDERED',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `amount`, `cart`, `phonenumber`, `country`, `city`, `address`, `zipcode`, `is_paid`, `payment_type`, `payment_id`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dawn Roe', '500', 'O:8:\"App\\Cart\":3:{s:5:\"items\";a:1:{i:1;a:4:{s:8:\"quantity\";i:1;s:5:\"price\";i:275;s:4:\"item\";O:11:\"App\\Product\":27:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:3;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"SUPREME X AIR FORCE 1 LOW \"BOX LOGO - WHITE\"\";s:5:\"price\";i:275;s:5:\"image\";s:14:\"products/3.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:3;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"SUPREME X AIR FORCE 1 LOW \"BOX LOGO - WHITE\"\";s:5:\"price\";i:275;s:5:\"image\";s:14:\"products/3.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:10:\"product_id\";i:3;}}s:13:\"totalQuantity\";i:1;s:10:\"totalPrice\";i:275;}', '8215551234', 'Indonesia', 'Medan', 'Danau Toba', 27321, 1, 'COD', NULL, 'REJECTED', '2020-10-07 00:05:27', '2020-10-08 02:15:55'),
(4, 2, 'Dawn Roe', '400', 'O:8:\"App\\Cart\":3:{s:5:\"items\";a:1:{i:0;a:4:{s:8:\"quantity\";i:1;s:5:\"price\";i:1375;s:4:\"item\";O:11:\"App\\Product\":27:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:1;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"AIR JORDAN 1 X OFF-WHITE NRG \"OFF WHITE UNC\"\";s:5:\"price\";i:1375;s:5:\"image\";s:14:\"products/1.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:1;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"AIR JORDAN 1 X OFF-WHITE NRG \"OFF WHITE UNC\"\";s:5:\"price\";i:1375;s:5:\"image\";s:14:\"products/1.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:10:\"product_id\";i:1;}}s:13:\"totalQuantity\";i:1;s:10:\"totalPrice\";i:1375;}', '8215551234', 'Indonesia', 'Medan', 'Danau Toba', 27321, 1, NULL, NULL, 'REJECTED', '2020-10-07 00:29:59', '2020-10-08 02:15:55'),
(5, 2, 'Dawn Roe', '2655', 'O:8:\"App\\Cart\":3:{s:5:\"items\";a:2:{i:0;a:4:{s:8:\"quantity\";i:1;s:5:\"price\";i:1375;s:4:\"item\";O:11:\"App\\Product\":27:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:1;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"AIR JORDAN 1 X OFF-WHITE NRG \"OFF WHITE UNC\"\";s:5:\"price\";i:1375;s:5:\"image\";s:14:\"products/1.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:1;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"AIR JORDAN 1 X OFF-WHITE NRG \"OFF WHITE UNC\"\";s:5:\"price\";i:1375;s:5:\"image\";s:14:\"products/1.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:10:\"product_id\";i:1;}i:1;a:4:{s:8:\"quantity\";i:1;s:5:\"price\";i:225;s:4:\"item\";O:11:\"App\\Product\":27:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:2;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:48:\"STUSSY X AIR ZOOM SPIRIDON CAGED \"PURE PLATINUM\"\";s:5:\"price\";i:225;s:5:\"image\";s:14:\"products/2.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:2;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:48:\"STUSSY X AIR ZOOM SPIRIDON CAGED \"PURE PLATINUM\"\";s:5:\"price\";i:225;s:5:\"image\";s:14:\"products/2.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:10:\"product_id\";i:2;}}s:13:\"totalQuantity\";i:2;s:10:\"totalPrice\";i:1600;}', '8215551234', 'Indonesia', 'Medan', 'Danau Toba', 27321, 1, NULL, NULL, 'REJECTED', '2020-10-07 00:31:46', '2020-10-08 02:15:55'),
(6, 2, 'Test', '2655', 'O:8:\"App\\Cart\":3:{s:5:\"items\";a:4:{i:1;a:4:{s:8:\"quantity\";i:1;s:5:\"price\";i:275;s:4:\"item\";O:11:\"App\\Product\":27:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:3;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"SUPREME X AIR FORCE 1 LOW \"BOX LOGO - WHITE\"\";s:5:\"price\";i:275;s:5:\"image\";s:14:\"products/3.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:3;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"SUPREME X AIR FORCE 1 LOW \"BOX LOGO - WHITE\"\";s:5:\"price\";i:275;s:5:\"image\";s:14:\"products/3.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:10:\"product_id\";i:3;}i:2;a:4:{s:8:\"quantity\";i:1;s:5:\"price\";i:780;s:4:\"item\";O:11:\"App\\Product\":27:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:6;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:26:\"YEEZY BOOST 350 V2 \"CREAM\"\";s:5:\"price\";i:780;s:5:\"image\";s:14:\"products/6.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:6;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:26:\"YEEZY BOOST 350 V2 \"CREAM\"\";s:5:\"price\";i:780;s:5:\"image\";s:14:\"products/6.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:10:\"product_id\";i:6;}i:3;a:4:{s:8:\"quantity\";i:1;s:5:\"price\";i:1375;s:4:\"item\";O:11:\"App\\Product\":27:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:1;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"AIR JORDAN 1 X OFF-WHITE NRG \"OFF WHITE UNC\"\";s:5:\"price\";i:1375;s:5:\"image\";s:14:\"products/1.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:1;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:44:\"AIR JORDAN 1 X OFF-WHITE NRG \"OFF WHITE UNC\"\";s:5:\"price\";i:1375;s:5:\"image\";s:14:\"products/1.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:10:\"product_id\";i:1;}i:4;a:4:{s:8:\"quantity\";i:1;s:5:\"price\";i:225;s:4:\"item\";O:11:\"App\\Product\":27:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:13:\"\0*\0attributes\";a:23:{s:2:\"id\";i:2;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:48:\"STUSSY X AIR ZOOM SPIRIDON CAGED \"PURE PLATINUM\"\";s:5:\"price\";i:225;s:5:\"image\";s:14:\"products/2.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:11:\"\0*\0original\";a:23:{s:2:\"id\";i:2;s:11:\"category_id\";s:1:\"0\";s:8:\"brand_id\";i:0;s:4:\"name\";s:48:\"STUSSY X AIR ZOOM SPIRIDON CAGED \"PURE PLATINUM\"\";s:5:\"price\";i:225;s:5:\"image\";s:14:\"products/2.jpg\";s:3:\"sku\";s:0:\"\";s:8:\"in_stock\";i:1;s:12:\"has_discount\";i:0;s:13:\"discount_type\";s:1:\"0\";s:13:\"discount_rate\";i:0;s:13:\"max_order_qty\";i:0;s:11:\"is_featured\";i:0;s:14:\"is_todays_deal\";i:0;s:4:\"tags\";s:0:\"\";s:8:\"url_slug\";s:0:\"\";s:11:\"short_descr\";s:0:\"\";s:10:\"full_descr\";s:0:\"\";s:10:\"meta_title\";s:0:\"\";s:10:\"meta_descr\";s:0:\"\";s:9:\"is_active\";i:1;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2020-10-06 09:45:42\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:8:\"\0*\0dates\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}s:10:\"product_id\";i:2;}}s:13:\"totalQuantity\";i:4;s:10:\"totalPrice\";i:2655;}', '8215551234', 'Indonesia', 'Medan', 'Danau Toba', 27321, 1, NULL, NULL, 'REJECTED', '2020-10-09 07:15:09', '2020-10-08 02:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(64) NOT NULL,
  `owner_position` varchar(64) DEFAULT NULL,
  `note` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_signature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_errors` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_salary`
--

CREATE TABLE `pay_salary` (
  `pay_id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `type_id` int(14) NOT NULL,
  `month` varchar(64) DEFAULT NULL,
  `year` varchar(64) DEFAULT NULL,
  `paid_date` varchar(64) DEFAULT NULL,
  `total_days` varchar(64) DEFAULT NULL,
  `basic` varchar(64) DEFAULT NULL,
  `medical` varchar(64) DEFAULT NULL,
  `house_rent` varchar(64) DEFAULT NULL,
  `bonus` varchar(64) DEFAULT NULL,
  `bima` varchar(64) DEFAULT NULL,
  `tax` varchar(64) DEFAULT NULL,
  `provident_fund` varchar(64) DEFAULT NULL,
  `loan` varchar(64) DEFAULT NULL,
  `total_pay` varchar(128) DEFAULT NULL,
  `addition` int(128) NOT NULL,
  `diduction` int(128) NOT NULL,
  `status` enum('Paid','Process') DEFAULT 'Process',
  `paid_type` enum('Hand Cash','Bank') NOT NULL DEFAULT 'Bank'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `id` int(11) NOT NULL,
  `penalty_name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` int(255) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` tinyint(4) NOT NULL DEFAULT 1,
  `has_discount` tinyint(4) NOT NULL DEFAULT 0,
  `discount_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_rate` int(11) DEFAULT NULL,
  `max_order_qty` smallint(4) NOT NULL,
  `is_featured` tinyint(4) NOT NULL DEFAULT 0,
  `is_todays_deal` tinyint(4) NOT NULL DEFAULT 0,
  `tags` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_slug` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_descr` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_descr` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_descr` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `price`, `image`, `sku`, `in_stock`, `has_discount`, `discount_type`, `discount_rate`, `max_order_qty`, `is_featured`, `is_todays_deal`, `tags`, `url_slug`, `short_descr`, `full_descr`, `meta_title`, `meta_descr`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '0', 0, 'AIR JORDAN 1 X OFF-WHITE NRG \"OFF WHITE UNC\"', 1375, 'products/1.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(2, '0', 0, 'STUSSY X AIR ZOOM SPIRIDON CAGED \"PURE PLATINUM\"', 225, 'products/2.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(3, '0', 0, 'SUPREME X AIR FORCE 1 LOW \"BOX LOGO - WHITE\"', 275, 'products/3.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(4, '0', 0, 'SACAI X LDV WAFFLE \"BLACK NYLON\"', 190, 'products/4.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(5, '0', 0, 'AIR JORDAN 1 RETRO HIGH \"SHATTERED BACKBOARD\"', 980, 'products/5.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(6, '0', 0, 'YEEZY BOOST 350 V2 \"CREAM\"', 780, 'products/6.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(7, '0', 0, 'YEEZY BOOST 350 V2\"YECHEIL NON-REFLECT\"', 978, 'products/7.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(8, '0', 0, 'YEEZY BOOST 350 V2 \"FROZEN YELLOW\"', 1100, 'products/8.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(9, '0', 0, 'AIR JORDAN 5 RETRO SP \"MUSLIN\"', 1499, 'products/9.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:42'),
(10, '0', 0, 'AIR JORDAN 1 RETRO HIGH ZOOM \"RACER BLUE\"', 625, 'products/10.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:41'),
(11, '0', 0, 'FENTY SLIDE \"PINK BOW \"', 399, 'products/11.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:41'),
(12, '0', 0, 'WMNS RS-X TRACKS \"FAIR AQUA\"', 499, 'products/12.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:41'),
(13, '0', 0, 'OLD SKOOL \'BLACK WHITE\' \"BLACK WHITE\"', 239, 'products/13.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:41'),
(14, '0', 0, 'OLD SKOOL \"YACHT CLUB\"', 359, 'products/14.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:41'),
(15, '0', 0, 'VANS OLD SKOOL \"RED CHECKERBOARD \"', 419, 'products/15.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:41'),
(16, '0', 0, 'ALL STAR 70S HI \"MILK\"', 579, 'products/16.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:41'),
(17, '0', 0, 'ALL-STAR 70S HI \"PLAY\"', 619, 'products/17.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 04:15:41'),
(18, '0', 0, 'FEAR OF GOD CHUCK 70 HI \"NATURAL\"', 1259, 'products/18.jpg', '', 1, 0, '0', 0, 0, 0, 0, '', '', '', '', '', '', 1, NULL, '2020-10-06 06:42:03'),
(40, '[\"79\"]', 4, 'New', 499, 'products/kpa51Lge0t96jsVrMt6U3kmYVR9npeFvgHb0rJYY.jpeg', NULL, 1, 0, '', NULL, 5, 0, 0, '[\"seeds\"]', 'new', NULL, NULL, NULL, NULL, 1, '2020-10-07 05:43:46', '2020-10-07 05:43:46'),
(41, '[\"79\",\"81\"]', 4, 'test2', 566, 'products/bPkN6mtAYa2ByGZGFkYrxzcBQ4kKxUs1ycFWXfDF.jpeg', NULL, 1, 0, '', NULL, 5, 0, 0, '[\"health products\",\"protien\"]', 'test2', NULL, NULL, NULL, NULL, 1, '2020-10-07 05:45:54', '2020-10-07 05:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `img_src` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phonenumber` bigint(20) DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `phonenumber`, `country`, `city`, `address`, `zipcode`, `created_at`, `updated_at`) VALUES
(1, 1, 11151552928, 'Singapore', 'Singapore', 'Buangkok Green 512-4a', 42132, NULL, NULL),
(2, 2, 8215551234, 'Indonesia', 'Medan', 'Danau Toba', 27321, NULL, NULL),
(3, 3, 42912345, 'United State of America', 'Seattle', 'Downtown Seattle ST 17', 78231, NULL, NULL),
(4, 4, 32912345, 'China', 'Guangzhou', 'ST 23a', 78213, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(14) NOT NULL,
  `pro_name` varchar(128) DEFAULT NULL,
  `pro_start_date` varchar(128) DEFAULT NULL,
  `pro_end_date` varchar(128) DEFAULT NULL,
  `pro_description` varchar(1024) DEFAULT NULL,
  `pro_summary` varchar(512) DEFAULT NULL,
  `pro_status` enum('upcoming','complete','running') NOT NULL DEFAULT 'running',
  `progress` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `pro_name`, `pro_start_date`, `pro_end_date`, `pro_description`, `pro_summary`, `pro_status`, `progress`) VALUES
(6, 'Bhukyra Agro', '2020-10-08', '2020-10-30', ' ryggrgregreg', 'grg', 'running', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_file`
--

CREATE TABLE `project_file` (
  `id` int(14) NOT NULL,
  `pro_id` int(14) NOT NULL,
  `file_details` varchar(1028) DEFAULT NULL,
  `file_url` varchar(256) DEFAULT NULL,
  `assigned_to` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pro_expenses`
--

CREATE TABLE `pro_expenses` (
  `id` int(14) NOT NULL,
  `pro_id` int(14) NOT NULL,
  `assign_to` varchar(64) DEFAULT NULL,
  `details` varchar(512) DEFAULT NULL,
  `amount` varchar(256) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pro_notes`
--

CREATE TABLE `pro_notes` (
  `id` int(14) NOT NULL,
  `assign_to` varchar(64) DEFAULT NULL,
  `pro_id` int(14) NOT NULL,
  `details` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pro_task`
--

CREATE TABLE `pro_task` (
  `id` int(14) NOT NULL,
  `pro_id` int(14) NOT NULL,
  `task_title` varchar(256) DEFAULT NULL,
  `start_date` varchar(128) DEFAULT NULL,
  `end_date` varchar(128) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  `description` varchar(2048) DEFAULT NULL,
  `task_type` enum('Office','Field') NOT NULL DEFAULT 'Office',
  `status` enum('running','complete','cancel') DEFAULT 'running',
  `location` varchar(512) DEFAULT NULL,
  `return_date` varchar(128) DEFAULT NULL,
  `total_days` varchar(128) DEFAULT NULL,
  `create_date` varchar(128) DEFAULT NULL,
  `approve_status` enum('Approved','Not Approve','Rejected') NOT NULL DEFAULT 'Not Approve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pro_task_assets`
--

CREATE TABLE `pro_task_assets` (
  `id` int(11) NOT NULL,
  `pro_task_id` int(11) NOT NULL,
  `assign_id` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reminder` text COLLATE utf8mb4_unicode_ci DEFAULT 'Type Something',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `reminder`, `created_at`, `updated_at`) VALUES
(1, 'Put your reminders here.', NULL, '2020-09-26 00:55:19');

-- --------------------------------------------------------

--
-- Table structure for table `salary_type`
--

CREATE TABLE `salary_type` (
  `id` int(14) NOT NULL,
  `salary_type` varchar(256) DEFAULT NULL,
  `create_date` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salary_type`
--

INSERT INTO `salary_type` (`id`, `salary_type`, `create_date`) VALUES
(1, 'Monthly', '2020-10-10'),
(2, 'Hourly', '2020-10-12'),
(5, 'Contract basis', '2020-10-12');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `short_descr` varchar(1000) DEFAULT NULL,
  `long_descr` text DEFAULT NULL,
  `price` varchar(100) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `sitelogo` varchar(128) DEFAULT NULL,
  `sitetitle` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `copyright` varchar(128) DEFAULT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `currency` varchar(128) DEFAULT NULL,
  `symbol` varchar(64) DEFAULT NULL,
  `system_email` varchar(128) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `address2` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `sitelogo`, `sitetitle`, `description`, `copyright`, `contact`, `currency`, `symbol`, `system_email`, `address`, `address2`) VALUES
(1, 'dk-hrm.svg', 'HRM-Digikraft social', 'DigiKraft Social | DigiKraft Social is one of the best Digital Marketing agency in Raipur, Chattisgarh that deals with various services like Digital Marketing, Email Marketing, Content Marketing, SEO.', 'DigiKraft Social - Raipur (C.G.)', '9586696310', 'Rs.', '₹', 'digikraftsocial@gmail.com', ' ', ' Raipur (C.G.)');

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `facebook` varchar(256) DEFAULT NULL,
  `linkedin` varchar(256) DEFAULT NULL,
  `instagram` varchar(512) DEFAULT NULL,
  `skype_id` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `social_media`
--

INSERT INTO `social_media` (`id`, `emp_id`, `facebook`, `linkedin`, `instagram`, `skype_id`) VALUES
(5, 'nam1390', '', '', '', ''),
(6, 'Agr1106', 'https://facebook.com/ankur32', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`, `created_at`, `updated_at`) VALUES
(1, 'health products', '2020-10-03 11:46:35', '2020-10-05 01:55:45'),
(2, 'protien', '2020-10-03 11:46:35', '2020-10-03 11:46:35'),
(3, 'fertilizers', '2020-10-03 11:47:15', '2020-10-03 11:47:15'),
(4, 'seeds', '2020-10-03 11:47:15', '2020-10-03 11:47:15'),
(20, 'new', '2020-10-06 05:29:23', '2020-10-06 05:29:23');

-- --------------------------------------------------------

--
-- Table structure for table `to-do_list`
--

CREATE TABLE `to-do_list` (
  `id` int(14) NOT NULL,
  `user_id` varchar(64) DEFAULT NULL,
  `to_dodata` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `value` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `to-do_list`
--

INSERT INTO `to-do_list` (`id`, `user_id`, `to_dodata`, `date`, `value`) VALUES
(31, 'Doe1754', 'New task is here in todo list', '2020-10-09 12:24:17pm', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@bhukyra.com', NULL, '$2y$10$/sJ80JyKsrfKRcFSOibpNOe6E08jYIY511yvar3kD8ixL6Qlr1m.e', 'Admin', NULL, NULL, NULL),
(2, 'Dawn Roe', 'user@gmail.com', NULL, '$2y$10$/sJ80JyKsrfKRcFSOibpNOe6E08jYIY511yvar3kD8ixL6Qlr1m.e', 'Customer', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addition`
--
ALTER TABLE `addition`
  ADD PRIMARY KEY (`addi_id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`ass_id`);

--
-- Indexes for table `assets_category`
--
ALTER TABLE `assets_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `assign_leave`
--
ALTER TABLE `assign_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_task`
--
ALTER TABLE `assign_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_info`
--
ALTER TABLE `bank_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction`
--
ALTER TABLE `deduction`
  ADD PRIMARY KEY (`de_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `desciplinary`
--
ALTER TABLE `desciplinary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earned_leave`
--
ALTER TABLE `earned_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_file`
--
ALTER TABLE `employee_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_assets`
--
ALTER TABLE `emp_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_experience`
--
ALTER TABLE `emp_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_leave`
--
ALTER TABLE `emp_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_penalty`
--
ALTER TABLE `emp_penalty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_salary`
--
ALTER TABLE `emp_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_visit`
--
ALTER TABLE `field_visit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_installment`
--
ALTER TABLE `loan_installment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistic_asset`
--
ALTER TABLE `logistic_asset`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `logistic_assign`
--
ALTER TABLE `logistic_assign`
  ADD PRIMARY KEY (`ass_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_salary`
--
ALTER TABLE `pay_salary`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_index` (`user_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_file`
--
ALTER TABLE `project_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_expenses`
--
ALTER TABLE `pro_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_notes`
--
ALTER TABLE `pro_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_task`
--
ALTER TABLE `pro_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_task_assets`
--
ALTER TABLE `pro_task_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_type`
--
ALTER TABLE `salary_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`);

--
-- Indexes for table `to-do_list`
--
ALTER TABLE `to-do_list`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `addition`
--
ALTER TABLE `addition`
  MODIFY `addi_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `ass_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `assets_category`
--
ALTER TABLE `assets_category`
  MODIFY `cat_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assign_leave`
--
ALTER TABLE `assign_leave`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `assign_task`
--
ALTER TABLE `assign_task`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

--
-- AUTO_INCREMENT for table `bank_info`
--
ALTER TABLE `bank_info`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deduction`
--
ALTER TABLE `deduction`
  MODIFY `de_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `desciplinary`
--
ALTER TABLE `desciplinary`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `earned_leave`
--
ALTER TABLE `earned_leave`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `employee_file`
--
ALTER TABLE `employee_file`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `emp_assets`
--
ALTER TABLE `emp_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_experience`
--
ALTER TABLE `emp_experience`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `emp_leave`
--
ALTER TABLE `emp_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `emp_penalty`
--
ALTER TABLE `emp_penalty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_salary`
--
ALTER TABLE `emp_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `field_visit`
--
ALTER TABLE `field_visit`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `type_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `loan_installment`
--
ALTER TABLE `loan_installment`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `logistic_asset`
--
ALTER TABLE `logistic_asset`
  MODIFY `log_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logistic_assign`
--
ALTER TABLE `logistic_assign`
  MODIFY `ass_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_salary`
--
ALTER TABLE `pay_salary`
  MODIFY `pay_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_file`
--
ALTER TABLE `project_file`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pro_expenses`
--
ALTER TABLE `pro_expenses`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pro_notes`
--
ALTER TABLE `pro_notes`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pro_task`
--
ALTER TABLE `pro_task`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pro_task_assets`
--
ALTER TABLE `pro_task_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salary_type`
--
ALTER TABLE `salary_type`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `to-do_list`
--
ALTER TABLE `to-do_list`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
