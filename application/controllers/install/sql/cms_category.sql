SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}cms_category`;
CREATE TABLE `{dbprefix}cms_category` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `module_id` bigint(11) NOT NULL,
  `parent_id` bigint(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `delete_flag` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;