--
-- Table structure for table `#__test_profiles`
--

CREATE TABLE IF NOT EXISTS `#__test_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `fields` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `checked_out` int(10) unsigned NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci; 