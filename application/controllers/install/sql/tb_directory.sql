SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `{dbprefix}crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `{dbprefix}tb_directory`;
CREATE TABLE `{dbprefix}tb_directory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `floor_id` int(11) NOT NULL DEFAULT '0',
  `membership_id` varchar(20) NOT NULL DEFAULT '0',
  `title_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title_ch` varchar(100) NOT NULL,
  `m_type` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `short_desc_en` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `short_desc_ch` text,
  `body_en` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `body_ch` mediumtext,
  `thumb` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption_ch` varchar(100) NOT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `expire` datetime DEFAULT '0000-00-00 00:00:00',
  `hits` int(6) DEFAULT '0',
  `logo` varchar(200) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `openhour` varchar(200) DEFAULT NULL,
  `floorplan` varchar(100) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `transportation` varchar(200) DEFAULT NULL,
  `vip` varchar(100) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `show_author` tinyint(1) NOT NULL DEFAULT '1',
  `show_ratings` tinyint(1) NOT NULL DEFAULT '1',
  `show_comments` tinyint(1) NOT NULL DEFAULT '1',
  `show_sharing` tinyint(1) NOT NULL DEFAULT '1',
  `show_created` tinyint(1) NOT NULL DEFAULT '1',
  `show_like` tinyint(1) NOT NULL DEFAULT '1',
  `layout` tinyint(1) NOT NULL DEFAULT '1',
  `rating` varchar(10) NOT NULL DEFAULT '0',
  `rate_number` varchar(10) NOT NULL DEFAULT '0',
  `like_up` int(11) NOT NULL DEFAULT '0',
  `like_down` int(11) NOT NULL DEFAULT '0',
  `metakey_en` varchar(200) DEFAULT NULL,
  `metakey_ch` varchar(200) NOT NULL,
  `metadesc_en` text,
  `metadesc_ch` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `updatedate` datetime DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `image2` varchar(100) DEFAULT NULL,
  `image3` varchar(100) DEFAULT NULL,
  `image4` varchar(100) DEFAULT NULL,
  `image5` varchar(100) DEFAULT NULL,
  `image6` varchar(100) DEFAULT NULL,
  `image7` varchar(100) DEFAULT NULL,
  `image8` varchar(100) DEFAULT NULL,
  `image9` varchar(100) DEFAULT NULL,
  `image10` varchar(100) DEFAULT NULL,
  `video_title_ch` varchar(100) DEFAULT NULL,
  `video_title_en` varchar(100) DEFAULT NULL,
  `video_detail_ch` text,
  `video_detail_en` text,
  `video_embed_ch` text,
  `video_embed_en` text,
  `xcoord` int(11) NOT NULL DEFAULT '0',
  `ycoord` int(11) NOT NULL DEFAULT '0',
  `flag_sale` tinyint(1) NOT NULL DEFAULT '0',
  `flag_coupon` tinyint(1) NOT NULL DEFAULT '0',
  `flag_vip` tinyint(1) NOT NULL DEFAULT '0',
  `flag_newshop` tinyint(1) NOT NULL DEFAULT '0',
  `flag_comingsoon` tinyint(1) NOT NULL DEFAULT '0',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_catid` (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=253 ;