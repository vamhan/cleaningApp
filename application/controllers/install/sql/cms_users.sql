SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}cms_users`;
CREATE TABLE `{dbprefix}cms_users` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(10) NOT NULL,
  `user_login` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_firstname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_lastname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_email` varchar(200) CHARACTER SET utf8 NOT NULL,
  `user_info` text CHARACTER SET utf8,
  `is_internal_user` tinyint(11) NOT NULL DEFAULT '1',
  `is_enable` tinyint(11) NOT NULL DEFAULT '1',
  `is_delete` tinyint(11) NOT NULL DEFAULT '0',
  `cookie` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

