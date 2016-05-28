CREATE TABLE IF NOT EXISTS `tbm_department` ( 	 	
`id` int(10) NOT NULL auto_increment, 	 	
`title` varchar(255) NOT NULL, 	 	
`parent_id` int(10) NOT NULL, 	 	
`function` enum('sales','operation') default NULL, 	 	
PRIMARY KEY  (`id`) 	 	
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ; 	 	
 	 	 	
CREATE TABLE IF NOT EXISTS `tbm_department_module` ( 	 	
  `department_id` int(10) NOT NULL, 	 	
  `module_id` int(10) NOT NULL, 	 	
  PRIMARY KEY  (`department_id`,`module_id`) 	 	
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 	 	

CREATE TABLE IF NOT EXISTS `tbm_group` ( 	 	
  `id` int(10) NOT NULL auto_increment, 	 	
  `title` varchar(255) NOT NULL, 	 	
  PRIMARY KEY  (`id`) 	 	
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ; 	 	

DROP TABLE IF EXISTS `tbm_job_type`;
CREATE TABLE IF NOT EXISTS `tbm_job_type` ( 
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(64) character set utf8 NOT NULL default '',	
  PRIMARY KEY  (`id`)	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; 

DROP TABLE IF EXISTS `tbm_keyuser_modules`;
CREATE TABLE IF NOT EXISTS `tbm_keyuser_modules` ( 
  `module_id` int(11) NOT NULL, 
  `keyuser_emp_id` varchar(15) character set utf8 NOT NULL,
  PRIMARY KEY  (`module_id`,`keyuser_emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; 

DROP TABLE IF EXISTS `tbm_not_visit_reason`;
CREATE TABLE IF NOT EXISTS `tbm_not_visit_reason` (
  `id` varchar(4) character set utf8 NOT NULL,
  `title` varchar(100) character set utf8 NOT NULL default '',
  `function` enum('sales','operation') character set utf8 default NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; 

DROP TABLE IF EXISTS `tbm_position`;
CREATE TABLE IF NOT EXISTS `tbm_position` (
  `id` int(10) NOT NULL,
  `title` varchar(64) collate utf8_general_ci NOT NULL default '',
  `department_id` int(10) NOT NULL, 	 	
  `area_id` varchar(10) collate utf8_general_ci NOT NULL, 	 	
  `group_id` int(10) default NULL, 	 	
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `tbm_quality_survey_area_question`;
CREATE TABLE IF NOT EXISTS `tbm_quality_survey_area_question` ( 	
  `id` int(10) NOT NULL auto_increment, 	
  `title` varchar(255) NOT NULL, 	
  `revision_id` int(10) NOT NULL default '1', 	
  `industry_room_id` varchar(4) NOT NULL,	 	 
  `sequence_index` int(10) NOT NULL, 	
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

DROP TABLE IF EXISTS `tbm_visitation_reason`;
CREATE TABLE IF NOT EXISTS `tbm_visitation_reason` ( 
  `id` varchar(4) NOT NULL, 
  `title` varchar(100) NOT NULL, 
  `function` enum('sales','operation') default NULL,
  `is_active` tinyint(1) NOT NULL, 
  PRIMARY KEY  (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbt_action_plan`;
CREATE TABLE IF NOT EXISTS `tbt_action_plan` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(512) NOT NULL,
  `event_category_id` int(5) NOT NULL,
  `actor_id` varchar(15) NOT NULL,
  `plan_date` date NOT NULL,
  `actual_date` date default NULL,
  `remark` varchar(765) NOT NULL,
  `visitation_reason_id` varchar(4) NOT NULL,
  `status` enum('plan','unplan','shift') NOT NULL,
  `is_holiday` tinyint(1) NOT NULL,
  `clear_job_category_id` int(5) NOT NULL,
  `clear_job_type_id` int(5) NOT NULL,
  `staff` int(2) NOT NULL,
  `total_staff` int(2) NOT NULL,
  `quotation_id` int(10) NOT NULL,
  `prospect_id` int(10) NOT NULL, 	 	
  `contract_id` varchar(10) NOT NULL,
  `ship_to_id` varchar(10) NOT NULL,
  `sold_to_id` varchar(10) NOT NULL,
  `holiday_id` int(5) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL,
  `create_date` date NOT NULL,
  `version` int(10) NOT NULL,
  `pre_id` int(11) default '0', 
  `object_table` varchar(255) NOT NULL, 
  `object_id` int(10) NOT NULL, 
  `is_manager` tinyint(1) default '0'
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;
ALTER TABLE  `tbt_action_plan` ADD  `clearjob_frequency` FLOAT NOT NULL AFTER  `clear_job_type_id` ;

DROP TABLE IF EXISTS `tbt_keyuser_marked_assign`;
CREATE TABLE IF NOT EXISTS `tbt_keyuser_marked_assign` ( 
  `id` int(10) NOT NULL auto_increment, 
  `keyuser_emp_id` varchar(15) character set utf8 NOT NULL,
  `contract_id` varchar(10) character set utf8 NOT NULL, 
  `ship_to_id` varchar(10) character set utf8 NOT NULL, 
  `month_period` float NOT NULL, 
  `module_id` int(11) NOT NULL, 
  `clear_job_type_id` varchar(4) default NULL, 
  `frequency` float default NULL, 
  `assign_to` varchar(15) character set utf8 NOT NULL,
  `assign_date` date NOT NULL, 
  PRIMARY KEY  (`id`) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=51 ;

DROP TABLE IF EXISTS `tbt_quality_survey`;
CREATE TABLE IF NOT EXISTS `tbt_quality_survey` ( 
  `id` int(10) NOT NULL auto_increment, 
  `title` varchar(512) character set utf8 NOT NULL default '',
  `status` enum('being','approved','complete') character set utf8 default NULL,
  `action_plan_id` int(10) NOT NULL, 
  `site_inspector_id` varchar(15) character set utf8 NOT NULL,
  `inspector_id` varchar(15) character set utf8 NOT NULL,
  `area` varchar(128) character set utf8 NOT NULL default '',
  `actual_date` date NOT NULL default '0000-00-00', 
  `project_id` int(10) NOT NULL, 
  `contract_id` varchar(10) character set utf8 NOT NULL, 
  `quotation_id` varchar(10) character set utf8 NOT NULL,
  `comment` text character set utf8 NOT NULL,
  `is_send_email` tinyint(1) NOT NULL, 
  `KPI_revision_id` int(10) NOT NULL default '1', 
  `KPI_serialized_answer` text character set utf8,
  `customer_revision_id` int(10) NOT NULL default '1', 
  `customer_serialized_answer` text character set utf8,
  `document_control_revision_id` int(10) NOT NULL default '1', 
  `document_control_serialized_answer` text collate utf8_general_ci, 
  `policy_revision_id` int(10) NOT NULL default '1', 
  `policy_serialized_answer` text character set utf8,
  `submit_date_sap` date NOT NULL default '0000-00-00', 
  `is_manager_edit` tinyint(1) NOT NULL default '0', 
  PRIMARY KEY  (`id`) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `tbt_user` ( 	 	
  `employee_id` varchar(15) NOT NULL, 	 	
  `allow_direct_login` tinyint(1) NOT NULL, 	 	
  `allow_mobile_login` tinyint(1) NOT NULL, 	 	
  `allow_tablet_login` tinyint(1) NOT NULL, 	 	
  `user_login` varchar(255) NOT NULL, 	 	
  `user_firstname` varchar(255) NOT NULL, 	 	
  `user_lastname` varchar(255) NOT NULL, 	 	
  `user_email` varchar(255) NOT NULL, 	 	
  `user_phone` varchar(20) NOT NULL, 	 	
  `user_mobile` varchar(20) NOT NULL, 	 	
  `user_fax` varchar(20) NOT NULL, 	 	
  `status_code` varchar(20) NOT NULL, 	 	
  `gender` enum('male','female') NOT NULL, 	 	
  PRIMARY KEY  (`employee_id`) 	 	
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 	 	 	 	
 	 	
CREATE TABLE IF NOT EXISTS `tbt_user_customer` ( 	 	
  `employee_id` varchar(15) NOT NULL, 	 	
  `sold_to_id` varchar(10) NOT NULL, 	 	
  PRIMARY KEY  (`employee_id`,`sold_to_id`) 	 	
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 	 	
 
DROP TABLE IF EXISTS `tbt_user_marked`;
CREATE TABLE IF NOT EXISTS `tbt_user_marked` (
  `assign_id` int(10) NOT NULL,
  `emp_id` varchar(15) character set utf8 NOT NULL,
  `contract_id` varchar(10) character set utf8 NOT NULL,
  `ship_to_id` varchar(10) character set utf8 NOT NULL,
  `module_id` int(11) NOT NULL,
  `clear_job_type_id` varchar(4) NULL default,
  `frequency` float NULL default,
  `sequence` int(11) NOT NULL,
  `action_plan_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`assign_id`,`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; 

CREATE TABLE IF NOT EXISTS `tbt_user_position` ( 	 	
  `employee_id` varchar(15) NOT NULL, 	 	
  `position_id` int(10) NOT NULL, 	 	
  `status` enum('main','other') NOT NULL, 	 	
  PRIMARY KEY  (`employee_id`,`position_id`) 	 	
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 	 	
 
DROP TABLE IF EXISTS `tbt_visitation_document`;
CREATE TABLE IF NOT EXISTS `tbt_visitation_document` (
  `id` int(10) NOT NULL auto_increment, 
  `title` varchar(512) NOT NULL default '',
  `project_id` int(10) NOT NULL, 
  `contract_id` varchar(10) NOT NULL,
  `visitor_id` varchar(15) NOT NULL,
  `visit_reason_id` varchar(4) NOT NULL,
  `not_visit_reason_id` varchar(4) NOT NULL,
  `contact_type` varchar(4) NOT NULL,
  `prospect_id` int(10) NOT NULL, 
  `quotation_id` varchar(10) NOT NULL,
  `action_plan_id` int(10) NOT NULL, 
  `comment_before` text NOT NULL,
  `comment_after` text NOT NULL,
  `contact_id` varchar(10) NOT NULL,
  `conclusion` varchar(512) NOT NULL,
  `detail` text NOT NULL,
  `comment` text NOT NULL,
  `cpt_time` int(4) NOT NULL, 
  `cpt_unit_time` enum('day','month','','') NOT NULL,
  `cpt_start` date NOT NULL, 
  `cpt_end` date NOT NULL,
  `cpt_price` double NOT NULL, 
  `cpt_comment` text NOT NULL,
  `notice_to_cr` text NOT NULL,
  `notice_to_oper` text NOT NULL,
  `notice_to_hr` text NOT NULL,
  `notice_to_training` text NOT NULL,
  `notice_to_store` text NOT NULL,
  `notice_to_sale` text NOT NULL,
  `submit_date_sap` date NOT NULL, 
  `is_manager_comment` tinyint(1) NOT NULL, 
  `is_visitor_comment` tinyint(1) NOT NULL, 
  PRIMARY KEY  (`id`) 
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; 