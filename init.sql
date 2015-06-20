-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 20, 2015 at 05:59 PM
-- Server version: 5.5.43-0ubuntu0.14.10.1
-- PHP Version: 5.5.12-2ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sarah`
--

-- --------------------------------------------------------

--
-- Table structure for table `xbmc_remote`
--

CREATE TABLE IF NOT EXISTS `xbmc_remote` (
`REMOTE_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `ip` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `xbmc_remote`
--
ALTER TABLE `xbmc_remote`
 ADD PRIMARY KEY (`REMOTE_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `xbmc_remote`
--
ALTER TABLE `xbmc_remote`
MODIFY `REMOTE_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;