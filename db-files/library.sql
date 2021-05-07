-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2021 at 04:12 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `age` varchar(11) NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`, `age`, `genre`) VALUES
(1, 'Vikram Seth', '68', 'novelist, poet'),
(2, 'Abu\'l-Fazl ibn Mubarak', 'Deceased', 'biography'),
(3, 'Philip Zimbardo', '87', 'psychologist'),
(4, 'Jane Austen', 'Deceased', 'poet, novelist'),
(5, 'J. M. Coetzee', '81', 'novelist, essayist, linguist');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `age_group` varchar(255) NOT NULL,
  `author_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book id`, `book_name`, `year`, `genre`, `age_group`, `author_id`) VALUES
(1, 'The Tale Of Melon City', 1981, 'Poetry', '16 and above', 1),
(2, 'The Humble Administrator\'s Garden', 1985, 'Poetry', '18 and above', 1),
(3, 'All You Who Sleep Tonight', 1990, 'Poetry', '18 and above', 1),
(4, 'Akbarnama', 2011, 'Biography', '18 and above', 2),
(5, 'The Cognitive Control of Motivation', 1969, 'Psychology', '18 and above', 3),
(6, 'Stanford prison experience: A simulation study of the psychology of inprisonment', 1972, 'Psychology', '18 and above', 3),
(7, 'Influencing Attitudes and Changing Behavior', 1969, 'Psychology', '18 and above', 3),
(8, 'Sense and Sensibility', 1811, 'Novel', '12 and above', 4),
(9, 'Pride and Prejudice', 1813, 'Novel', '14 and above', 4),
(10, 'Mansfield Park', 1814, 'Novel', 'Adult fiction', 4),
(11, 'Emma', 1815, 'Novel', 'Child fiction', 4),
(12, 'Northanger Abbey', 1818, 'Novel', 'Teenager fiction', 4),
(13, 'Persuasion', 1818, 'Novel', 'Adult fiction', 4),
(14, 'Lady Susan', 1871, 'Novel', 'Adult fiction', 4),
(15, 'The Childhood of Jesus', 2013, 'Novel', '12 to 15', 5),
(16, 'The Schooldays of Jesus', 2016, 'Novel', '8 to 10', 5),
(17, 'The Death of Jesus', 2019, 'Novel', '12 to 17', 5);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `membership` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `password`, `membership`) VALUES
(3, 'test', '235', 'Librarian'),
(4, 'test', '233', 'Librarian'),
(5, 'Eve', '885', 'Member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
