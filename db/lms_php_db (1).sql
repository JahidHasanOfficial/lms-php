-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2026 at 01:47 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_php_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL DEFAULT 1,
  `subtitle` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `subtitle`, `title`, `content`, `image`, `button_text`, `button_link`, `updated_at`) VALUES
(1, 'ABOUT US', 'Welcome to Interactive Cares', 'Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit.', 'uploads/about/1774252010_69c0efeacccb0.webp', 'Read More', '#', '2026-03-23 07:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `total_marks` int(11) DEFAULT 100,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `course_id`, `batch_id`, `title`, `description`, `deadline`, `total_marks`, `created_at`) VALUES
(1, 1, 8, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:57:44', 100, '2026-03-22 17:57:44'),
(2, 1, 8, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:05', 100, '2026-03-22 17:59:05'),
(3, 2, 6, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:07', 100, '2026-03-22 17:59:07'),
(4, 3, 9, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:08', 100, '2026-03-22 17:59:08'),
(5, 4, 2, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:09', 100, '2026-03-22 17:59:09'),
(6, 5, 10, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:09', 100, '2026-03-22 17:59:09'),
(7, 6, 4, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:10', 100, '2026-03-22 17:59:10'),
(8, 7, 3, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:11', 100, '2026-03-22 17:59:11'),
(9, 8, 7, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:11', 100, '2026-03-22 17:59:11'),
(10, 9, 5, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:12', 100, '2026-03-22 17:59:12'),
(11, 10, 1, 'Project 1: Discovery', 'Submit your initial research and discovery artifacts for the course project.', '2026-03-29 17:59:13', 100, '2026-03-22 17:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `batch_no` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `enrollment_deadline` date DEFAULT NULL,
  `class` int(30) DEFAULT NULL,
  `level` int(50) DEFAULT NULL,
  `duration` int(25) DEFAULT NULL,
  `status` enum('active','upcoming','completed') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `course_id`, `batch_no`, `title`, `start_date`, `end_date`, `enrollment_deadline`, `class`, `level`, `duration`, `status`, `created_at`) VALUES
(1, 10, 1, 'Inaugural Batch', '2026-03-28', NULL, '2026-03-26', NULL, NULL, NULL, 'active', '2026-03-22 17:27:12'),
(2, 4, 1, 'Inaugural Batch', '2026-03-26', NULL, '2026-03-24', NULL, NULL, NULL, 'active', '2026-03-22 17:27:12'),
(3, 7, 1, 'Inaugural Batch', '2026-03-27', NULL, '2026-03-25', NULL, NULL, NULL, 'active', '2026-03-22 17:27:13'),
(4, 6, 1, 'Inaugural Batch', '2026-04-01', NULL, '2026-03-30', NULL, NULL, NULL, 'active', '2026-03-22 17:27:13'),
(5, 9, 1, 'Inaugural Batch', '2026-03-31', NULL, '2026-03-29', NULL, NULL, NULL, 'active', '2026-03-22 17:27:13'),
(6, 2, 1, 'Inaugural Batch', '2026-03-30', NULL, '2026-03-28', NULL, NULL, NULL, 'active', '2026-03-22 17:27:14'),
(7, 8, 1, 'Inaugural Batch', '2026-03-29', NULL, '2026-03-27', NULL, NULL, NULL, 'active', '2026-03-22 17:27:14'),
(8, 1, 1, 'Inaugural Batch', '2026-03-28', NULL, '2026-03-26', NULL, NULL, NULL, 'active', '2026-03-22 17:27:14'),
(9, 3, 1, 'Inaugural Batch', '2026-03-26', NULL, '2026-03-24', NULL, NULL, NULL, 'active', '2026-03-22 17:27:15'),
(10, 5, 1, 'Inaugural Batch', '2026-03-24', NULL, '2026-03-22', NULL, NULL, NULL, 'active', '2026-03-22 17:27:15'),
(11, 3, 2, '', NULL, NULL, NULL, NULL, NULL, NULL, 'upcoming', '2026-03-24 16:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `category_id`, `title`, `slug`, `content`, `image`, `author_id`, `status`, `created_at`) VALUES
(1, 1, 'Future of Web Development in 2026', 'future-web-dev', 'Content for future web dev...', 'frontend-template/img/course-1.jpg', 1, 'published', '2026-03-23 14:50:37'),
(2, 1, 'Why Choose React for Large Scale Apps', 'choose-react', 'Content for react apps...', 'frontend-template/img/course-2.jpg', 1, 'published', '2026-03-23 14:50:37'),
(3, 2, 'Top 10 Learning Strategies for Students', 'learning-strategies', 'Content for learning strategies...', 'frontend-template/img/course-3.jpg', 1, 'published', '2026-03-23 14:50:37'),
(4, 3, 'How to Crack Your First Software Job Interview', 'first-job-interview', 'Content for job interview...', 'frontend-template/img/course-1.jpg', 1, 'published', '2026-03-23 14:50:37'),
(5, 1, 'Node.js vs Python for Backend', 'node-vs-python', 'Content for node vs python...', 'frontend-template/img/course-2.jpg', 1, 'published', '2026-03-23 14:50:37'),
(6, 2, 'Importance of Continuous Learning', 'continuous-learning', 'Content for learning...', 'frontend-template/img/course-3.jpg', 1, 'published', '2026-03-23 14:50:37'),
(7, 3, 'Building a Strong Portfolio in 2026', 'strong-portfolio', 'Content for portfolio...', 'frontend-template/img/course-1.jpg', 1, 'published', '2026-03-23 14:50:37'),
(8, 1, 'Machine Learning for Web Developers', 'ml-for-web', 'Content for ML...', 'frontend-template/img/course-2.jpg', 1, 'published', '2026-03-23 14:50:37'),
(9, 2, 'Online Education: Trends and Challenges', 'online-edu-trends', 'Content for edu trends...', 'frontend-template/img/course-3.jpg', 1, 'published', '2026-03-23 14:50:37'),
(10, 3, 'Effective Time Management for Freelancers', 'time-management', 'Content for time management...', 'frontend-template/img/course-1.jpg', 1, 'published', '2026-03-23 14:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Technology', 'technology', '2026-03-23 14:50:37'),
(2, 'Education', 'education', '2026-03-23 14:50:37'),
(3, 'Career Advice', 'career-advice', '2026-03-23 14:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `blog_likes`
--

CREATE TABLE `blog_likes` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog_likes`
--

INSERT INTO `blog_likes` (`id`, `blog_id`, `user_id`, `created_at`) VALUES
(3, 10, 10, '2026-03-23 14:52:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `description`, `created_at`) VALUES
(1, 'Web Development', 'web-development', 'frontend-template/img/cat-1.jpg', 'Master the art of Web Development with our expert-led courses.', '2026-03-22 17:26:49'),
(2, 'App Design', 'app-design', 'frontend-template/img/cat-2.jpg', 'Master the art of App Design with our expert-led courses.', '2026-03-22 17:26:49'),
(3, 'Marketing', 'marketing', 'frontend-template/img/cat-3.jpg', 'Master the art of Marketing with our expert-led courses.', '2026-03-22 17:26:49'),
(4, 'Photography', 'photography', 'frontend-template/img/cat-4.jpg', 'Master the art of Photography with our expert-led courses.', '2026-03-22 17:26:49'),
(5, 'Business', 'business', 'frontend-template/img/cat-1.jpg', 'Master the art of Business with our expert-led courses.', '2026-03-22 17:26:50'),
(6, 'Soft Skills', 'soft-skills', 'frontend-template/img/cat-2.jpg', 'Master the art of Soft Skills with our expert-led courses.', '2026-03-22 17:26:50'),
(7, 'Graphics Design', 'graphics-design', 'frontend-template/img/cat-3.jpg', 'Master the art of Graphics Design with our expert-led courses.', '2026-03-22 17:26:50'),
(8, 'Data Science', 'data-science', 'frontend-template/img/cat-4.jpg', 'Master the art of Data Science with our expert-led courses.', '2026-03-22 17:26:50'),
(9, 'Networking', 'networking', 'frontend-template/img/cat-1.jpg', 'Master the art of Networking with our expert-led courses.', '2026-03-22 17:26:50'),
(10, 'Cyber Security', 'cyber-security', 'frontend-template/img/cat-2.jpg', 'Master the art of Cyber Security with our expert-led courses.', '2026-03-22 17:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `certificate_url` varchar(255) DEFAULT NULL,
  `issued_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `consultation_requests`
--

CREATE TABLE `consultation_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'New',
  `batch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consultation_requests`
--

INSERT INTO `consultation_requests` (`id`, `name`, `email`, `phone`, `course_id`, `created_at`, `status`, `batch_id`) VALUES
(1, 'Francesca Good', 'kexafe@mailinator.com', '7584956925', 10, '2026-03-23 07:08:45', 'Contacted', NULL),
(2, 'Francesca Good', 'kexafe@mailinator.com', '7584956925', 10, '2026-03-23 07:16:41', 'New', 0),
(3, 'Lamar Bradford', 'cygoposoje@mailinator.com', '+1 (842) 445-5073', 1, '2026-03-23 07:19:44', 'New', 8),
(4, 'Shaeleigh Cook', 'kihusoqam@mailinator.com', '+1 (146) 255-7487', 5, '2026-03-23 07:26:35', 'New', 10);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('fixed','percent') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT 100,
  `used_count` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `expiry_date`, `usage_limit`, `used_count`, `status`, `created_at`) VALUES
(1, 'JKL90', 'percent', '50.00', '2026-03-24', 100, 0, 'active', '2026-03-23 04:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT 'default_course.png',
  `price` decimal(10,2) DEFAULT 0.00,
  `category_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `what_will_learn` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `target_audience` text DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `video_preview_url` varchar(255) DEFAULT NULL,
  `total_duration_hours` varchar(50) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `career_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `price`, `category_id`, `instructor_id`, `status`, `created_at`, `updated_at`, `what_will_learn`, `requirements`, `target_audience`, `discount_price`, `video_preview_url`, `total_duration_hours`, `tags`, `career_path`) VALUES
(1, 'Advanced Course 1', 'advanced-course-1', 'This is a comprehensive guide to mastering the topics covered in Course 1. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-2.jpg', '63.00', 7, 1, 'published', '2026-03-22 17:26:51', '2026-03-22 17:26:51', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '47.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(2, 'Advanced Course 2', 'advanced-course-2', 'This is a comprehensive guide to mastering the topics covered in Course 2. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-3.jpg', '71.00', 4, 9, 'published', '2026-03-22 17:26:54', '2026-03-22 17:26:54', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '49.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(3, 'Advanced Course 3', 'advanced-course-3', 'This is a comprehensive guide to mastering the topics covered in Course 3. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-1.jpg', '84.00', 7, 1, 'published', '2026-03-22 17:26:55', '2026-03-22 17:26:55', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '41.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(4, 'Advanced Course 4', 'advanced-course-4', 'This is a comprehensive guide to mastering the topics covered in Course 4. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-2.jpg', '67.00', 2, 7, 'published', '2026-03-22 17:26:57', '2026-03-22 17:26:57', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '39.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(5, 'Advanced Course 5', 'advanced-course-5', 'This is a comprehensive guide to mastering the topics covered in Course 5. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-3.jpg', '77.00', 10, 4, 'published', '2026-03-22 17:26:58', '2026-03-22 17:26:58', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '36.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(6, 'Advanced Course 6', 'advanced-course-6', 'This is a comprehensive guide to mastering the topics covered in Course 6. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-1.jpg', '79.00', 3, 3, 'published', '2026-03-22 17:27:01', '2026-03-22 17:27:01', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '44.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(7, 'Advanced Course 7', 'advanced-course-7', 'This is a comprehensive guide to mastering the topics covered in Course 7. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-2.jpg', '92.00', 2, 4, 'published', '2026-03-22 17:27:03', '2026-03-22 17:27:03', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '32.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(8, 'Advanced Course 8', 'advanced-course-8', 'This is a comprehensive guide to mastering the topics covered in Course 8. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-3.jpg', '88.00', 5, 6, 'published', '2026-03-22 17:27:05', '2026-03-22 17:27:05', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '30.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(9, 'Advanced Course 9', 'advanced-course-9', 'This is a comprehensive guide to mastering the topics covered in Course 9. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-1.jpg', '68.00', 3, 7, 'published', '2026-03-22 17:27:09', '2026-03-22 17:27:09', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '44.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL),
(10, 'Advanced Course 10', 'advanced-course-10', 'This is a comprehensive guide to mastering the topics covered in Course 10. You will learn everything from basics to advanced levels.', 'frontend-template/img/course-2.jpg', '100.00', 1, 6, 'published', '2026-03-22 17:27:10', '2026-03-22 17:27:10', '[\"Understand core concepts of the industry\", \"Build 5+ real-world projects\", \"Master advanced debugging techniques\", \"Learn how to scale applications\"]', '[\"Basic understanding of the subject\", \"A modern computer with internet access\", \"Passion for learning new skills\"]', '[\"Beginners looking to start a career\", \"Intermediate learners wanting to level up\", \"Professional developers\"]', '30.99', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '25.5', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_faqs`
--

CREATE TABLE `course_faqs` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `order_index` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_faqs`
--

INSERT INTO `course_faqs` (`id`, `course_id`, `question`, `answer`, `order_index`) VALUES
(1, 1, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(2, 1, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(3, 1, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(4, 1, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(5, 2, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(6, 2, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(7, 2, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(8, 2, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(9, 3, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(10, 3, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(11, 3, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(12, 3, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(13, 4, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(14, 4, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(15, 4, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(16, 4, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(17, 5, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(18, 5, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(19, 5, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(20, 5, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(21, 6, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(22, 6, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(23, 6, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(24, 6, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(25, 7, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(26, 7, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(27, 7, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(28, 7, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(29, 8, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(30, 8, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(31, 8, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(32, 8, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(33, 9, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(34, 9, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(35, 9, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(36, 9, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0),
(37, 10, 'এই কোর্সটি কাদের জন্য?', 'যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।', 0),
(38, 10, 'ক্লাস কখন হয়?', 'সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।', 0),
(39, 10, 'সার্টিফিকেট কি পাওয়া যাবে?', 'হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।', 0),
(40, 10, 'ল্যাপটপ কি বাধ্যতামূলক?', 'যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_features`
--

CREATE TABLE `course_features` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `feature` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_features`
--

INSERT INTO `course_features` (`id`, `course_id`, `feature`) VALUES
(1, 1, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(2, 1, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(3, 1, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(4, 1, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(5, 1, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(6, 1, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(7, 2, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(8, 2, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(9, 2, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(10, 2, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(11, 2, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(12, 2, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(13, 3, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(14, 3, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(15, 3, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(16, 3, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(17, 3, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(18, 3, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(19, 4, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(20, 4, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(21, 4, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(22, 4, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(23, 4, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(24, 4, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(25, 5, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(26, 5, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(27, 5, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(28, 5, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(29, 5, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(30, 5, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(31, 6, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(32, 6, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(33, 6, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(34, 6, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(35, 6, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(36, 6, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(37, 7, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(38, 7, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(39, 7, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(40, 7, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(41, 7, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(42, 7, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(43, 8, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(44, 8, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(45, 8, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(46, 8, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(47, 8, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(48, 8, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(49, 9, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(50, 9, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(51, 9, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(52, 9, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(53, 9, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(54, 9, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(55, 10, '১০০+ প্রি-রেকর্ডড ভিডিও লসন'),
(56, 10, '১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট'),
(57, 10, '৪০+ পজিটিভ লাইভ ক্লাস সেশন'),
(58, 10, 'প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন'),
(59, 10, 'ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক'),
(60, 10, 'জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স'),
(61, 10, 'Advanced Course 6 +'),
(62, 10, 'Advanced Course 6 +'),
(63, 10, 'Advanced Course 6 +sdfsdfsfdsfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `course_instructors`
--

CREATE TABLE `course_instructors` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_instructors`
--

INSERT INTO `course_instructors` (`id`, `course_id`, `user_id`) VALUES
(1, 1, 7),
(2, 1, 4),
(3, 2, 4),
(4, 2, 3),
(5, 3, 6),
(6, 3, 1),
(7, 4, 3),
(8, 4, 4),
(9, 5, 1),
(10, 5, 2),
(11, 6, 7),
(12, 6, 9),
(13, 7, 1),
(14, 7, 9),
(15, 8, 1),
(16, 8, 3),
(17, 9, 7),
(18, 9, 1),
(19, 10, 3),
(20, 10, 1),
(21, 10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `course_outcomes`
--

CREATE TABLE `course_outcomes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `outcome` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_outcomes`
--

INSERT INTO `course_outcomes` (`id`, `course_id`, `outcome`) VALUES
(1, 1, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(2, 1, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(3, 1, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(4, 1, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(5, 1, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(6, 2, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(7, 2, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(8, 2, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(9, 2, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(10, 2, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(11, 3, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(12, 3, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(13, 3, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(14, 3, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(15, 3, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(16, 4, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(17, 4, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(18, 4, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(19, 4, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(20, 4, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(21, 5, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(22, 5, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(23, 5, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(24, 5, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(25, 5, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(26, 6, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(27, 6, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(28, 6, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(29, 6, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(30, 6, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(31, 7, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(32, 7, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(33, 7, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(34, 7, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(35, 7, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(36, 8, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(37, 8, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(38, 8, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(39, 8, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(40, 8, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(41, 9, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(42, 9, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(43, 9, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(44, 9, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(45, 9, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স'),
(46, 10, 'মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12'),
(47, 10, 'প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট'),
(48, 10, 'ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন'),
(49, 10, 'ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন'),
(50, 10, 'জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স');

-- --------------------------------------------------------

--
-- Table structure for table `course_projects`
--

CREATE TABLE `course_projects` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_projects`
--

INSERT INTO `course_projects` (`id`, `course_id`, `title`, `image`, `description`) VALUES
(1, 1, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(2, 1, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(3, 1, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(4, 2, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(5, 2, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(6, 2, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(7, 3, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(8, 3, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(9, 3, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(10, 4, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(11, 4, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(12, 4, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(13, 5, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(14, 5, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(15, 5, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(16, 6, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(17, 6, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(18, 6, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(19, 7, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(20, 7, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(21, 7, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(22, 8, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(23, 8, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(24, 8, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(25, 9, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(26, 9, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(27, 9, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(28, 10, 'ই-কমার্স প্ল্যাটফর্ম', 'uploads/courses/course_1.jpg', NULL),
(29, 10, 'ম্যানেজমেন্ট সিস্টেম', 'uploads/courses/course_2.jpg', NULL),
(30, 10, 'সোশ্যাল মিডিয়া অ্যাপ', 'uploads/courses/course_3.jpg', NULL),
(31, 10, 'laravbel', 'uploads/projects/1774246621_graphicsd.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_reviews`
--

CREATE TABLE `course_reviews` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_sections`
--

CREATE TABLE `course_sections` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_sections`
--

INSERT INTO `course_sections` (`id`, `course_id`, `title`, `order_index`, `created_at`) VALUES
(1, 10, 'Module 1: Foundations', 1, '2026-03-22 17:27:15'),
(2, 10, 'Module 2: Foundations', 2, '2026-03-22 17:27:16'),
(3, 4, 'Module 1: Foundations', 1, '2026-03-22 17:27:18'),
(4, 4, 'Module 2: Foundations', 2, '2026-03-22 17:27:19'),
(5, 7, 'Module 1: Foundations', 1, '2026-03-22 17:27:19'),
(6, 7, 'Module 2: Foundations', 2, '2026-03-22 17:27:20'),
(7, 6, 'Module 1: Foundations', 1, '2026-03-22 17:27:21'),
(8, 6, 'Module 2: Foundations', 2, '2026-03-22 17:27:21'),
(9, 9, 'Module 1: Foundations', 1, '2026-03-22 17:27:23'),
(10, 9, 'Module 2: Foundations', 2, '2026-03-22 17:27:24'),
(11, 2, 'Module 1: Foundations', 1, '2026-03-22 17:27:24'),
(12, 2, 'Module 2: Foundations', 2, '2026-03-22 17:27:25'),
(13, 8, 'Module 1: Foundations', 1, '2026-03-22 17:27:26'),
(14, 8, 'Module 2: Foundations', 2, '2026-03-22 17:27:27'),
(15, 1, 'Module 1: Foundations', 1, '2026-03-22 17:27:27'),
(16, 1, 'Module 2: Foundations', 2, '2026-03-22 17:27:28'),
(17, 3, 'Module 1: Foundations', 1, '2026-03-22 17:27:29'),
(18, 3, 'Module 2: Foundations', 2, '2026-03-22 17:27:30'),
(19, 5, 'Module 1: Foundations', 1, '2026-03-22 17:27:31'),
(20, 5, 'Module 2: Foundations', 2, '2026-03-22 17:27:33'),
(21, 10, 'varialb', 0, '2026-03-23 03:17:58');

-- --------------------------------------------------------

--
-- Table structure for table `course_testimonials`
--

CREATE TABLE `course_testimonials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `student_role` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `rating` int(11) DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_testimonials`
--

INSERT INTO `course_testimonials` (`id`, `course_id`, `student_name`, `student_role`, `comment`, `rating`) VALUES
(1, 1, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(2, 1, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(3, 2, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(4, 2, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(5, 3, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(6, 3, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(7, 4, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(8, 4, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(9, 5, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(10, 5, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(11, 6, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(12, 6, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(13, 7, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(14, 7, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(15, 8, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(16, 8, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(17, 9, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(18, 9, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5),
(19, 10, 'জাহিদ হাসান', 'সফটওয়্যার ইঞ্জিনিয়ার', 'অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!', 5),
(20, 10, 'আরিফুল ইসলাম', 'স্টুডেন্ট', 'কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।', 5);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `payment_status` enum('pending','completed','refunded') DEFAULT 'pending',
  `progress_percent` int(11) DEFAULT 0,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `batch_id`, `payment_status`, `progress_percent`, `enrollment_date`) VALUES
(1, 3, 5, 10, 'completed', 0, '2026-03-22 17:29:07'),
(2, 5, 9, 5, 'completed', 0, '2026-03-22 17:47:48'),
(3, 8, 9, 5, 'completed', 50, '2026-03-23 03:55:43'),
(4, 8, 8, NULL, 'completed', 50, '2026-03-23 04:36:45'),
(5, 8, 10, NULL, 'completed', 0, '2026-03-23 04:42:47'),
(6, 5, 10, NULL, 'completed', 0, '2026-03-23 05:09:06'),
(7, 10, 1, NULL, 'completed', 0, '2026-03-23 08:18:14'),
(8, 10, 8, NULL, 'completed', 0, '2026-03-23 16:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `hero_slides`
--

CREATE TABLE `hero_slides` (
  `id` int(11) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `btn_text` varchar(100) DEFAULT NULL,
  `btn_link` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hero_slides`
--

INSERT INTO `hero_slides` (`id`, `subtitle`, `title`, `description`, `image`, `btn_text`, `btn_link`, `status`, `created_at`) VALUES
(1, 'Best Online Courses', 'The Best Online Learning Platform', 'Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam no.', 'frontend-template/img/carousel-1.jpg', 'courses', 'courses.php', 'active', '2026-03-23 17:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `home_partners`
--

CREATE TABLE `home_partners` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `home_partners`
--

INSERT INTO `home_partners` (`id`, `name`, `logo`, `status`, `created_at`) VALUES
(1, 'Wegro', 'https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg', 'active', '2026-03-23 16:17:30'),
(2, 'Singularity', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_Logo.svg/1200px-Google_%22G%22_Logo.svg.png', 'active', '2026-03-23 16:17:30'),
(3, 'PriyoShop', 'https://priyoshop.com/images/priyoshop-logo.png', 'active', '2026-03-23 16:17:30'),
(4, 'AyyKor', 'https://ayykor.com/assets/img/logo.png', 'active', '2026-03-23 16:17:30'),
(5, 'Audacity', 'https://audacityit.com/wp-content/uploads/2020/02/audacity-logo-white.png', 'active', '2026-03-23 16:17:30'),
(6, 'Bongo', 'https://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_TV_2015.png', 'active', '2026-03-23 16:17:30'),
(7, 'Fashol', 'uploads/partners/1774283569_69c16b3114326.webp', 'active', '2026-03-23 16:17:30'),
(8, 'GoZayaan', 'uploads/partners/1774283554_69c16b225ddeb.webp', 'active', '2026-03-23 16:17:30'),
(9, 'Pickaboo', 'uploads/partners/1774283534_69c16b0ede3b4.webp', 'active', '2026-03-23 16:17:30');

-- --------------------------------------------------------

--
-- Table structure for table `image_gallery`
--

CREATE TABLE `image_gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image_gallery`
--

INSERT INTO `image_gallery` (`id`, `title`, `image`, `status`, `created_at`) VALUES
(1, 'Interactive Learning Session', 'frontend-template/img/course-1.jpg', 'active', '2026-03-23 14:37:30'),
(2, 'Graduation Ceremony 2026', 'frontend-template/img/course-2.jpg', 'active', '2026-03-23 14:37:30'),
(3, 'Corporate Training Workshop', 'frontend-template/img/course-3.jpg', 'active', '2026-03-23 14:37:30'),
(4, 'Web Design Mastery Class', 'frontend-template/img/course-1.jpg', 'active', '2026-03-23 14:37:30'),
(5, 'Digital Marketing Success', 'frontend-template/img/course-2.jpg', 'active', '2026-03-23 14:37:30'),
(6, 'Mobile App Launch Event', 'frontend-template/img/course-3.jpg', 'active', '2026-03-23 14:37:30'),
(7, 'Python For Beginners Workshop', 'frontend-template/img/course-1.jpg', 'active', '2026-03-23 14:37:30'),
(8, 'UI/UX Design Studio Session', 'frontend-template/img/course-2.jpg', 'active', '2026-03-23 14:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `resume_url` varchar(255) DEFAULT NULL,
  `status` enum('applied','shortlisted','rejected','hired') DEFAULT 'applied',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job_partners`
--

CREATE TABLE `job_partners` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `job_type` enum('full_time','part_time','internship','remote') DEFAULT 'full_time',
  `status` enum('open','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content_type` enum('video','pdf','text','quiz') DEFAULT 'video',
  `content_url` text DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `section_id`, `title`, `content_type`, `content_url`, `duration`, `order_index`, `created_at`) VALUES
(1, 1, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:15'),
(2, 1, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:16'),
(3, 1, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:16'),
(4, 2, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:17'),
(5, 2, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:17'),
(6, 2, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:18'),
(7, 3, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:18'),
(8, 3, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:18'),
(9, 3, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:18'),
(10, 4, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:19'),
(11, 4, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:19'),
(12, 4, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:19'),
(13, 5, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:19'),
(14, 5, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:20'),
(15, 5, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:20'),
(16, 6, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:20'),
(17, 6, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:20'),
(18, 6, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:21'),
(19, 7, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:21'),
(20, 7, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:21'),
(21, 7, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:21'),
(22, 8, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:22'),
(23, 8, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:22'),
(24, 8, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:22'),
(25, 9, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:23'),
(26, 9, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:23'),
(27, 9, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:23'),
(28, 10, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:24'),
(29, 10, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:24'),
(30, 10, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:24'),
(31, 11, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:24'),
(32, 11, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:25'),
(33, 11, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:25'),
(34, 12, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:25'),
(35, 12, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:26'),
(36, 12, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:26'),
(37, 13, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:26'),
(38, 13, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:26'),
(39, 13, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:27'),
(40, 14, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:27'),
(41, 14, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:27'),
(42, 14, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:27'),
(43, 15, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:28'),
(44, 15, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:28'),
(45, 15, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:28'),
(46, 16, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:29'),
(47, 16, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:29'),
(48, 16, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:29'),
(49, 17, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:30'),
(50, 17, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:30'),
(51, 17, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:30'),
(52, 18, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:31'),
(53, 18, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:31'),
(54, 18, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:31'),
(55, 19, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:32'),
(56, 19, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:32'),
(57, 19, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:33'),
(58, 20, 'Lesson 1: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 1, '2026-03-22 17:27:33'),
(59, 20, 'Lesson 2: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 2, '2026-03-22 17:27:33'),
(60, 20, 'Lesson 3: Getting Started', 'video', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '10:00', 3, '2026-03-22 17:27:34'),
(61, 21, 'Elit odio quas esse', 'text', 'Incidunt id volupta', 'Delectus ipsum dolo', 0, '2026-03-23 03:18:14'),
(62, 21, 'Qui numquam eveniet', 'pdf', 'Ratione est sed est ', 'Rerum dolorem omnis', 0, '2026-03-23 03:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_bookmarks`
--

CREATE TABLE `lesson_bookmarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_notes`
--

CREATE TABLE `lesson_notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `status` enum('completed','in_progress') DEFAULT 'completed',
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `user_id`, `course_id`, `lesson_id`, `status`, `completed_at`) VALUES
(1, 8, 9, 25, 'completed', '2026-03-23 03:56:01'),
(2, 8, 9, 26, 'completed', '2026-03-23 03:56:16'),
(3, 8, 9, 27, 'completed', '2026-03-23 03:56:29'),
(4, 8, 8, 37, 'completed', '2026-03-23 04:37:06'),
(5, 8, 8, 38, 'completed', '2026-03-23 04:37:12'),
(6, 8, 8, 41, 'completed', '2026-03-23 04:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `live_classes`
--

CREATE TABLE `live_classes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `zoom_link` text DEFAULT NULL,
  `recording_url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `live_classes`
--

INSERT INTO `live_classes` (`id`, `course_id`, `batch_id`, `title`, `instructor_id`, `start_time`, `end_time`, `zoom_link`, `recording_url`, `created_at`) VALUES
(1, 1, 8, 'Orientation Session', 1, '2026-03-24 17:57:44', '2026-03-24 19:57:44', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:57:44'),
(2, 1, 8, 'Orientation Session', 1, '2026-03-24 17:59:03', '2026-03-24 19:59:03', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:03'),
(3, 2, 6, 'Orientation Session', 1, '2026-03-24 17:59:07', '2026-03-24 19:59:07', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:07'),
(4, 3, 9, 'Orientation Session', 1, '2026-03-24 17:59:08', '2026-03-24 19:59:08', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:08'),
(5, 4, 2, 'Orientation Session', 1, '2026-03-24 17:59:08', '2026-03-24 19:59:08', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:08'),
(6, 5, 10, 'Orientation Session', 1, '2026-03-24 17:59:09', '2026-03-24 19:59:09', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:09'),
(7, 6, 4, 'Orientation Session', 1, '2026-03-24 17:59:10', '2026-03-24 19:59:10', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:10'),
(8, 7, 3, 'Orientation Session', 1, '2026-03-24 17:59:11', '2026-03-24 19:59:11', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:11'),
(9, 8, 7, 'Orientation Session', 1, '2026-03-24 17:59:11', '2026-03-24 19:59:11', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:11'),
(10, 9, 5, 'Orientation Session', 1, '2026-03-24 17:59:12', '2026-03-24 19:59:12', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:12'),
(11, 10, 1, 'Orientation Session', 1, '2026-03-24 17:59:13', '2026-03-24 19:59:13', 'https://zoom.us/abc-def', NULL, '2026-03-22 17:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `live_class_attendance`
--

CREATE TABLE `live_class_attendance` (
  `id` int(11) NOT NULL,
  `live_class_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `login_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `user_id`, `ip_address`, `user_agent`, `login_at`) VALUES
(1, 11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 03:41:49'),
(2, 11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 03:42:20'),
(3, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 03:51:24'),
(4, 8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 03:55:28'),
(5, 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 04:55:22'),
(6, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 06:15:47'),
(7, 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-23 08:17:24'),
(8, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-24 16:38:46'),
(9, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 16:46:21');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_settings`
--

CREATE TABLE `newsletter_settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) DEFAULT 'Newsletter',
  `subtitle` varchar(255) DEFAULT 'Subscribe to our newsletter',
  `background_img` varchar(255) DEFAULT 'frontend-template/img/carousel-1.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `newsletter_settings`
--

INSERT INTO `newsletter_settings` (`id`, `title`, `subtitle`, `background_img`) VALUES
(1, 'Newsletter', 'Subscribe to our newsletter', 'frontend-template/img/carousel-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `type` enum('info','reminder','system','success','warning') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `method` enum('sslcommerz','bkash','nagad','card','free') DEFAULT 'bkash',
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','success','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `course_id`, `amount`, `method`, `transaction_id`, `status`, `created_at`) VALUES
(1, 8, 8, '30.99', 'bkash', 'TXN-1774240605', 'success', '2026-03-23 04:36:46'),
(2, 8, 10, '15.50', 'sslcommerz', 'TXN-1774240967', 'success', '2026-03-23 04:42:48'),
(3, 5, 10, '30.99', 'sslcommerz', 'TXN-1774242546', 'success', '2026-03-23 05:09:06'),
(4, 10, 1, '47.99', 'sslcommerz', 'TXN-1774253894', 'success', '2026-03-23 08:18:15'),
(5, 10, 8, '30.99', 'sslcommerz', 'TXN-1774282125', 'success', '2026-03-23 16:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `module` varchar(50) DEFAULT 'general',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `module`, `created_at`) VALUES
(1, 'Manage Courses', 'manage_courses', 'courses', '2026-03-22 17:38:10'),
(2, 'Manage Users', 'manage_users', 'users', '2026-03-22 17:38:11'),
(3, 'Manage Batches', 'manage_batches', 'courses', '2026-03-22 17:38:11'),
(4, 'View Own Courses', 'view_my_courses', 'learner', '2026-03-22 17:38:11'),
(5, 'Enroll in Courses', 'enroll_courses', 'learner', '2026-03-22 17:38:11'),
(6, 'Manage Categories', 'manage_categories', 'courses', '2026-03-22 17:38:11'),
(7, 'Access Admin Dashboard', 'access_admin_panel', 'admin', '2026-03-22 17:38:11'),
(8, 'Manage Roles & Permissions', 'manage_rbac', 'admin', '2026-03-22 17:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `platform_benefits`
--

CREATE TABLE `platform_benefits` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platform_benefits`
--

INSERT INTO `platform_benefits` (`id`, `title`, `icon`) VALUES
(1, 'ইন্ডাস্ট্রি এক্সপার্ট মেন্টরদের গাইডলাইন', 'fa-users'),
(2, 'রিয়েল-লাইফ প্রজেক্ট ও প্র্যাকটিক্যাল লার্নিং', 'fa-code'),
(3, 'ইন্ডাস্ট্রি রিলেভেন্ট স্কিলস ডেভেলপমেন্ট', 'fa-graduation-cap'),
(4, 'বেস্ট কোর্স আউটলাইন', 'fa-list-ul'),
(5, 'ক্যারিয়ার পাথ বেইজড সাপোর্ট সেশন', 'fa-headset'),
(6, 'জব প্লেসমেন্ট সাপোর্ট', 'fa-briefcase'),
(7, 'টেকনিক্যাল সাপোর্ট', 'fa-tools'),
(8, 'ইন্টার্নশিপ ও চাকরির সুযোগ', 'fa-handshake-o'),
(9, 'অ্যাফোর্ডেবল প্রাইসে লার্নিং', 'fa-tag'),
(10, 'লাইফটাইম লার্নিং অ্যাক্সেস', 'fa-infinity');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_questions` int(11) DEFAULT 0,
  `time_limit_minutes` int(11) DEFAULT 30,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `batch_id`, `title`, `description`, `total_questions`, `time_limit_minutes`, `status`, `created_at`) VALUES
(1, 1, 8, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:06'),
(2, 2, 6, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:07'),
(3, 3, 9, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:08'),
(4, 4, 2, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:09'),
(5, 5, 10, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:10'),
(6, 6, 4, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:10'),
(7, 7, 3, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:11'),
(8, 8, 7, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:12'),
(9, 9, 5, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:12'),
(10, 10, 1, 'Weekly Mid-Term Quiz', 'Test your knowledge of the first two modules.', 2, 30, 'published', '2026-03-22 17:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_options`
--

CREATE TABLE `quiz_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`options`)),
  `correct_answer` varchar(255) NOT NULL,
  `marks` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question_text`, `options`, `correct_answer`, `marks`) VALUES
(1, 1, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(2, 1, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(3, 2, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(4, 2, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(5, 3, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(6, 3, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(7, 4, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(8, 4, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(9, 5, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(10, 5, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(11, 6, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(12, 6, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(13, 7, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(14, 7, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(15, 8, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(16, 8, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(17, 9, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(18, 9, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1),
(19, 10, 'What is the primary goal of this course?', '[\"Mastery\",\"Basics\",\"Fun\",\"Certification\"]', 'Mastery', 1),
(20, 10, 'Which module covers advanced topics?', '[\"Module 1\",\"Module 2\",\"Module 3\",\"Module 4\"]', 'Module 2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `total_marks` int(11) DEFAULT 0,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `quiz_id`, `user_id`, `score`, `total_marks`, `completed_at`) VALUES
(1, 9, 5, 1, 2, '2026-03-22 18:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`) VALUES
(1, 'Admin', 'admin', 'Full platform access', '2026-03-22 17:38:10'),
(2, 'Instructor', 'instructor', 'Manage courses and curriculum', '2026-03-22 17:38:10'),
(3, 'Learner', 'learner', 'Access enrolled courses', '2026-03-22 17:38:10'),
(4, 'Corporate', 'corporate', 'Business level access', '2026-03-22 17:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `site_features`
--

CREATE TABLE `site_features` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_features`
--

INSERT INTO `site_features` (`id`, `title`, `icon`, `description`, `created_at`) VALUES
(1, 'Beatae incidunt mol', 'fa-solid fa-house', 'Commodi quaerat volu', '2026-03-23 07:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `site_stats`
--

CREATE TABLE `site_stats` (
  `id` int(11) NOT NULL DEFAULT 1,
  `courses_count` varchar(50) DEFAULT '182',
  `learners_count` varchar(50) DEFAULT '152,347',
  `materials_count` varchar(50) DEFAULT '21,766',
  `instructors_count` varchar(50) DEFAULT '350',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_stats`
--

INSERT INTO `site_stats` (`id`, `courses_count`, `learners_count`, `materials_count`, `instructors_count`, `updated_at`) VALUES
(1, '182', '152,347', '21,766', '350', '2026-03-23 15:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `marks` int(11) DEFAULT 0,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `created_at`) VALUES
(1, 'sujonmia100095@gmail.com', '2026-03-23 15:06:17'),
(2, 'jahidhasanofficial23@gmail.com', '2026-03-23 15:06:49'),
(3, 'jahidhasanoffic5ial23@gmail.com', '2026-03-23 15:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `success_stories`
--

CREATE TABLE `success_stories` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `course_info` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `success_stories`
--

INSERT INTO `success_stories` (`id`, `student_name`, `course_info`, `thumbnail`, `video_url`, `status`, `created_at`) VALUES
(1, 'Priyabrata Chowdhury', 'Web Dev Batch - 11', 'frontend-template/img/course-1.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'active', '2026-03-23 13:46:30'),
(2, 'Anamika Abedin', 'UI/UX Design Batch - 2', 'frontend-template/img/course-2.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'active', '2026-03-23 13:46:30'),
(3, 'Md Jawadul Karim', 'UI/UX Design Batch - 2', 'frontend-template/img/course-3.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'active', '2026-03-23 13:46:30'),
(4, 'Mariya Sharmin', 'Data Analytics Batch - 2', 'frontend-template/img/course-1.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'active', '2026-03-23 13:46:30'),
(5, 'KM Nurunnabi', 'Laravel Batch - 1', 'frontend-template/img/course-2.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'active', '2026-03-23 13:46:30'),
(6, 'Mahmudul Haque Shawon', 'Python Django Batch - 10', 'frontend-template/img/course-3.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'active', '2026-03-23 13:46:30'),
(7, 'Sumaiya Akter', 'Graphic Design Batch - 04', 'frontend-template/img/course-1.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'active', '2026-03-23 13:46:30'),
(8, 'Tanvir Ahmed', 'Cyber Security Batch - 01', 'frontend-template/img/course-2.jpg', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'active', '2026-03-23 13:46:30'),
(9, 'Nabila Islam', 'Digital Marketing Batch - 08', 'frontend-template/img/course-3.jpg', 'https://www.youtube.com/watch?v=dQw4w9XcQ', 'active', '2026-03-23 13:46:30'),
(10, 'Sajid Hasan', 'App Development Batch - 03', 'frontend-template/img/course-1.jpg', 'https://www.youtube.com/watch?v=dQw4w9XcQ', 'active', '2026-03-23 13:46:30'),
(11, 'Jahid', 'Advanced Course 6 - Batch 1', 'uploads/stories/1774274311_69c147074dd73.webp', 'https://www.youtube.com/watch?v=jITSKG2t3VM', 'active', '2026-03-23 13:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('open','closed','in_progress') DEFAULT 'open',
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `subject`, `message`, `status`, `assigned_to`, `created_at`) VALUES
(1, 8, 'testing', 'dssdf', 'in_progress', NULL, '2026-03-23 04:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `specializations` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `work_experience` text DEFAULT NULL,
  `work_places` text DEFAULT NULL,
  `training_experience` varchar(255) DEFAULT NULL,
  `total_students` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `designation`, `specializations`, `education`, `work_experience`, `work_places`, `training_experience`, `total_students`, `image`, `status`, `created_at`) VALUES
(1, 'Anthony Frost', 'Itaque quaerat quia', 'Voluptatem consecte\r\nLaborum voluptatum m\r\nLaborum voluptatum m', 'Laborum voluptatum m\r\nLaborum voluptatum m', 'Officia tempore ear\r\n\r\nLaborum voluptatum m\r\nLaborum voluptatum m', 'Cumque saepe consequ, el, sr', '4 years', '250+', 'uploads/team/1774457542_69c412c619581.webp', 'active', '2026-03-25 16:52:22');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `user_id`, `student_name`, `profession`, `feedback`, `image`, `status`, `created_at`) VALUES
(1, 10, 'Trainer 10', 'Student of Advanced Course 1', 'Your profile picture and name will be automatically taken from your account settings.', 'uploads/profiles/1774255132_testimonial-2.jpg', 'active', '2026-03-23 08:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','instructor','learner','corporate') DEFAULT 'learner',
  `profile_pic` varchar(255) DEFAULT 'default_user.png',
  `bio` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `otp_code` varchar(10) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_id` int(11) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `linkedin_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `profile_pic`, `bio`, `skills`, `status`, `otp_code`, `is_verified`, `created_at`, `updated_at`, `role_id`, `google_id`, `facebook_id`, `linkedin_id`) VALUES
(1, 'Trainer 1', 'trainer1@example.com', '', '$2y$10$uF2kaQ0eaKOfJKnStGSnHuIvj8ggl3OwdsnmFj9Y2jGaPdihIsYv2', 'admin', 'uploads/profiles/1774240282_laravel-el.jpg', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', '', 'active', NULL, 0, '2026-03-22 17:26:45', '2026-03-23 04:31:22', 1, NULL, NULL, NULL),
(2, 'Trainer 2', 'trainer2@example.com', NULL, '$2y$10$wC2pDQeY5kU2ncYwoUdcH.nWfXfaVJVTMkNGt.OK/vasmyR3Y4gv2', 'instructor', 'default_user.png', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', NULL, 'active', NULL, 0, '2026-03-22 17:26:46', '2026-03-22 17:38:12', 2, NULL, NULL, NULL),
(3, 'Trainer 3', 'trainer3@example.com', NULL, '$2y$10$GYvPEav45mWB94ADW.Yrvu.f8AKP7Udpyln9h0RyeGKAkvyxmzfl6', 'instructor', 'default_user.png', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', NULL, 'active', NULL, 0, '2026-03-22 17:26:47', '2026-03-22 17:38:12', 2, NULL, NULL, NULL),
(4, 'Trainer 4', 'trainer4@example.com', NULL, '$2y$10$uh7HGcmCt8MJ.Rj9FD23peredry3irvDkgJshoL42gEKHb7yqRwki', 'instructor', 'default_user.png', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', NULL, 'active', NULL, 0, '2026-03-22 17:26:47', '2026-03-22 17:38:12', 2, NULL, NULL, NULL),
(5, 'Trainer 5', 'trainer5@example.com', NULL, '$2y$10$EPMcL5hNNd9SaCnUItbmu.VMtIQ7ynoH2ye.qtkSDPkRiDplQSphK', 'learner', 'default_user.png', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', NULL, 'active', NULL, 0, '2026-03-22 17:26:47', '2026-03-22 17:38:12', 3, NULL, NULL, NULL),
(6, 'Trainer 6', 'trainer6@example.com', NULL, '$2y$10$V.oVc/ihtRVKRNVdMQBKRup0Iv5BU21KkGdPhzgtByhIgyH7uYdcC', 'admin', 'default_user.png', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', NULL, 'active', NULL, 0, '2026-03-22 17:26:47', '2026-03-22 17:38:12', 1, NULL, NULL, NULL),
(7, 'Trainer 7', 'trainer7@example.com', NULL, '$2y$10$w9uU9kDlGomcYo0O8tz/wuhxgZYt/Jrm7nSJtIKpxD3KLQlK8f10y', 'admin', 'default_user.png', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', NULL, 'active', NULL, 0, '2026-03-22 17:26:48', '2026-03-22 17:38:12', 1, NULL, NULL, NULL),
(8, 'Trainer 8', 'trainer8@example.com', NULL, '$2y$10$7AO.9auONDDS0LcXffI7yegAf2q5MStpikmUVTK6kJUCR8z8Phz/G', 'learner', 'default_user.png', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', NULL, 'active', NULL, 0, '2026-03-22 17:26:48', '2026-03-22 17:38:12', 3, NULL, NULL, NULL),
(9, 'Trainer 9', 'trainer9@example.com', NULL, '$2y$10$mHGiPjH9sDH6gf3xCFjcdeOfQntaNvRWSZsvgUfJIPK3lGU.W4Uv6', 'admin', 'default_user.png', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', NULL, 'active', NULL, 0, '2026-03-22 17:26:48', '2026-03-22 17:38:12', 1, NULL, NULL, NULL),
(10, 'Trainer 10', 'trainer10@example.com', '', '$2y$10$HCiD1qDJOhvb6ebsLy1YH.oCFbcrg.DIW33eG0HP9rDTefQsJvYwO', 'learner', 'uploads/profiles/1774255132_testimonial-2.jpg', 'Expert with over 8 years of experience in the industry. Specialized in modern teaching methodologies and hands-on practical training.', '', 'active', NULL, 0, '2026-03-22 17:26:48', '2026-03-23 08:38:52', 3, NULL, NULL, NULL),
(11, 'John Doe (Google)', 'john.google@example.com', NULL, '', 'learner', 'default_user.png', NULL, NULL, 'active', NULL, 1, '2026-03-23 03:41:49', '2026-03-25 16:49:57', 3, '12345', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `fk_assign_batch` (`batch_id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_blog_like` (`blog_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `consultation_requests`
--
ALTER TABLE `consultation_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `course_faqs`
--
ALTER TABLE `course_faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_features`
--
ALTER TABLE `course_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course_outcomes`
--
ALTER TABLE `course_outcomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_projects`
--
ALTER TABLE `course_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_reviews`
--
ALTER TABLE `course_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_testimonials`
--
ALTER TABLE `course_testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `hero_slides`
--
ALTER TABLE `hero_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_partners`
--
ALTER TABLE `home_partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_gallery`
--
ALTER TABLE `image_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `job_partners`
--
ALTER TABLE `job_partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `lesson_bookmarks`
--
ALTER TABLE `lesson_bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `lesson_notes`
--
ALTER TABLE `lesson_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`lesson_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `live_classes`
--
ALTER TABLE `live_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `fk_live_batch` (`batch_id`);

--
-- Indexes for table `live_class_attendance`
--
ALTER TABLE `live_class_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `live_class_id` (`live_class_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `newsletter_settings`
--
ALTER TABLE `newsletter_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `platform_benefits`
--
ALTER TABLE `platform_benefits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `site_features`
--
ALTER TABLE `site_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_stats`
--
ALTER TABLE `site_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `success_stories`
--
ALTER TABLE `success_stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_likes`
--
ALTER TABLE `blog_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultation_requests`
--
ALTER TABLE `consultation_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `course_faqs`
--
ALTER TABLE `course_faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `course_features`
--
ALTER TABLE `course_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `course_instructors`
--
ALTER TABLE `course_instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `course_outcomes`
--
ALTER TABLE `course_outcomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `course_projects`
--
ALTER TABLE `course_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `course_reviews`
--
ALTER TABLE `course_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_sections`
--
ALTER TABLE `course_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `course_testimonials`
--
ALTER TABLE `course_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hero_slides`
--
ALTER TABLE `hero_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `home_partners`
--
ALTER TABLE `home_partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `image_gallery`
--
ALTER TABLE `image_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_partners`
--
ALTER TABLE `job_partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `lesson_bookmarks`
--
ALTER TABLE `lesson_bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lesson_notes`
--
ALTER TABLE `lesson_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `live_classes`
--
ALTER TABLE `live_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `live_class_attendance`
--
ALTER TABLE `live_class_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `platform_benefits`
--
ALTER TABLE `platform_benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quiz_options`
--
ALTER TABLE `quiz_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `site_features`
--
ALTER TABLE `site_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `success_stories`
--
ALTER TABLE `success_stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assign_batch` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD CONSTRAINT `blog_likes_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_faqs`
--
ALTER TABLE `course_faqs`
  ADD CONSTRAINT `course_faqs_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_features`
--
ALTER TABLE `course_features`
  ADD CONSTRAINT `course_features_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD CONSTRAINT `course_instructors_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_instructors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_outcomes`
--
ALTER TABLE `course_outcomes`
  ADD CONSTRAINT `course_outcomes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_projects`
--
ALTER TABLE `course_projects`
  ADD CONSTRAINT `course_projects_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_reviews`
--
ALTER TABLE `course_reviews`
  ADD CONSTRAINT `course_reviews_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD CONSTRAINT `course_sections_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_testimonials`
--
ALTER TABLE `course_testimonials`
  ADD CONSTRAINT `course_testimonials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_partners`
--
ALTER TABLE `job_partners`
  ADD CONSTRAINT `job_partners_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD CONSTRAINT `job_postings_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `job_partners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `course_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_bookmarks`
--
ALTER TABLE `lesson_bookmarks`
  ADD CONSTRAINT `lesson_bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_bookmarks_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_notes`
--
ALTER TABLE `lesson_notes`
  ADD CONSTRAINT `lesson_notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_notes_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_3` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `live_classes`
--
ALTER TABLE `live_classes`
  ADD CONSTRAINT `fk_live_batch` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `live_classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `live_classes_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `live_class_attendance`
--
ALTER TABLE `live_class_attendance`
  ADD CONSTRAINT `live_class_attendance_ibfk_1` FOREIGN KEY (`live_class_id`) REFERENCES `live_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `live_class_attendance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD CONSTRAINT `quiz_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD CONSTRAINT `refund_requests_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refund_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_tickets_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
