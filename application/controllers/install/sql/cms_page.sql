SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}cms_page`;
CREATE TABLE `{dbprefix}cms_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `description` text NOT NULL,
  `page_title` varchar(256) NOT NULL COMMENT 'all lowercase no space ',
  `table` varchar(1024) NOT NULL,
  `mod_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `perma_link` varchar(2048) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `delete_flag` tinyint(4) NOT NULL DEFAULT '0',
  `page_type` enum('front_end','back_end') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

