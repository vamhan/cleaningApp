SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}cms_log`;
CREATE TABLE `{dbprefix}cms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor` varchar(50) NOT NULL,
  `actor_id` int(11) NOT NULL DEFAULT '0',
  `action_type` varchar(255) NOT NULL,
  `module_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `object_type` varchar(255) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `result` text,
  `ip` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

