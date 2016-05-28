SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}cms_group_permission`;
CREATE TABLE `{dbprefix}cms_group_permission` (
  `group_id` bigint(10) NOT NULL,
  `cat_id` bigint(10) NOT NULL,
  `permission_type` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT 'create/update/delete/view',
  PRIMARY KEY (`group_id`,`cat_id`),
  UNIQUE KEY `group_id` (`group_id`,`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

