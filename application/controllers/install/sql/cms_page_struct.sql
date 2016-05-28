

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}cms_page_struct`;
CREATE TABLE IF NOT EXISTS `{dbprefix}cms_page_struct` (
  `group_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`page_id`,`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

