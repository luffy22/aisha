#
#<?php die('Forbidden.'); ?>
#Date: 2022-09-05 06:25:44 UTC
#Software: Joomla! 4.1.5 Stable [ Kuamini ] 21-June-2022 14:00 GMT

#Fields: datetime	priority clientip	category	message
2022-09-05T06:25:44+00:00	INFO ::1	update	Update started by user Astro Isha (222). Old version is 4.1.5.
2022-09-05T06:25:47+00:00	INFO ::1	update	Downloading update file from https://s3-us-west-2.amazonaws.com/joomla-official-downloads/joomladownloads/joomla4/Joomla_4.2.2-Stable-Update_Package.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA6LXDJLNUINX2AVMH%2F20220905%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20220905T062605Z&X-Amz-Expires=60&X-Amz-SignedHeaders=host&X-Amz-Signature=a1d94fe270cda473400e8cafcf1d5c73f7f2f4c65672d0e5e1d475904c91c7ff.
2022-09-05T06:26:39+00:00	INFO ::1	update	Update started by user Astro Isha (222). Old version is 4.1.5.
2022-09-05T06:26:41+00:00	INFO ::1	update	Downloading update file from https://s3-us-west-2.amazonaws.com/joomla-official-downloads/joomladownloads/joomla4/Joomla_4.2.2-Stable-Update_Package.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA6LXDJLNUINX2AVMH%2F20220905%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20220905T062700Z&X-Amz-Expires=60&X-Amz-SignedHeaders=host&X-Amz-Signature=6783296424bb494935875019dcd179e3871d9e6e4db5e688596c0a635d427af7.
2022-09-05T06:26:55+00:00	INFO ::1	update	File Joomla_4.2.2-Stable-Update_Package.zip downloaded.
2022-09-05T06:27:19+00:00	INFO ::1	update	File Joomla_4.2.2-Stable-Update_Package.zip downloaded.
2022-09-05T06:27:19+00:00	INFO ::1	update	Starting installation of new version.
2022-09-05T06:27:32+00:00	INFO ::1	update	Finalising installation.
2022-09-05T06:27:32+00:00	INFO ::1	update	Start of SQL updates.
2022-09-05T06:27:32+00:00	INFO ::1	update	The current database version (schema) is 4.1.3-2022-04-08.
2022-09-05T06:27:33+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-05-15. Query text: CREATE TABLE IF NOT EXISTS `#__user_mfa` (   `id` int NOT NULL AUTO_INCREMENT,  .
2022-09-05T06:27:33+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-05-15. Query text: DELETE FROM `#__postinstall_messages` WHERE `condition_file` = 'site://plugins/t.
2022-09-05T06:27:33+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-05-15. Query text: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, .
2022-09-05T06:27:33+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-05-15. Query text: UPDATE `#__extensions` AS `a` 	INNER JOIN `#__extensions` AS `b` on `a`.`element.
2022-09-05T06:27:33+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-05-15. Query text: DELETE FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'twofactoraut.
2022-09-05T06:27:33+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-05-15. Query text: INSERT IGNORE INTO `#__postinstall_messages` (`extension_id`, `title_key`, `desc.
2022-09-05T06:27:34+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-05-15. Query text: INSERT IGNORE INTO `#__mail_templates` (`template_id`, `extension`, `language`, .
2022-09-05T06:27:35+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-06-15. Query text: ALTER TABLE `#__mail_templates` MODIFY `htmlbody` mediumtext NOT NULL COLLATE 'u.
2022-09-05T06:27:35+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-06-19. Query text: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, .
2022-09-05T06:27:35+00:00	INFO ::1	update	Ran query from file 4.2.0-2022-06-22. Query text: UPDATE `#__extensions` SET `locked` = 1 WHERE  (`type` = 'plugin' AND     (     .
2022-09-05T06:27:35+00:00	INFO ::1	update	Ran query from file 4.2.1-2022-08-23. Query text: DELETE FROM `#__extensions` WHERE `name` = 'plg_fields_menuitem' AND `type` = 'p.
2022-09-05T06:27:35+00:00	INFO ::1	update	End of SQL updates.
2022-09-05T06:27:35+00:00	INFO ::1	update	Deleting removed files and folders.
2022-09-05T06:27:53+00:00	INFO ::1	update	Cleaning up after installation.
2022-09-05T06:27:53+00:00	INFO ::1	update	Update to version 4.2.2 is complete.
