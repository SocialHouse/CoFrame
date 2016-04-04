DROP TABLE IF EXISTS `billing_details`;

CREATE TABLE `billing_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `address` text,
  `city` varchar(250) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `zip` varchar(250) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `billing_details` */

/*Table structure for table `brand_user_map` */

DROP TABLE IF EXISTS `brand_user_map`;

CREATE TABLE `brand_user_map` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `access_user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`access_user_id`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `brand_user_map` */

/*Table structure for table `brands` */

DROP TABLE IF EXISTS `brands`;

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'who added brand',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `brands` */

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `login_attempts` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migrations` */

insert  into `migrations`(`version`) values (1);

/*Table structure for table `timezone` */

DROP TABLE IF EXISTS `timezone`;

CREATE TABLE `timezone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timezone` varchar(300) NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `timezone` */

insert  into `timezone`(`id`,`timezone`,`value`) values (1,'(GMT -12:00) Eniwetok, Kwajalein',-12);
insert  into `timezone`(`id`,`timezone`,`value`) values (2,'(GMT -11:00) Midway Island, Samoa',-11);
insert  into `timezone`(`id`,`timezone`,`value`) values (3,'(GMT -10:00) Hawaii',-10);
insert  into `timezone`(`id`,`timezone`,`value`) values (4,'(GMT -9:00) Alaska',-9);
insert  into `timezone`(`id`,`timezone`,`value`) values (5,'(GMT -8:00) Pacific Time (US &amp; Canada)',-8);
insert  into `timezone`(`id`,`timezone`,`value`) values (6,'(GMT -7:00) Mountain Time (US &amp; Canada)',-7);
insert  into `timezone`(`id`,`timezone`,`value`) values (7,'(GMT -6:00) Central Time (US &amp; Canada), Mexico City',-6);
insert  into `timezone`(`id`,`timezone`,`value`) values (8,'(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima',-5);
insert  into `timezone`(`id`,`timezone`,`value`) values (9,'(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz',-4);
insert  into `timezone`(`id`,`timezone`,`value`) values (10,'(GMT -3:30) Newfoundland',-3.5);
insert  into `timezone`(`id`,`timezone`,`value`) values (11,'(GMT -3:00) Brazil, Buenos Aires, Georgetown',-3);
insert  into `timezone`(`id`,`timezone`,`value`) values (12,'(GMT -2:00) Mid-Atlantic',-2);
insert  into `timezone`(`id`,`timezone`,`value`) values (13,'(GMT -1:00 hour) Azores, Cape Verde Islands',-1);
insert  into `timezone`(`id`,`timezone`,`value`) values (14,'(GMT) Western Europe Time, London, Lisbon, Casablanca',0);
insert  into `timezone`(`id`,`timezone`,`value`) values (15,'(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris',1);
insert  into `timezone`(`id`,`timezone`,`value`) values (16,'(GMT +2:00) Kaliningrad, South Africa',2);
insert  into `timezone`(`id`,`timezone`,`value`) values (17,'(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg',3);
insert  into `timezone`(`id`,`timezone`,`value`) values (18,'(GMT +3:30) Tehran',3.5);
insert  into `timezone`(`id`,`timezone`,`value`) values (19,'(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi',4);
insert  into `timezone`(`id`,`timezone`,`value`) values (20,'(GMT +4:30) Kabul',4.5);
insert  into `timezone`(`id`,`timezone`,`value`) values (21,'(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent',5);
insert  into `timezone`(`id`,`timezone`,`value`) values (22,'(GMT +5:30) Bombay, Calcutta, Madras, New Delhi',5.5);
insert  into `timezone`(`id`,`timezone`,`value`) values (23,'(GMT +5:45) Kathmandu',5.75);
insert  into `timezone`(`id`,`timezone`,`value`) values (24,'(GMT +6:00) Almaty, Dhaka, Colombo',6);
insert  into `timezone`(`id`,`timezone`,`value`) values (25,'(GMT +7:00) Bangkok, Hanoi, Jakarta',7);
insert  into `timezone`(`id`,`timezone`,`value`) values (26,'(GMT +8:00) Beijing, Perth, Singapore, Hong Kong',8);
insert  into `timezone`(`id`,`timezone`,`value`) values (27,'(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',9);
insert  into `timezone`(`id`,`timezone`,`value`) values (28,'(GMT +9:30) Adelaide, Darwin',9.5);
insert  into `timezone`(`id`,`timezone`,`value`) values (29,'(GMT +10:00) Eastern Australia, Guam, Vladivostok',10);
insert  into `timezone`(`id`,`timezone`,`value`) values (30,'(GMT +11:00) Magadan, Solomon Islands, New Caledonia',11);
insert  into `timezone`(`id`,`timezone`,`value`) values (31,'(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka',12);

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `plan` varchar(150) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `current_period_start` int(11) NOT NULL,
  `current_period_end` int(11) NOT NULL,
  `stripe_customer_id` varchar(250) NOT NULL,
  `subscription_id` varchar(250) NOT NULL,
  `card_id` varchar(250) NOT NULL,
  `transcation_status` varchar(150) NOT NULL,
  `paid_date` datetime NOT NULL,
  `response` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `transactions` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `timezone` varchar(10) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_url` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `forgot_token` varchar(250) DEFAULT NULL,
  `login_verify_token` varchar(250) DEFAULT NULL,
  `stripe_customer_id` varchar(250) DEFAULT NULL,
  `stripe_subscription_id` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users` */

ALTER TABLE `transactions` CHANGE `transcation_status` `transaction_status` VARCHAR(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `brands` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `brand_user_map` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `brands` ADD `is_hidden` TINYINT NOT NULL DEFAULT '0' AFTER `created_by`;

CREATE TABLE IF NOT EXISTS `social_media_keys` (
`id` int(11) NOT NULL,
  `access_token` varchar(300) NOT NULL,
  `social_media_id` int(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `response` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `social_media_keys`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `social_media_keys`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `social_media_keys` ADD `access_token_secret` VARCHAR(300) NULL AFTER `access_token`;
ALTER TABLE `social_media_keys` ADD `type` VARCHAR(100) NOT NULL AFTER `response`;
ALTER TABLE `social_media_keys` CHANGE `social_media_id` `social_media_id` INT(20) NULL;



