#
#<?php die('Forbidden.'); ?>
#Date: 2023-10-18 09:24:23 UTC
#Software: Joomla! 4.3.4 Stable [ Bora ] 22-August-2023 16:00 GMT

#Fields: datetime	priority clientip	category	message
2023-10-18T09:24:23+00:00	INFO ::1	update	Update started by user Astro Isha (222). Old version is 4.3.4.
2023-10-18T09:24:26+00:00	INFO ::1	update	Downloading update file from https://s3-us-west-2.amazonaws.com/joomla-official-downloads/joomladownloads/joomla4/Joomla_4.4.0-Stable-Update_Package.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA6LXDJLNUINX2AVMH%2F20231018%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20231018T092420Z&X-Amz-Expires=60&X-Amz-SignedHeaders=host&X-Amz-Signature=0a02db675c367419d4c0eb88ddff23c318d18ca616cd958c5d2cd7619de8992e.
2023-10-18T09:24:45+00:00	INFO ::1	update	File Joomla_4.4.0-Stable-Update_Package.zip downloaded.
2023-10-18T09:24:45+00:00	INFO ::1	update	Starting installation of new version.
2023-10-18T09:25:01+00:00	INFO ::1	update	Finalising installation.
2023-10-18T09:25:01+00:00	INFO ::1	update	Start of SQL updates.
2023-10-18T09:25:01+00:00	INFO ::1	update	The current database version (schema) is 4.3.2-2023-05-20.
2023-10-18T09:25:01+00:00	INFO ::1	update	Ran query from file 4.4.0-2023-05-08. Query text: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, .
2023-10-18T09:25:01+00:00	INFO ::1	update	Ran query from file 4.4.0-2023-09-13. Query text: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, .
2023-10-18T09:25:01+00:00	INFO ::1	update	End of SQL updates.
2023-10-18T09:25:01+00:00	INFO ::1	update	Deleting removed files and folders.
2023-10-18T09:25:08+00:00	INFO ::1	update	Cleaning up after installation.
2023-10-18T09:25:09+00:00	INFO ::1	update	Update to version 4.4.0 is complete.
2023-10-19T05:56:00+00:00	INFO ::1	update	Test logging
2023-10-19T05:56:00+00:00	INFO ::1	update	Update started by user Astro Isha (222). Old version is 4.4.0.
2023-10-19T05:56:02+00:00	INFO ::1	update	Downloading update file from https://s3-us-west-2.amazonaws.com/joomla-official-downloads/joomladownloads/joomla5/Joomla_5.0.0-Stable-Update_Package.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA6LXDJLNUINX2AVMH%2F20231019%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20231019T055557Z&X-Amz-Expires=60&X-Amz-SignedHeaders=host&X-Amz-Signature=fbf1b6902fe46dc84aac6a2b9ac375921c06601caf1e50a92d7db417b1a41ed5.
2023-10-19T05:56:16+00:00	INFO ::1	update	File Joomla_5.0.0-Stable-Update_Package.zip downloaded.
2023-10-19T05:56:16+00:00	INFO ::1	update	Starting installation of new version.
2023-10-19T05:56:23+00:00	INFO ::1	update	Finalising installation.
2023-10-19T05:56:23+00:00	INFO ::1	update	Start of SQL updates.
2023-10-19T05:56:23+00:00	INFO ::1	update	The current database version (schema) is 4.4.0-2023-09-13.
2023-10-19T05:56:23+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-03-11. Query text: DROP TABLE IF EXISTS `#__utf8_conversion`;.
2023-10-19T05:56:23+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-03-17. Query text: DELETE FROM `#__scheduler_tasks` WHERE `type` = 'demoTask_r1.sleep';.
2023-10-19T05:56:24+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-07-12. Query text: ALTER TABLE `#__menu_types` ADD COLUMN `ordering` int NOT NULL DEFAULT 0 AFTER `.
2023-10-19T05:56:24+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-07-12. Query text: UPDATE `#__menu_types` SET `ordering` = `id` WHERE `client_id` = 0;.
2023-10-19T05:56:26+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-07-25. Query text: CREATE TABLE IF NOT EXISTS `#__schemaorg` (   `id` int unsigned NOT NULL AUTO_I.
2023-10-19T05:56:26+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-07-25. Query text: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, .
2023-10-19T05:56:26+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-07-29. Query text: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, .
2023-10-19T05:56:26+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-21. Query text: UPDATE `#__extensions`    SET `params` = JSON_REPLACE(`params`, '$.filter' , '\\.
2023-10-19T05:56:26+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-21. Query text: UPDATE `#__fields`    SET `fieldparams` = JSON_REPLACE(`fieldparams`, '$.filter'.
2023-10-19T05:56:26+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-26. Query text: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, .
2023-10-19T05:56:27+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_content","com_categories"]' WH.
2023-10-19T05:56:27+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_content","com_categories"]' WH.
2023-10-19T05:56:27+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_menus"]' WHERE `url` LIKE '%co.
2023-10-19T05:56:27+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_tags"]' WHERE `url` LIKE '%com.
2023-10-19T05:56:27+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_banners"]' WHERE `url` LIKE '%.
2023-10-19T05:56:27+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_contact"]' WHERE `url` LIKE '%.
2023-10-19T05:56:27+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_newsfeeds"]' WHERE `url` LIKE .
2023-10-19T05:56:27+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_finder"]' WHERE `url` LIKE '%c.
2023-10-19T05:56:28+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__guidedtours` SET `extensions` = '["com_users"]' WHERE `url` LIKE '%co.
2023-10-19T05:56:28+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-28. Query text: UPDATE `#__update_sites`    SET `location` = 'https://update.joomla.org/language.
2023-10-19T05:56:28+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: ALTER TABLE `#__guidedtours` ADD COLUMN `uid` varchar(255) CHARACTER SET utf8mb4.
2023-10-19T05:56:29+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: ALTER TABLE `#__guidedtours` ADD INDEX `idx_uid` (`uid`(191)) ;.
2023-10-19T05:56:29+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-guidedtours' WHERE `title` = 'COM_GU.
2023-10-19T05:56:29+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-guidedtoursteps' WHERE `title` = 'CO.
2023-10-19T05:56:29+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-articles'  WHERE `title` = 'COM_GUID.
2023-10-19T05:56:29+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-categories' WHERE `title` = 'COM_GUI.
2023-10-19T05:56:29+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-menus' WHERE `title` = 'COM_GUIDEDTO.
2023-10-19T05:56:29+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-tags' WHERE `title` = 'COM_GUIDEDTOU.
2023-10-19T05:56:29+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-banners' WHERE `title` = 'COM_GUIDED.
2023-10-19T05:56:30+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-contacts' WHERE `title` = 'COM_GUIDE.
2023-10-19T05:56:30+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-newsfeeds' WHERE `title` = 'COM_GUID.
2023-10-19T05:56:30+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-smartsearch' WHERE `title` = 'COM_GU.
2023-10-19T05:56:30+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-29. Query text: UPDATE `#__guidedtours` SET `uid` = 'joomla-users' WHERE `title` = 'COM_GUIDEDTO.
2023-10-19T05:56:30+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-08-30. Query text: UPDATE `#__extensions`    SET `locked` = 0  WHERE `type` = 'plugin' AND `element.
2023-10-19T05:56:30+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-02. Query text: INSERT INTO `#__extensions` (`name`, `type`, `element`, `folder`, `client_id`, `.
2023-10-19T05:56:30+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-02. Query text: INSERT INTO `#__mail_templates` (`template_id`, `extension`, `language`, `subjec.
2023-10-19T05:56:30+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-02. Query text: DELETE FROM `#__mail_templates` WHERE `template_id` IN ('plg_system_privacyconse.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-02. Query text: DELETE FROM `#__postinstall_messages` WHERE `condition_file` = 'site://plugins/s.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-06. Query text: UPDATE `#__scheduler_tasks` SET `title` = 'Delete Action Logs' WHERE `type` = 'd.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-06. Query text: UPDATE `#__scheduler_tasks` SET `title` = 'Privacy Consent' WHERE `type` = 'priv.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-06. Query text: UPDATE `#__scheduler_tasks` SET `title` = 'Rotate Logs' WHERE `type` = 'rotation.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-06. Query text: UPDATE `#__scheduler_tasks` SET `title` = 'Session GC' WHERE `type` = 'session.g.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-06. Query text: UPDATE `#__scheduler_tasks` SET `title` = 'Update Notification' WHERE `type` = '.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-09. Query text: INSERT INTO `#__action_logs_extensions` (`extension`) VALUES ('com_fields');.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-09. Query text: INSERT INTO `#__action_log_config` (`type_title`, `type_alias`, `id_holder`, `ti.
2023-10-19T05:56:31+00:00	INFO ::1	update	Ran query from file 5.0.0-2023-09-11. Query text: UPDATE `#__extensions` SET `enabled` = 1 WHERE `type` = 'plugin' AND `element` =.
2023-10-19T05:56:31+00:00	INFO ::1	update	End of SQL updates.
2023-10-19T05:56:31+00:00	INFO ::1	update	Uninstalling extensions
2023-10-19T05:56:31+00:00	WARNING ::1	jerror	Joomla\Filesystem\File::delete: Failed deleting inaccessible file plg_task_demotasks.ini
2023-10-19T05:56:32+00:00	WARNING ::1	jerror	Joomla\Filesystem\File::delete: Failed deleting inaccessible file plg_system_logrotation.ini
2023-10-19T05:56:32+00:00	WARNING ::1	jerror	Joomla\Filesystem\File::delete: Failed deleting inaccessible file plg_captcha_recaptcha.ini
2023-10-19T05:56:32+00:00	WARNING ::1	jerror	Joomla\Filesystem\File::delete: Failed deleting inaccessible file plg_system_sessiongc.ini
2023-10-19T05:56:32+00:00	WARNING ::1	jerror	Joomla\Filesystem\File::delete: Failed deleting inaccessible file plg_system_updatenotification.ini
2023-10-19T05:56:32+00:00	INFO ::1	update	Deleting removed files and folders.
2023-10-19T05:56:36+00:00	INFO ::1	update	Cleaning up after installation.
2023-10-19T05:56:37+00:00	INFO ::1	update	Update to version 5.0.0 is complete.
