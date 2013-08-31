--
-- Table structure for table `serverload`
--

CREATE TABLE IF NOT EXISTS `serverload` (
  `ip` varchar(45) NOT NULL,
  `datakey` varchar(64) NOT NULL,
  `datavalue` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;