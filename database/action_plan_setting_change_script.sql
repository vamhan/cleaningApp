CREATE TABLE IF NOT EXISTS `tbm_visitation_reason` (
  `id` varchar(4) NOT NULL,
  `title` varchar(512) NOT NULL,
  `department_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbm_visitation_reason`
--

INSERT INTO `tbm_visitation_reason` (`id`, `title`, `department_id`) VALUES
('R001', 'แนะนำตัว', 1),
('R002', 'วัดพื้นที่', 1),
('R003', 'นำใบเสนอราคา', 1),
('R004', 'นำสัญญาไปให้', 1),
('R005', 'อื่นๆ', 1),
('R007', 'แก้ไขปัญหา', 2),
('R008', 'เข้าพบลูกค้าประจำเดือน', 2);

CREATE TABLE IF NOT EXISTS `tbt_keyuser_marked_assign` (
  `id` int(10) NOT NULL auto_increment,
  `keyuser_emp_id` varchar(15) collate utf8_unicode_ci NOT NULL,
  `contract_id` varchar(10) character set utf8 NOT NULL,
  `ship_to_id` varchar(10) character set utf8 NOT NULL,
  `month_period` float NOT NULL,
  `module_id` int(11) NOT NULL,
  `area_id` int(10) default NULL,
  `assign_to` varchar(15) collate utf8_unicode_ci NOT NULL,
  `assign_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

CREATE TABLE IF NOT EXISTS `tbt_user_marked` (
  `assign_id` int(10) NOT NULL,
  `emp_id` varchar(15) collate utf8_unicode_ci NOT NULL,
  `contract_id` varchar(10) character set utf8 NOT NULL,
  `ship_to_id` varchar(10) character set utf8 NOT NULL,
  `module_id` int(11) NOT NULL,
  `area_id` int(10) NOT NULL default '0',
  `sequence` int(11) NOT NULL,
  `action_plan_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`assign_id`,`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;