ALTER TABLE `setting` ADD `media_directory` VARCHAR( 255 ) NOT NULL AFTER `email_support`;

UPDATE `setting` SET `media_directory` = 'TDProject/Media' WHERE `setting`.`setting_id` = 4;
