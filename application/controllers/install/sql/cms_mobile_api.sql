SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}cms_mobile_api`;
CREATE TABLE `{dbprefix}cms_mobile_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `description` text NOT NULL,
  `table` varchar(1024) NOT NULL,
  `mod_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `is_ready_to_use` tinyint(1) NOT NULL DEFAULT '0',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

