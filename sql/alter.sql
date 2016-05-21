/*
  Aauth SQL Table Structure
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `aauth_groups`
-- ----------------------------
DROP TABLE IF EXISTS `aauth_groups`;
CREATE TABLE `aauth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `definition` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `aauth_perms`;
CREATE TABLE `aauth_perms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100),
  `definition` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `aauth_perm_to_group`;
CREATE TABLE `aauth_perm_to_group` (
  `perm_id` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`perm_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `aauth_perm_to_user`;
CREATE TABLE `aauth_perm_to_user` (
  `perm_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`perm_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `aauth_pms`;
CREATE TABLE `aauth_pms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) unsigned NOT NULL,
  `receiver_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text,
  `date_sent` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `full_index` (`id`,`sender_id`,`receiver_id`,`date_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `aauth_system_variables`;
CREATE TABLE `aauth_system_variables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data_key` varchar(100) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `aauth_users`;
CREATE TABLE `aauth_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(64) COLLATE utf8_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_general_ci,
  `banned` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `last_login_attempt` datetime DEFAULT NULL,
  `forgot_exp` text COLLATE utf8_general_ci,
  `remember_time` datetime DEFAULT NULL,
  `remember_exp` text COLLATE utf8_general_ci,
  `verification_code` text COLLATE utf8_general_ci,
  `totp_secret` varchar(16) COLLATE utf8_general_ci DEFAULT NULL,
  `ip_address` text COLLATE utf8_general_ci,
  `login_attempts` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `aauth_user_to_group`;
CREATE TABLE `aauth_user_to_group` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `aauth_user_variables`;
CREATE TABLE `aauth_user_variables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `data_key` varchar(100) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users` ADD `aauth_user_id` INT NOT NULL AFTER `id`;
ALTER TABLE `users` DROP `email`, DROP `salt`, DROP `username`, DROP `password`, DROP `status`;


ALTER TABLE `brands` ADD `timezone` VARCHAR(10) NOT NULL AFTER `created_by`;


CREATE TABLE IF NOT EXISTS `outlets` (
`id` int(11) NOT NULL,
  `outlet_name` varchar(200) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

INSERT INTO `outlets` (`id`, `outlet_name`) VALUES
(1, 'Facebook'),
(2, 'Twitter'),
(3, 'Instagram'),
(4, 'Linkedin'),
(5, 'Vine'),
(6, 'Pinterest'),
(7, 'Youtube'),
(8, 'Tumblr');

ALTER TABLE `outlets`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `outlets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;


CREATE TABLE IF NOT EXISTS `brand_outlets` (
`id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `brand_outlets`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `brand_outlets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

DROP TABLE IF EXISTS `post_media`;

CREATE TABLE `post_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('images','video') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `post_media` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `post_media` ADD `mime` VARCHAR(250) NOT NULL AFTER `type`;

/*Data for the table `post_media` */

/*Table structure for table `post_tags` */

DROP TABLE IF EXISTS `post_tags`;

CREATE TABLE `brand_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `brand_tags` ADD `brand_id` INT NOT NULL AFTER `color`;

/*Data for the table `post_tags` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext,
  `slate_date_time` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `posts` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `posts` ADD `brand_id` INT NOT NULL AFTER `content`;
ALTER TABLE `posts` ADD `outlet_id` INT NOT NULL AFTER `brand_id`;




ALTER TABLE `user_info` ADD `title` VARCHAR(250) NULL AFTER `last_name`;

CREATE TABLE IF NOT EXISTS `post_tags` (
`id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `brand_tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `post_tags`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `post_tags`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- CREATE TABLE IF NOT EXISTS `post_approvers` (
-- `id` int(11) NOT NULL,
--   `post_id` int(11) NOT NULL,
--   `user_id` int(11) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- ALTER TABLE `post_approvers`
--  ADD PRIMARY KEY (`id`);

-- ALTER TABLE `post_approvers`
-- MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `billing_details` ADD `exp_year` INT NOT NULL AFTER `email`;
ALTER TABLE `billing_details` ADD `exp_month` INT NOT NULL AFTER `exp_year`;

ALTER TABLE `billing_details` ADD `cc_number` VARCHAR(5) NULL AFTER `name`;
ALTER TABLE `billing_details` ADD `cvc` VARCHAR(4) NULL AFTER `cc_number`;

-- 12-04-2016
CREATE TABLE IF NOT EXISTS `phases` (
`id` int(11) NOT NULL,
  `phase` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `phases`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `phases`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `phases_approver` (
`id` int(11) NOT NULL,
  `phase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `phases_approver`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `phases_approver`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `phases` ADD `approve_by` DATETIME NOT NULL , ADD `note` TEXT NULL ;

--21-04-2016--
CREATE TABLE IF NOT EXISTS `user_outlets` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `user_outlets`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `user_outlets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE IF NOT EXISTS `reminders` (
`id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `approve_by` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `reminders`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `reminders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `reminders` ADD `user_id` INT NOT NULL AFTER `post_id`;

ALTER TABLE `reminders` ADD `text` VARCHAR(500) NOT NULL AFTER `type`;

ALTER TABLE `brand_tags` CHANGE `color` `color` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;