--- 29-05-2016 ---
ALTER TABLE `posts` ADD `user_id` INT(11) NOT NULL AFTER `brand_id`;

--- 02-06-2016 ---
ALTER TABLE `outlets` ADD `outlet_constant` VARCHAR(30) NOT NULL AFTER `outlet_name`;
ALTER TABLE `social_media_keys` ADD `brand_outlet_id` INT NOT NULL AFTER `user_id`;

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

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'United States'),
(2, 'Canada'),
(3, 'Virtual'),
(4, 'Afghanistan'),
(5, 'Albania'),
(6, 'Algeria'),
(7, 'American Samoa'),
(8, 'Andorra'),
(9, 'Angola'),
(10, 'Anguilla'),
(11, 'Antarctica'),
(12, 'Antigua and/or Barbuda'),
(13, 'Argentina'),
(14, 'Armenia'),
(15, 'Aruba'),
(16, 'Australia'),
(17, 'Austria'),
(18, 'Azerbaijan'),
(19, 'Bahamas'),
(20, 'Bahrain'),
(21, 'Bangladesh'),
(22, 'Barbados'),
(23, 'Belarus'),
(24, 'Belgium'),
(25, 'Belize'),
(26, 'Benin'),
(27, 'Bermuda'),
(28, 'Bhutan'),
(29, 'Bolivia'),
(30, 'Bosnia and Herzegovina'),
(31, 'Botswana'),
(32, 'Bouvet Island'),
(33, 'Brazil'),
(34, 'British lndian Ocean Territory'),
(35, 'Brunei Darussalam'),
(36, 'Bulgaria'),
(37, 'Burkina Faso'),
(38, 'Burundi'),
(39, 'Cambodia'),
(40, 'Cameroon'),
(41, 'Cape Verde'),
(42, 'Cayman Islands'),
(43, 'Central African Republic'),
(44, 'Chad'),
(45, 'Chile'),
(46, 'China'),
(47, 'Christmas Island'),
(48, 'Cocos (Keeling) Islands'),
(49, 'Colombia'),
(50, 'Comoros'),
(51, 'Congo'),
(52, 'Cook Islands'),
(53, 'Costa Rica'),
(54, 'Croatia (Hrvatska)'),
(55, 'Cuba'),
(56, 'Cyprus'),
(57, 'Czech Republic'),
(58, 'Denmark'),
(59, 'Djibouti'),
(60, 'Dominica'),
(61, 'Dominican Republic'),
(62, 'East Timor'),
(63, 'Ecuador'),
(64, 'Egypt'),
(65, 'El Salvador'),
(66, 'Equatorial Guinea'),
(67, 'Eritrea'),
(68, 'Estonia'),
(69, 'Ethiopia'),
(70, 'Falkland Islands (Malvinas)'),
(71, 'Faroe Islands'),
(72, 'Fiji'),
(73, 'Finland'),
(74, 'France'),
(75, 'France, Metropolitan'),
(76, 'French Guiana'),
(77, 'French Polynesia'),
(78, 'French Southern Territories'),
(79, 'Gabon'),
(80, 'Gambia'),
(81, 'Georgia'),
(82, 'Germany'),
(83, 'Ghana'),
(84, 'Gibraltar'),
(85, 'Greece'),
(86, 'Greenland'),
(87, 'Grenada'),
(88, 'Guadeloupe'),
(89, 'Guam'),
(90, 'Guatemala'),
(91, 'Guinea'),
(92, 'Guinea-Bissau'),
(93, 'Guyana'),
(94, 'Haiti'),
(95, 'Heard and Mc Donald Islands'),
(96, 'Honduras'),
(97, 'Hong Kong'),
(98, 'Hungary'),
(99, 'Iceland'),
(100, 'India'),
(101, 'Indonesia'),
(102, 'Iran (Islamic Republic of)'),
(103, 'Iraq'),
(104, 'Ireland'),
(105, 'Israel'),
(106, 'Italy'),
(107, 'Ivory Coast'),
(108, 'Jamaica'),
(109, 'Japan'),
(110, 'Jordan'),
(111, 'Kazakhstan'),
(112, 'Kenya'),
(113, 'Kiribati'),
(114, 'Korea, Democratic People''s Republic of'),
(115, 'Korea, Republic of'),
(116, 'Kosovo'),
(117, 'Kuwait'),
(118, 'Kyrgyzstan'),
(119, 'Lao People''s Democratic Republic'),
(120, 'Latvia'),
(121, 'Lebanon'),
(122, 'Lesotho'),
(123, 'Liberia'),
(124, 'Libyan Arab Jamahiriya'),
(125, 'Liechtenstein'),
(126, 'Lithuania'),
(127, 'Luxembourg'),
(128, 'Macau'),
(129, 'Macedonia'),
(130, 'Madagascar'),
(131, 'Malawi'),
(132, 'Malaysia'),
(133, 'Maldives'),
(134, 'Mali'),
(135, 'Malta'),
(136, 'Marshall Islands'),
(137, 'Martinique'),
(138, 'Mauritania'),
(139, 'Mauritius'),
(140, 'Mayotte'),
(141, 'Mexico'),
(142, 'Micronesia, Federated States of'),
(143, 'Moldova, Republic of'),
(144, 'Monaco'),
(145, 'Mongolia'),
(146, 'Montenegro'),
(147, 'Montserrat'),
(148, 'Morocco'),
(149, 'Mozambique'),
(150, 'Myanmar'),
(151, 'Namibia'),
(152, 'Nauru'),
(153, 'Nepal'),
(154, 'Netherlands'),
(155, 'Netherlands Antilles'),
(156, 'New Caledonia'),
(157, 'New Zealand'),
(158, 'Nicaragua'),
(159, 'Niger'),
(160, 'Nigeria'),
(161, 'Niue'),
(162, 'Norfork Island'),
(163, 'Northern Mariana Islands'),
(164, 'Norway'),
(165, 'Oman'),
(166, 'Pakistan'),
(167, 'Palau'),
(168, 'Panama'),
(169, 'Papua New Guinea'),
(170, 'Paraguay'),
(171, 'Peru'),
(172, 'Philippines'),
(173, 'Pitcairn'),
(174, 'Poland'),
(175, 'Portugal'),
(176, 'Puerto Rico'),
(177, 'Qatar'),
(178, 'Reunion'),
(179, 'Romania'),
(180, 'Russian Federation'),
(181, 'Rwanda'),
(182, 'Saint Kitts and Nevis'),
(183, 'Saint Lucia'),
(184, 'Saint Vincent and the Grenadines'),
(185, 'Samoa'),
(186, 'San Marino'),
(187, 'Sao Tome and Principe'),
(188, 'Saudi Arabia'),
(189, 'Senegal'),
(190, 'Serbia'),
(191, 'Seychelles'),
(192, 'Sierra Leone'),
(193, 'Singapore'),
(194, 'Slovakia'),
(195, 'Slovenia'),
(196, 'Solomon Islands'),
(197, 'Somalia'),
(198, 'South Africa'),
(199, 'South Georgia South Sandwich Islands'),
(200, 'Spain'),
(201, 'Sri Lanka'),
(202, 'St. Helena'),
(203, 'St. Pierre and Miquelon'),
(204, 'Sudan'),
(205, 'Suriname'),
(206, 'Svalbarn and Jan Mayen Islands'),
(207, 'Swaziland'),
(208, 'Sweden'),
(209, 'Switzerland'),
(210, 'Syrian Arab Republic'),
(211, 'Taiwan'),
(212, 'Tajikistan'),
(213, 'Tanzania, United Republic of'),
(214, 'Thailand'),
(215, 'Togo'),
(216, 'Tokelau'),
(217, 'Tonga'),
(218, 'Trinidad and Tobago'),
(219, 'Tunisia'),
(220, 'Turkey'),
(221, 'Turkmenistan'),
(222, 'Turks and Caicos Islands'),
(223, 'Tuvalu'),
(224, 'Uganda'),
(225, 'Ukraine'),
(226, 'United Arab Emirates'),
(227, 'United Kingdom'),
(228, 'United States minor outlying islands'),
(229, 'Uruguay'),
(230, 'Uzbekistan'),
(231, 'Vanuatu'),
(232, 'Vatican City State'),
(233, 'Venezuela'),
(234, 'Vietnam'),
(235, 'Virigan Islands (British)'),
(236, 'Virgin Islands (U.S.)'),
(237, 'Wallis and Futuna Islands'),
(238, 'Western Sahara'),
(239, 'Yemen'),
(240, 'Yugoslavia'),
(241, 'Zaire'),
(242, 'Zambia'),
(243, 'Zimbabwe');


INSERT INTO `outlets` VALUES(1, 'Facebook', 'FACEBOOK');
INSERT INTO `outlets` VALUES(2, 'Twitter', 'TWITTER');
INSERT INTO `outlets` VALUES(3, 'Instagram', 'INSTAGRAM');
INSERT INTO `outlets` VALUES(4, 'Linkedin', 'LINKEDIN');
INSERT INTO `outlets` VALUES(5, 'Pinterest', 'PINTEREST');
INSERT INTO `outlets` VALUES(6, 'Youtube', 'YOUTUBE');
INSERT INTO `outlets` VALUES(7, 'Tumblr', 'TUMBLR');

--- 03-06-2016 ---
ALTER TABLE `brands` DROP `user_id`;
ALTER TABLE `brands` ADD `slug` VARCHAR(100) NULL AFTER `timezone`;

--- 07-06-2016 ---
ALTER TABLE `posts` ADD `status` VARCHAR(20) NOT NULL DEFAULT 'pending' AFTER `slate_date_time`;
ALTER TABLE `reminders` CHANGE `approve_by` `due_date` DATETIME NULL DEFAULT NULL;

--- 07-06-2016 ---
ALTER TABLE `phases` ADD `status` VARCHAR(20) NOT NULL DEFAULT 'pending' AFTER `approve_by`;
ALTER TABLE `phases_approver` ADD `status` VARCHAR(20) NOT NULL DEFAULT 'pending' AFTER `user_id`;

--- 13-06-2016 ---
CREATE TABLE IF NOT EXISTS `post_comments` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `phase_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `post_comments`
ADD PRIMARY KEY (`id`);

ALTER TABLE `post_comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `post_comments` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE `post_comments` ADD `status` VARCHAR(10) NULL DEFAULT NULL AFTER `comment`;
ALTER TABLE `post_comments` ADD `parent_id` INT NULL AFTER `status`;
ALTER TABLE `post_comments` ADD `media` VARCHAR(20) NULL AFTER `comment`;

ALTER TABLE `social_media_keys` CHANGE `brand_outlet_id` `brand_id` INT(11) NOT NULL;
ALTER TABLE `social_media_keys` ADD `outlet_id` INT NULL AFTER `brand_id`;

--- 25-06-2016 ---
ALTER TABLE `posts` ADD `time_zone` VARCHAR(20) NULL AFTER `created_at`;

--- 30-06-2016 ---
ALTER TABLE `aauth_perm_to_user` ADD `brand_id` INT NOT NULL ;
ALTER TABLE `aauth_user_to_group` ADD `brand_id` INT NOT NULL ;
ALTER TABLE `user_outlets` ADD `brand_id` INT NOT NULL AFTER `outlet_id`;

ALTER TABLE `timeframe`.`aauth_perm_to_user` DROP PRIMARY KEY, ADD PRIMARY KEY (`perm_id`, `user_id`, `brand_id`) USING BTREE;
ALTER TABLE `timeframe`.`aauth_user_to_group` DROP PRIMARY KEY, ADD PRIMARY KEY (`user_id`, `group_id`, `brand_id`) USING BTREE;

CREATE TABLE IF NOT EXISTS `filters` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `tags` int(11) DEFAULT NULL,
  `outlets` int(11) DEFAULT NULL,
  `statuses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `filters`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `filters`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `filters` CHANGE `statuses` `statuses` VARCHAR(100) NULL DEFAULT NULL;
ALTER TABLE `filters` CHANGE `tags` `tags` VARCHAR(200) NULL DEFAULT NULL;
ALTER TABLE `filters` CHANGE `outlets` `outlets` VARCHAR(200) NULL DEFAULT NULL;

--- 04-07-2016 ---
ALTER TABLE `posts` ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;


--- 07-07-2016
CREATE TABLE IF NOT EXISTS `co_create_requests` (
`id` int(11) NOT NULL,
  `session_id` varchar(500) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `co_create_requests`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `co_create_requests`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `co_create_requests` ADD `request_string` VARCHAR(100) NOT NULL , ADD `brand_slug` VARCHAR(100) NOT NULL ;
ALTER TABLE `co_create_requests` ADD `user_id` INT NOT NULL ;

ALTER TABLE `timezone` ADD `abbreviation` VARCHAR(50) NULL AFTER `value`;

ALTER TABLE `user_info` ADD `email_notification` TINYINT NOT NULL DEFAULT '0' AFTER `plan`, ADD `urgent_notification` TINYINT NOT NULL DEFAULT '0' AFTER `email_notification`, ADD `desktop_notification` TINYINT NOT NULL DEFAULT '0' AFTER `urgent_notification`;


ALTER TABLE `user_info` CHANGE `email_notification` `email_notification` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0 = Active , 1 Inavtive', CHANGE `urgent_notification` `urgent_notification` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0 = Active , 1 Inavtive', CHANGE `desktop_notification` `desktop_notification` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0 = Active , 1 Inavtive';

--- 12-07-2016
ALTER TABLE `co_create_requests` DROP `token`;

--- 18-07-2016
UPDATE `timeframe`.`aauth_perms` SET `name` = 'settings' WHERE `aauth_perms`.`id` = 15;

--- 19-07-2016
ALTER TABLE `reminders` ADD `status` TINYINT NOT NULL DEFAULT '0' AFTER `due_date`;

--- 25-07-2016
ALTER TABLE `user_info` ADD `img_folder` INT NULL AFTER `desktop_notification`;
ALTER TABLE `brands` ADD `account_id` INT NOT NULL AFTER `slug`;

--- 30-07-2016
ALTER TABLE `reminders` ADD `added_through_cron` TINYINT NOT NULL DEFAULT '0' ;

--- 01-08-2016
ALTER TABLE `user_info` ADD `is_trial_period_expired` TINYINT NULL DEFAULT '0' COMMENT '1: Yes, 0: No' AFTER `img_folder`;

--- 02-08-2016
ALTER TABLE `aauth_user_to_group` CHANGE `brand_id` `brand_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `aauth_user_to_group` ADD `parent_id` INT(11) NULL DEFAULT NULL AFTER `brand_id`;

--- 03-08-2016
ALTER TABLE `aauth_perm_to_user` ADD `parent_id` INT NULL AFTER `brand_id`;
ALTER TABLE `aauth_perm_to_user` CHANGE `brand_id` `brand_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `aauth_user_to_group` CHANGE `brand_id` `brand_id` INT(11) NULL;

--- 06-08-2016
ALTER TABLE `social_media_keys` ADD `created_at` DATETIME NULL DEFAULT NULL AFTER `type`, ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`; 

--- 08-08-2016
ALTER TABLE `phases` ADD `time_zone` VARCHAR(20) NULL DEFAULT NULL AFTER `status`;

--- 09-08-2016
ALTER TABLE `co_create_requests` ADD `account_id` INT NOT NULL ;