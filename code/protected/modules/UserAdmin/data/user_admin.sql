--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_superadmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `active`, `login`, `password`, `is_superadmin`) VALUES
(22, 1, 'superadmin', '33eeaa61c01b2f296e3df6f17951d0fb', 1),
(23, 1, 'admin', '7eea35b402bd0b2d301be479e769c02b', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_cache`
--

CREATE TABLE IF NOT EXISTS `user_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `is_guest` tinyint(1) NOT NULL,
  `update_time` int(11) NOT NULL,
  `routes` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;


-- --------------------------------------------------------

--
-- Table structure for table `user_has_user_role`
--

CREATE TABLE IF NOT EXISTS `user_has_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_role_code` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_role_code` (`user_role_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `user_has_user_role`
--

INSERT INTO `user_has_user_role` (`id`, `user_id`, `user_role_code`) VALUES
(24, 23, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_has_user_task`
--

CREATE TABLE IF NOT EXISTS `user_has_user_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_task_code` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_task_code` (`user_task_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_operation`
--

CREATE TABLE IF NOT EXISTS `user_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(255) NOT NULL,
  `is_module` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `route` (`route`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=652 ;

--
-- Dumping data for table `user_operation`
--

INSERT INTO `user_operation` (`id`, `route`, `is_module`) VALUES
(287, 'site/error', 0),
(374, 'UserAdmin/user/create', 1),
(375, 'UserAdmin/user/update', 1),
(376, 'UserAdmin/user/view', 1),
(383, 'UserAdmin/userRole/view', 1),
(392, 'UserAdmin/userTask/view', 1),
(393, 'UserAdmin/userTask/refreshOperations', 1),
(433, 'site/index', 0),
(435, 'UserAdmin/auth/login', 1),
(436, 'UserAdmin/auth/logout', 1),
(462, 'site/*', 0),
(466, 'UserAdmin/auth/*', 1),
(467, 'UserAdmin/user/*', 1),
(468, 'UserAdmin/userRole/*', 1),
(469, 'UserAdmin/userTask/*', 1),
(502, 'UserAdmin/auth/registration', 1),
(524, 'UserAdmin/userRole/update', 1),
(538, 'UserAdmin/profile/*', 1),
(539, 'UserAdmin/profile/personal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  `home_page` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `code`, `home_page`, `description`) VALUES
(2, 'Admin', 'admin', '', 'Full access to the main settings');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_has_user_task`
--

CREATE TABLE IF NOT EXISTS `user_role_has_user_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) NOT NULL,
  `user_task_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role_id` (`user_role_id`),
  KEY `user_task_id` (`user_task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

--
-- Dumping data for table `user_role_has_user_task`
--

INSERT INTO `user_role_has_user_task` (`id`, `user_role_id`, `user_task_id`) VALUES
(124, 2, 7),
(125, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `user_task`
--

CREATE TABLE IF NOT EXISTS `user_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_task`
--

INSERT INTO `user_task` (`id`, `name`, `code`, `description`) VALUES
(7, 'User management', 'userAdmin', 'It''s include creating, updating, deleting AND assigning roles and tasks to user'),
(8, 'User role management', 'userRoleAdmin', ''),
(10, '----- Free-for-all tasks ----', 'freeAccess', 'Tasks that can be performed by anyone. Like site/index and site/error');

-- --------------------------------------------------------

--
-- Table structure for table `user_task_has_user_operation`
--

CREATE TABLE IF NOT EXISTS `user_task_has_user_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_task_id` int(11) NOT NULL,
  `user_operation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_task_id` (`user_task_id`),
  KEY `user_operation_id` (`user_operation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=350 ;

--
-- Dumping data for table `user_task_has_user_operation`
--

INSERT INTO `user_task_has_user_operation` (`id`, `user_task_id`, `user_operation_id`) VALUES
(288, 7, 467),
(291, 8, 468),
(348, 10, 287),
(349, 10, 433);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_cache`
--
ALTER TABLE `user_cache`
  ADD CONSTRAINT `user_cache_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_has_user_role`
--
ALTER TABLE `user_has_user_role`
  ADD CONSTRAINT `user_has_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_has_user_role_ibfk_2` FOREIGN KEY (`user_role_code`) REFERENCES `user_role` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_has_user_task`
--
ALTER TABLE `user_has_user_task`
  ADD CONSTRAINT `user_has_user_task_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_has_user_task_ibfk_2` FOREIGN KEY (`user_task_code`) REFERENCES `user_task` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_role_has_user_task`
--
ALTER TABLE `user_role_has_user_task`
  ADD CONSTRAINT `user_role_has_user_task_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_has_user_task_ibfk_2` FOREIGN KEY (`user_task_id`) REFERENCES `user_task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_task_has_user_operation`
--
ALTER TABLE `user_task_has_user_operation`
  ADD CONSTRAINT `user_task_has_user_operation_ibfk_1` FOREIGN KEY (`user_task_id`) REFERENCES `user_task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_task_has_user_operation_ibfk_2` FOREIGN KEY (`user_operation_id`) REFERENCES `user_operation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
