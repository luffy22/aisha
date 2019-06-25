#
#<?php die('Forbidden.'); ?>
#Date: 2019-06-21 05:47:12 UTC
#Software: Joomla Platform 13.1.0 Stable [ Curiosity ] 24-Apr-2013 00:00 GMT

#Fields: datetime	priority clientip	category	message
2019-06-21T05:47:12+00:00	INFO ::1	update	Update started by user Astro Isha (222). Old version is 3.9.1.
2019-06-21T05:47:17+00:00	INFO ::1	update	Downloading update file from https://s3-us-west-2.amazonaws.com/joomla-official-downloads/joomladownloads/joomla3/Joomla_3.9.8-Stable-Update_Package.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAIZ6S3Q3YQHG57ZRA%2F20190621%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20190621T054714Z&X-Amz-Expires=60&X-Amz-SignedHeaders=host&X-Amz-Signature=45e5cc8ac42a41c059423f5143a79ee39f12ba53475848b8c58d211ada2a29c1.
2019-06-21T05:48:07+00:00	INFO ::1	update	File Joomla_3.9.8-Stable-Update_Package.zip downloaded.
2019-06-21T05:48:07+00:00	INFO ::1	update	Starting installation of new version.
2019-06-21T05:48:13+00:00	INFO ::1	update	Finalising installation.
2019-06-21T05:48:13+00:00	INFO ::1	update	Ran query from file 3.9.3-2019-01-12. Query text: UPDATE `#__extensions`  SET `params` = REPLACE(`params`, '"com_categories",', '".
2019-06-21T05:48:13+00:00	INFO ::1	update	Ran query from file 3.9.3-2019-01-12. Query text: INSERT INTO `#__action_logs_extensions` (`extension`) VALUES ('com_checkin');.
2019-06-21T05:48:13+00:00	INFO ::1	update	Ran query from file 3.9.3-2019-02-07. Query text: INSERT INTO `#__postinstall_messages` (`extension_id`, `title_key`, `description.
2019-06-21T05:48:14+00:00	INFO ::1	update	Ran query from file 3.9.7-2019-04-23. Query text: ALTER TABLE `#__session` ADD INDEX `client_id_guest` (`client_id`, `guest`);.
2019-06-21T05:48:14+00:00	INFO ::1	update	Ran query from file 3.9.7-2019-04-26. Query text: UPDATE `#__content_types` SET `content_history_options` = REPLACE(`content_histo.
2019-06-21T05:48:14+00:00	INFO ::1	update	Ran query from file 3.9.8-2019-06-11. Query text: UPDATE #__users SET params = REPLACE(params, '",,"', '","');.
2019-06-21T05:48:14+00:00	INFO ::1	update	Deleting removed files and folders.
2019-06-21T05:48:26+00:00	INFO ::1	update	Cleaning up after installation.
2019-06-21T05:48:26+00:00	INFO ::1	update	Update to version 3.9.8 is complete.
