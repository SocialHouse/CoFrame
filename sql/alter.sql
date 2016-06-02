--- 29-05-2016 ---
ALTER TABLE `posts` ADD `user_id` INT(11) NOT NULL AFTER `brand_id`;

--- 02-06-2016 ---
ALTER TABLE `outlets` ADD `outlet_constant` VARCHAR(30) NOT NULL AFTER `outlet_name`;
ALTER TABLE `social_media_keys` ADD `brand_outlet_id` INT NOT NULL AFTER `user_id`;

