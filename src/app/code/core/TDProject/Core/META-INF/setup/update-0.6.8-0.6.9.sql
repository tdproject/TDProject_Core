--
-- Insert webservice settings
--
ALTER TABLE `setting` ADD `wsdl_uri` VARCHAR( 255 ) NULL ;
ALTER TABLE `setting` ADD `webservice_uri` VARCHAR( 255 ) NULL ;

--
-- Adds column 'locale' to table 'user'
--
ALTER TABLE `user` ADD `locale` VARCHAR( 5 ) NOT NULL DEFAULT 'en_US' AFTER `username`;

--
-- Insert localization for webservice setting-entry and user profile
--
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES
('de_DE', 'setting.view.tab.label.webservice', 'Webservice'),
('en_US', 'setting.view.tab.label.webservice', 'Webservice'),
('de_DE', 'setting.view.fieldset.label.webservice', 'Webservice-Server'),
('en_US', 'setting.view.fieldset.label.webservice', 'Webservice-Server'),
('de_DE', 'setting.view.label.webservice-uri', 'Webservice-URL'),
('en_US', 'setting.view.label.webservice-uri', 'Webservice-URL'),
('de_DE', 'setting.view.label.wsdl-uri', 'WSDL-URL'),
('en_US', 'setting.view.label.wsdl-uri', 'WSDL-URL'),
('en_US', 'page.navigation.root.ownOption', 'My Account'),
('de_DE', 'page.navigation.root.ownOption', 'Benutzerkonto'),
('en_US', 'title.ownOption.view', 'My Account'),
('de_DE', 'title.ownOption.view', 'Benutzerkonto'),
('en_US', 'selfDeleteNotPossible', 'It is not possible to delete yourself.'),
('de_DE', 'selfDeleteNotPossible', 'Es ist nicht möglich sich selbst zu löschen.');

CREATE TABLE `rewrite` (
	`rewrite_id` int(10) NOT NULL, 
	`source` varchar(255) NOT NULL, 
	`name` varchar(255) NOT NULL, 
	`path` varchar(255) NOT NULL, 
	`redirect` tinyint(1) NOT NULL default 0, 
	`response_code` int(10) NOT NULL default 200
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ENGINE=InnoDB;

ALTER TABLE `rewrite` ADD CONSTRAINT rewrite_pk PRIMARY KEY (`rewrite_id`); 
ALTER TABLE `rewrite` CHANGE rewrite_id `rewrite_id` int(10) AUTO_INCREMENT;
         
ALTER TABLE `rewrite` ADD UNIQUE INDEX rewrite_uidx_01 (`source`);