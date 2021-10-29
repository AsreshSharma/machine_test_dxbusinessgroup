-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2021 at 02:48 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dxbusinessgroup`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_answers`
--

CREATE TABLE `tbl_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_ans` varchar(100) NOT NULL,
  `skip_ans` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_answers`
--

INSERT INTO `tbl_answers` (`id`, `user_id`, `question_id`, `user_ans`, `skip_ans`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Hypertext Preprocessor', '', '2021-10-23 12:46:09', '2021-10-23 12:46:09'),
(2, 1, 2, 'Rasmus Lerdrof', '', '2021-10-23 12:46:11', '2021-10-23 12:46:11'),
(3, 1, 3, '', '1', '2021-10-23 12:46:13', '2021-10-23 12:46:13'),
(4, 1, 4, '', '1', '2021-10-23 12:46:15', '2021-10-23 12:46:15'),
(5, 1, 5, 'Extern', '', '2021-10-23 12:46:21', '2021-10-23 12:46:21'),
(6, 1, 6, 'Both (b) and (c)', '', '2021-10-23 12:46:24', '2021-10-23 12:46:24'),
(7, 1, 7, 'write', '', '2021-10-23 12:46:27', '2021-10-23 12:46:27'),
(8, 1, 8, 'The strlen() function returns both value and type of string', '', '2021-10-23 12:46:30', '2021-10-23 12:46:30'),
(9, 1, 9, 'append()', '', '2021-10-23 12:46:33', '2021-10-23 12:46:33'),
(10, 1, 10, 'User-defined constants', '', '2021-10-23 12:46:38', '2021-10-23 12:46:38'),
(11, 1, 11, 'The strpos() function is used to search for a character/text in a string', '', '2021-10-23 12:46:42', '2021-10-23 12:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE `tbl_question` (
  `id` int(11) NOT NULL,
  `question` longtext NOT NULL,
  `option1` varchar(100) NOT NULL,
  `option2` varchar(100) NOT NULL,
  `option3` varchar(100) NOT NULL,
  `option4` varchar(100) NOT NULL,
  `ans_option` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `ans_option`, `created_at`, `updated_at`) VALUES
(1, ' PHP stands for -', 'Hypertext Preprocessor', 'Pretext Hypertext Preprocessor', 'Personal Home Processor', 'None of the above', 'Hypertext Preprocessor', '2021-10-23 09:21:25', '2021-10-23 09:21:25'),
(2, 'Who is known as the father of PHP?', 'Drek Kolkevi', 'List Barely', 'Rasmus Lerdrof', 'None of the above', 'Rasmus Lerdrof', '2021-10-23 09:21:25', '2021-10-23 09:21:25'),
(3, 'Variable name in PHP starts with -', '! (Exclamation)', '$ (Dollar)', '& (Ampersand)', '# (Hash)', '$ (Dollar)', '2021-10-23 09:26:12', '2021-10-23 09:26:12'),
(4, 'Which of the following is the default file extension of PHP?', '.php', '.hphp', '.xml', '.html', '.php', '2021-10-23 09:26:12', '2021-10-23 09:26:12'),
(5, 'Which of the following is not a variable scope in PHP?', 'Extern', 'Local', 'Static', 'Global', 'Extern', '2021-10-23 09:33:15', '2021-10-23 09:33:15'),
(6, 'Which of the following is correct to add a comment in php?', '& …… &', '// ……', '/* …… */', 'Both (b) and (c)', 'Both (b) and (c)', '2021-10-23 09:33:15', '2021-10-23 09:33:15'),
(7, 'Which of the following is used to display the output in PHP?', 'echo', 'write', 'print', 'Both (a) and (c)', 'Both (a) and (c)', '2021-10-23 09:33:15', '2021-10-23 09:33:15'),
(8, 'Which of the following is the use of strlen() function in PHP?', 'The strlen() function returns the type of string', 'The strlen() function returns the length of string', 'The strlen() function returns the value of string', 'The strlen() function returns both value and type of string', 'The strlen() function returns the length of string', '2021-10-23 09:33:15', '2021-10-23 09:33:15'),
(9, 'Which of the following is used for concatenation in PHP?', '+ (plus)', '* (Asterisk)', '. (dot)', 'append()', '. (dot)', '2021-10-23 09:33:15', '2021-10-23 09:33:15'),
(10, 'Which of the following starts with __ (double underscore) in PHP?', 'Inbuilt constants', 'User-defined constants', 'Magic constants', 'Default constants', 'Magic constants', '2021-10-23 09:33:15', '2021-10-23 09:33:15'),
(11, 'Which of the following is the use of strpos() function in PHP?', 'The strpos() function is used to search for the spaces in a string', 'The strpos() function is used to search for a number in a string', 'The strpos() function is used to search for a character/text in a string', 'The strpos() function is used to search for a capitalize character in a string', 'The strpos() function is used to search for a character/text in a string', '2021-10-23 09:34:14', '2021-10-23 09:34:14'),
(12, 'What does PEAR stands for?', 'PHP extension and application repository', 'PHP enhancement and application reduce', 'PHP event and application repository', 'None of the above', 'PHP extension and application repository', '2021-10-23 09:35:00', '2021-10-23 09:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_results`
--

CREATE TABLE `tbl_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `correct_ans` int(11) NOT NULL,
  `wrong_ans` int(11) NOT NULL,
  `skip_ans` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_results`
--

INSERT INTO `tbl_results` (`id`, `user_id`, `correct_ans`, `wrong_ans`, `skip_ans`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 4, 2, '2021-10-23 12:46:09', '2021-10-23 12:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_name`, `created_at`, `updated_at`) VALUES
(1, 'Asresh Sharma', '2021-10-23 12:45:42', '2021-10-23 12:45:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_answers`
--
ALTER TABLE `tbl_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_results`
--
ALTER TABLE `tbl_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_answers`
--
ALTER TABLE `tbl_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_question`
--
ALTER TABLE `tbl_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_results`
--
ALTER TABLE `tbl_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
