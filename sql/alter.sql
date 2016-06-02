ALTER TABLE `posts` ADD `user_id` INT(11) NOT NULL AFTER `brand_id`;

ALTER TABLE `social_media_keys` ADD `brand_outlet_id` INT NOT NULL AFTER `user_id`;