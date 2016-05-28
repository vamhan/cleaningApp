SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}cms_user_permission`;
CREATE TABLE `{dbprefix}cms_user_permission` (
  `user_id` bigint(10) NOT NULL,
  `cat_id` bigint(10) NOT NULL,
  `permission_type` varchar(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`user_id`,`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;