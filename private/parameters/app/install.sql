DROP TABLE IF EXISTS `{prefix}users`;
CREATE TABLE `{prefix}users` (
  `ID` int(11) NOT NULL COMMENT 'id de l''utilisateur',
  `fname` text COMMENT 'prénom de l''utilisateur',
  `name` text COMMENT 'nom de l''utilisateur',
  `type` int(11) NOT NULL COMMENT 'type de l''utilisateur',
  `email` varchar(255) NOT NULL COMMENT 'email de l''utilisateur',
  `pwd` text COMMENT 'mdp de l''utilisateur',
  `phone` text COMMENT 'tel de l''utilisateur',
  `address` text COMMENT 'adresse de l''utilisateur',
  `zip_code` text COMMENT 'code postal',
  `city` text COMMENT 'ville de résidence',
  `country` varchar(2) DEFAULT NULL COMMENT 'pays',
  `language` varchar(5) DEFAULT NULL COMMENT 'langue de l''utilisateur',
  `registration_date` datetime NOT NULL COMMENT 'date d''enregistrement',
  `activation_date` datetime DEFAULT NULL COMMENT 'date d''activation',
  `delete_date` datetime DEFAULT NULL COMMENT 'date de suppression',
  `last_login_date` datetime DEFAULT NULL COMMENT 'date de dernière connexion',
  `publication_entitled` tinyint(1) DEFAULT '0' COMMENT 'drapeau de droit à la publication'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des utilisateurs';

DROP TABLE IF EXISTS `{prefix}students`;
CREATE TABLE `{prefix}students` (
  `ID` int(11) NOT NULL COMMENT 'id de l''étudiant',
  `ID_TE` int(11) NOT NULL COMMENT 'id du tuteur entreprise',
  `ID_TI` int(11) NOT NULL COMMENT 'id du tuteur IUT',
  `name` text NOT NULL COMMENT 'nom de l''étudiant',
  `fname` text NOT NULL COMMENT 'prénom de l''étudiant',
  `group` text NOT NULL COMMENT 'groupe de l''étudiant',
  `email` text COMMENT 'email del''étudiant',
  `phone` text COMMENT 'tel de l''étudiant',
  `address` text COMMENT 'adresse de l''étudiant',
  `zip_code` text COMMENT 'code postal',
  `city` text COMMENT 'ville de résidence',
  `country` varchar(2) DEFAULT NULL COMMENT 'pays',
  `birth_date` date DEFAULT NULL COMMENT 'date de naissance de l''étudiant',
  `informations` longtext COMMENT 'informations sur l''étudiant',
  `creation_date` datetime NOT NULL COMMENT 'date de création',
  `delete_date` datetime DEFAULT NULL COMMENT 'Drapeau de la suppression de l’étudiant',
  `deadline_date` date NOT NULL COMMENT 'date butoire du questionnaire',
  `answered` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Drapeau de réponse au questionnaire',
  `answers_is_valided` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Drapeau de validation du questionnaire'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des étudiants';

DROP TABLE IF EXISTS `{prefix}action_report`;
CREATE TABLE `{prefix}action_report` (
  `ID` int(11) NOT NULL COMMENT 'Identifiant de l''action',
  `ID_USER` int(11) DEFAULT NULL COMMENT 'Identifiant de l''utilisateur liès à l''action',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description de l''action',
  `requested_date` datetime NOT NULL COMMENT 'Date de l''action'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `{prefix}messages`;
CREATE TABLE `{prefix}messages` (
  `ID` int(11) NOT NULL COMMENT 'id du message',
  `id_sender` int(11) NOT NULL COMMENT 'id de l''expéditeur',
  `id_recipient` int(11) NOT NULL COMMENT 'id du destinataire',
  `object` text NOT NULL COMMENT 'objet du message',
  `content` text NOT NULL COMMENT 'contenu du message',
  `viewed` tinyint(1) DEFAULT NULL COMMENT 'drapeau de vue',
  `deleted` tinyint(1) DEFAULT NULL COMMENT 'drapeau de suppression',
  `id_respond` int(11) DEFAULT NULL COMMENT 'id du message auquel on répond',
  `send_date` datetime NOT NULL COMMENT 'date d''envoi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tables des messages';

DROP TABLE IF EXISTS `{prefix}notifications`;
CREATE TABLE `{prefix}notifications` (
  `ID` int(11) NOT NULL COMMENT 'id de la notification',
  `ID_USER` int(11) DEFAULT NULL COMMENT 'identifiant de l''utilisateur lié à la notification',
  `content` text NOT NULL COMMENT 'contenu de la notification',
  `link` text COMMENT 'lien de la notification',
  `viewed` tinyint(1) DEFAULT NULL COMMENT 'drapeau de vue de la notification',
  `requested_date` datetime NOT NULL COMMENT 'date de requête',
  `deleted` tinyint(1) DEFAULT NULL COMMENT 'drapeau de suppression'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des notifications';

DROP TABLE IF EXISTS `{prefix}posts`;
CREATE TABLE `{prefix}posts` (
  `ID` int(11) NOT NULL COMMENT 'identifiant de la publication',
  `ID_USER` int(11) NOT NULL COMMENT 'identifiant de l''utilisateur publicateur',
  `content` text NOT NULL COMMENT 'contenu de la publication',
  `deleted` tinyint(1) DEFAULT NULL COMMENT 'drapeau de suppression de la publication',
  `publication_date` datetime NOT NULL COMMENT 'date de publication'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des posts des utilisateurs';

DROP TABLE IF EXISTS `{prefix}stats`;
CREATE TABLE `{prefix}stats` (
  `ID` int(11) NOT NULL COMMENT 'identifiant de la statistique',
  `ID_USER` int(11) NOT NULL COMMENT 'identifiant de l''utilisateur',
  `page_viewed` text NOT NULL COMMENT 'page vue',
  `ip_viewer` text COMMENT 'adresse IP de l''utilisateur',
  `country_viewer` varchar(2) DEFAULT NULL COMMENT 'pays de l''utilisateur',
  `platform_viewer` text COMMENT 'plateforme de l''utilisateur',
  `os_viewer` text COMMENT 'système d''exploitation del''utilisateur',
  `browser_viewer` text COMMENT 'navigateur de l''utilisateur',
  `viewing_date` datetime NOT NULL COMMENT 'date de chargement de la page'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table de statistiques enregistrées';

DROP TABLE IF EXISTS `{prefix}answers`;
CREATE TABLE `{prefix}answers` (
  `ID` int(11) NOT NULL COMMENT 'id de la réponse',
  `ID_student` int(11) NOT NULL COMMENT 'id de l''étudiant',
  `id_survey` int(11) NOT NULL COMMENT 'id du questionnaire',
  `id_question` int(11) NOT NULL COMMENT 'id de la question',
  `id_answer` int(11) NOT NULL COMMENT 'id de la réponse',
  `comments` longtext COMMENT 'commentaires de la réponse',
  `request_date` datetime NOT NULL COMMENT 'date de la requete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des réponses';

DROP TABLE IF EXISTS `{prefix}message_attachments`;
CREATE TABLE `{prefix}message_attachments` (
  `ID` int(11) NOT NULL COMMENT 'id de la pièce jointe',
  `ID_message` int(11) NOT NULL COMMENT 'id du message',
  `link` text NOT NULL COMMENT 'lien de la pièce jointe',
  `description` text COMMENT 'description de la pièce jointe',
  `type_file` text NOT NULL COMMENT 'type de la pièce jointe'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des pièces jointes';

DROP TABLE IF EXISTS `{prefix}posts_comments`;
CREATE TABLE `{prefix}posts_comments` (
  `ID` int(11) NOT NULL COMMENT 'identifiant du commentaire',
  `ID_POST` int(11) NOT NULL COMMENT 'identifiant de la publication',
  `ID_USER` int(11) NOT NULL COMMENT 'identifiant de l''utilisateur',
  `content` text NOT NULL COMMENT 'contenu du commentaire',
  `deleted` tinyint(1) DEFAULT NULL COMMENT 'drapeau de suppression',
  `publication_date` datetime NOT NULL COMMENT 'date de publication'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des commentaires des posts';

DROP TABLE IF EXISTS `{prefix}posts_attachments`;
CREATE TABLE `{prefix}posts_attachments` (
  `ID` int(11) NOT NULL COMMENT 'identifiant de la pièce jointe',
  `ID_POST` int(11) NOT NULL COMMENT 'identifiant de la publication',
  `link` text NOT NULL COMMENT 'len de la pièce jointe',
  `description` text COMMENT 'description de la pièce jointe',
  `type_file` text NOT NULL COMMENT 'type de la pièce jointe'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table de pièces jointes des posts';

DROP TABLE IF EXISTS `{prefix}liked_post`;
CREATE TABLE `{prefix}liked_post` (
  `ID` int(11) NOT NULL COMMENT 'identifiant du "like"',
  `ID_POST` int(11) NOT NULL COMMENT 'identifiant de la publication "likée"',
  `ID_USER` int(11) NOT NULL COMMENT 'identifiant de l''utilisateur qui a "liké"',
  `requested_date` datetime NOT NULL COMMENT 'date du "like"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des likes';

ALTER TABLE `{prefix}action_report`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

ALTER TABLE `{prefix}answers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID_student_2` (`ID_student`,`id_survey`,`id_question`),
  ADD KEY `ID_student` (`ID_student`);

ALTER TABLE `{prefix}liked_post`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID_POST_2` (`ID_POST`,`ID_USER`),
  ADD KEY `ID_POST` (`ID_POST`,`ID_USER`),
  ADD KEY `ID_USER` (`ID_USER`);

ALTER TABLE `{prefix}messages`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_sender` (`id_sender`,`id_recipient`,`id_respond`),
  ADD KEY `id_recipient` (`id_recipient`);

ALTER TABLE `{prefix}message_attachments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_message` (`ID_message`);

ALTER TABLE `{prefix}notifications`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

ALTER TABLE `{prefix}posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

ALTER TABLE `{prefix}posts_attachments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_POST` (`ID_POST`);

ALTER TABLE `{prefix}posts_comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_POST` (`ID_POST`,`ID_USER`),
  ADD KEY `ID_USER` (`ID_USER`);

ALTER TABLE `{prefix}stats`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

ALTER TABLE `{prefix}students`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_TE` (`ID_TE`,`ID_TI`),
  ADD KEY `ID_TI` (`ID_TI`);

ALTER TABLE `{prefix}users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `{prefix}action_report`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de l''action', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}answers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la réponse', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}liked_post`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant du "like"', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}messages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id du message', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}message_attachments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la pièce jointe';
ALTER TABLE `{prefix}notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la notification', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la publication', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}posts_attachments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la pièce jointe', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}posts_comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant du commentaire', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}stats`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la statistique', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}students`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de l''étudiant', AUTO_INCREMENT=1;
ALTER TABLE `{prefix}users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de l''utilisateur', AUTO_INCREMENT=1;

ALTER TABLE `{prefix}action_report`
  ADD CONSTRAINT `{prefix}action_report_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}answers`
  ADD CONSTRAINT `{prefix}answers_ibfk_1` FOREIGN KEY (`ID_student`) REFERENCES `{prefix}students` (`ID`);

ALTER TABLE `{prefix}liked_post`
  ADD CONSTRAINT `{prefix}liked_post_ibfk_1` FOREIGN KEY (`ID_POST`) REFERENCES `{prefix}posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `{prefix}liked_post_ibfk_2` FOREIGN KEY (`ID_USER`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}messages`
  ADD CONSTRAINT `{prefix}messages_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `{prefix}messages_ibfk_2` FOREIGN KEY (`id_recipient`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}message_attachments`
  ADD CONSTRAINT `{prefix}message_attachments_ibfk_1` FOREIGN KEY (`ID_message`) REFERENCES `{prefix}messages` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}notifications`
  ADD CONSTRAINT `{prefix}notifications_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}posts`
  ADD CONSTRAINT `{prefix}posts_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}posts_attachments`
  ADD CONSTRAINT `{prefix}posts_attachments_ibfk_1` FOREIGN KEY (`ID_POST`) REFERENCES `{prefix}posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}posts_comments`
  ADD CONSTRAINT `{prefix}posts_comments_ibfk_2` FOREIGN KEY (`ID_USER`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `{prefix}posts_comments_ibfk_1` FOREIGN KEY (`ID_POST`) REFERENCES `{prefix}posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}stats`
  ADD CONSTRAINT `{prefix}stats_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{prefix}students`
  ADD CONSTRAINT `{prefix}students_ibfk_1` FOREIGN KEY (`ID_TE`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `{prefix}students_ibfk_2` FOREIGN KEY (`ID_TI`) REFERENCES `{prefix}users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

DROP TABLE IF EXISTS `{prefix}show_action_report`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_action_report`  AS  select `{prefix}action_report`.`ID` AS `ID`,`{prefix}action_report`.`ID_USER` AS `ID_USER`,`{prefix}action_report`.`content` AS `content`,`{prefix}action_report`.`requested_date` AS `requested_date` from `{prefix}action_report` ;

DROP TABLE IF EXISTS `show_all_students`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_all_students`  AS  select `{prefix}students`.`ID` AS `ID`,`{prefix}students`.`ID_TE` AS `ID_TE`,`{prefix}students`.`ID_TI` AS `ID_TI`,`{prefix}students`.`name` AS `name`,`{prefix}students`.`fname` AS `fname`,`{prefix}students`.`group` AS `group`,`{prefix}students`.`email` AS `email`,`{prefix}students`.`phone` AS `phone`,`{prefix}students`.`address` AS `address`,`{prefix}students`.`zip_code` AS `zip_code`,`{prefix}students`.`city` AS `city`,`{prefix}students`.`country` AS `country`,`{prefix}students`.`birth_date` AS `birth_date`,`{prefix}students`.`informations` AS `informations`,`{prefix}students`.`creation_date` AS `creation_date`,`{prefix}students`.`delete_date` AS `delete_date`,`{prefix}students`.`deadline_date` AS `deadline_date`,`{prefix}students`.`answered` AS `answered`,`{prefix}students`.`answers_is_valided` AS `answers_is_valided`,concat(`u1`.`fname`,' ',`u1`.`name`) AS `name_TE`,concat(`u2`.`fname`,' ',`u2`.`name`) AS `name_TI` from ((`{prefix}students` join `{prefix}users` `u1`) join `{prefix}users` `u2`) where ((`{prefix}students`.`ID_TE` = `u1`.`ID`) and (`{prefix}students`.`ID_TI` = `u2`.`ID`)) ;

DROP TABLE IF EXISTS `{prefix}show_last_stats_by_user`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_last_stats_by_user`  AS  select max(`{prefix}stats`.`viewing_date`) AS `viewing_date`,`{prefix}stats`.`ID_USER` AS `ID_USER`,`{prefix}stats`.`ip_viewer` AS `last_ip_viewer`,`{prefix}stats`.`country_viewer` AS `country_viewer`,`{prefix}stats`.`platform_viewer` AS `platform_viewer`,`{prefix}stats`.`os_viewer` AS `os_viewer`,`{prefix}stats`.`browser_viewer` AS `browser_viewer` from `{prefix}stats` group by `{prefix}stats`.`ID_USER` ;

DROP TABLE IF EXISTS `{prefix}show_all_users`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_all_users`  AS  select `{prefix}users`.`ID` AS `ID`,`{prefix}users`.`name` AS `name`,`{prefix}users`.`fname` AS `fname`,`{prefix}users`.`type` AS `type`,`{prefix}users`.`email` AS `email`,`{prefix}users`.`phone` AS `phone`,`{prefix}users`.`address` AS `address`,`{prefix}users`.`zip_code` AS `zip_code`,`{prefix}users`.`city` AS `city`,`{prefix}users`.`country` AS `country`,`{prefix}users`.`language` AS `language`,`{prefix}users`.`registration_date` AS `registration_date`,`{prefix}users`.`activation_date` AS `activation_date`,`{prefix}users`.`delete_date` AS `delete_date`,`{prefix}users`.`last_login_date` AS `last_login_date`,`{prefix}users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`{prefix}users`.`activation_date`) then 0 else 1 end) AS `activated` from (`{prefix}users` left join `{prefix}show_last_stats_by_user` `s1` on((`{prefix}users`.`ID` = `s1`.`ID_USER`))) where isnull(`{prefix}users`.`delete_date`) ;

DROP TABLE IF EXISTS `{prefix}show_answered_students`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_answered_students`  AS  select `{prefix}students`.`ID` AS `ID`,`{prefix}students`.`ID_TE` AS `ID_TE`,`{prefix}students`.`ID_TI` AS `ID_TI`,`{prefix}students`.`name` AS `name`,`{prefix}students`.`fname` AS `fname`,`{prefix}students`.`group` AS `group`,`{prefix}students`.`email` AS `email`,`{prefix}students`.`phone` AS `phone`,`{prefix}students`.`address` AS `address`,`{prefix}students`.`zip_code` AS `zip_code`,`{prefix}students`.`city` AS `city`,`{prefix}students`.`country` AS `country`,`{prefix}students`.`birth_date` AS `birth_date`,`{prefix}students`.`informations` AS `informations`,`{prefix}students`.`creation_date` AS `creation_date`,`{prefix}students`.`delete_date` AS `delete_date`,`{prefix}students`.`deadline_date` AS `deadline_date`,`{prefix}students`.`answered` AS `answered`,concat(`u1`.`fname`,' ',`u1`.`name`) AS `name_TE`,concat(`u2`.`fname`,' ',`u2`.`name`) AS `name_TI` from ((`{prefix}students` join `{prefix}users` `u1`) join `{prefix}users` `u2`) where ((`{prefix}students`.`ID_TE` = `u1`.`ID`) and (`{prefix}students`.`ID_TI` = `u2`.`ID`) and (`{prefix}students`.`answered` = 1)) ;

DROP TABLE IF EXISTS `{prefix}show_deleted_students`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_deleted_students`  AS  select `{prefix}students`.`ID` AS `ID`,`{prefix}students`.`ID_TE` AS `ID_TE`,`{prefix}students`.`ID_TI` AS `ID_TI`,`{prefix}students`.`name` AS `name`,`{prefix}students`.`fname` AS `fname`,`{prefix}students`.`group` AS `group`,`{prefix}students`.`email` AS `email`,`{prefix}students`.`phone` AS `phone`,`{prefix}students`.`address` AS `address`,`{prefix}students`.`zip_code` AS `zip_code`,`{prefix}students`.`city` AS `city`,`{prefix}students`.`country` AS `country`,`{prefix}students`.`birth_date` AS `birth_date`,`{prefix}students`.`informations` AS `informations`,`{prefix}students`.`creation_date` AS `creation_date`,`{prefix}students`.`delete_date` AS `delete_date`,`{prefix}students`.`deadline_date` AS `deadline_date`,`{prefix}students`.`answered` AS `answered`,`{prefix}students`.`answers_is_valided` AS `answers_is_valided`,concat(`u1`.`fname`,' ',`u1`.`name`) AS `name_TE`,concat(`u2`.`fname`,' ',`u2`.`name`) AS `name_TI` from ((`{prefix}students` join `{prefix}users` `u1`) join `{prefix}users` `u2`) where ((`{prefix}students`.`ID_TE` = `u1`.`ID`) and (`{prefix}students`.`ID_TI` = `u2`.`ID`) and (`{prefix}students`.`delete_date` is not null)) ;

DROP TABLE IF EXISTS `{prefix}show_deleted_users`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_deleted_users`  AS  select `{prefix}users`.`ID` AS `ID`,`{prefix}users`.`name` AS `name`,`{prefix}users`.`fname` AS `fname`,`{prefix}users`.`type` AS `type`,`{prefix}users`.`email` AS `email`,`{prefix}users`.`pwd` AS `pwd`,`{prefix}users`.`phone` AS `phone`,`{prefix}users`.`address` AS `address`,`{prefix}users`.`zip_code` AS `zip_code`,`{prefix}users`.`city` AS `city`,`{prefix}users`.`country` AS `country`,`{prefix}users`.`language` AS `language`,`{prefix}users`.`registration_date` AS `registration_date`,`{prefix}users`.`activation_date` AS `activation_date`,`{prefix}users`.`delete_date` AS `delete_date`,`{prefix}users`.`last_login_date` AS `last_login_date`,`{prefix}users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`{prefix}users`.`activation_date`) then 0 else 1 end) AS `activated` from (`{prefix}users` left join `{prefix}show_last_stats_by_user` `s1` on((`{prefix}users`.`ID` = `s1`.`ID_USER`))) where (`{prefix}users`.`delete_date` is not null) ;

DROP TABLE IF EXISTS `{prefix}show_posts`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_posts`  AS  select `{prefix}posts`.`ID` AS `ID`,`{prefix}posts`.`ID_USER` AS `ID_USER`,`{prefix}posts`.`content` AS `content`,`{prefix}posts`.`deleted` AS `deleted`,`{prefix}posts`.`publication_date` AS `publication_date` from `{prefix}posts` order by `{prefix}posts`.`publication_date` desc ;

DROP TABLE IF EXISTS `{prefix}show_te_users`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_te_users`  AS  select `{prefix}users`.`ID` AS `ID`,`{prefix}users`.`name` AS `name`,`{prefix}users`.`fname` AS `fname`,`{prefix}users`.`type` AS `type`,`{prefix}users`.`email` AS `email`,`{prefix}users`.`pwd` AS `pwd`,`{prefix}users`.`phone` AS `phone`,`{prefix}users`.`address` AS `address`,`{prefix}users`.`zip_code` AS `zip_code`,`{prefix}users`.`city` AS `city`,`{prefix}users`.`country` AS `country`,`{prefix}users`.`language` AS `language`,`{prefix}users`.`registration_date` AS `registration_date`,`{prefix}users`.`activation_date` AS `activation_date`,`{prefix}users`.`delete_date` AS `delete_date`,`{prefix}users`.`last_login_date` AS `last_login_date`,`{prefix}users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`{prefix}users`.`activation_date`) then 0 else 1 end) AS `activated` from (`{prefix}users` left join `{prefix}show_last_stats_by_user` `s1` on((`{prefix}users`.`ID` = `s1`.`ID_USER`))) where (isnull(`{prefix}users`.`delete_date`) and (`{prefix}users`.`type` = 2)) ;

DROP TABLE IF EXISTS `{prefix}show_ti_users`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_ti_users`  AS  select `{prefix}users`.`ID` AS `ID`,`{prefix}users`.`name` AS `name`,`{prefix}users`.`fname` AS `fname`,`{prefix}users`.`type` AS `type`,`{prefix}users`.`email` AS `email`,`{prefix}users`.`pwd` AS `pwd`,`{prefix}users`.`phone` AS `phone`,`{prefix}users`.`address` AS `address`,`{prefix}users`.`zip_code` AS `zip_code`,`{prefix}users`.`city` AS `city`,`{prefix}users`.`country` AS `country`,`{prefix}users`.`language` AS `language`,`{prefix}users`.`registration_date` AS `registration_date`,`{prefix}users`.`activation_date` AS `activation_date`,`{prefix}users`.`delete_date` AS `delete_date`,`{prefix}users`.`last_login_date` AS `last_login_date`,`{prefix}users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`{prefix}users`.`activation_date`) then 0 else 1 end) AS `activated` from (`{prefix}users` left join `{prefix}show_last_stats_by_user` `s1` on((`{prefix}users`.`ID` = `s1`.`ID_USER`))) where (isnull(`{prefix}users`.`delete_date`) and (`{prefix}users`.`type` = 3)) ;

DROP TABLE IF EXISTS `{prefix}show_unactivated_users`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `{prefix}show_unactivated_users`  AS  select `{prefix}users`.`ID` AS `ID`,`{prefix}users`.`name` AS `name`,`{prefix}users`.`fname` AS `fname`,`{prefix}users`.`type` AS `type`,`{prefix}users`.`email` AS `email`,`{prefix}users`.`pwd` AS `pwd`,`{prefix}users`.`phone` AS `phone`,`{prefix}users`.`address` AS `address`,`{prefix}users`.`zip_code` AS `zip_code`,`{prefix}users`.`city` AS `city`,`{prefix}users`.`country` AS `country`,`{prefix}users`.`language` AS `language`,`{prefix}users`.`registration_date` AS `registration_date`,`{prefix}users`.`activation_date` AS `activation_date`,`{prefix}users`.`delete_date` AS `delete_date`,`{prefix}users`.`last_login_date` AS `last_login_date`,`{prefix}users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`{prefix}users`.`activation_date`) then 0 else 1 end) AS `activated` from (`{prefix}users` left join `{prefix}show_last_stats_by_user` `s1` on((`{prefix}users`.`ID` = `s1`.`ID_USER`))) where (isnull(`{prefix}users`.`delete_date`) and isnull(`{prefix}users`.`activation_date`)) ;



DROP PROCEDURE IF EXISTS `{prefix}activate_user`;
CREATE  PROCEDURE `{prefix}activate_user` (IN `id_user` INT)  BEGIN
UPDATE {prefix}users SET activation_date=NOW() WHERE ID=id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}add_answer`;
CREATE  PROCEDURE `{prefix}add_answer` (IN `param_id_student` INT, IN `param_id_survey` INT, IN `param_id_question` INT, IN `param_id_answer` INT, IN `param_comments` LONGTEXT)  BEGIN
INSERT INTO {prefix}answers(ID_student, id_survey, id_question, id_answer, comments, request_date)
    VALUES(param_id_student,param_id_survey,param_id_question,param_id_answer,param_comments,NOW());
END;

DROP PROCEDURE IF EXISTS `{prefix}add_comment`;
CREATE  PROCEDURE `{prefix}add_comment` (IN `param_id_post` INT, IN `param_id_user` INT, IN `param_content` TEXT)  INSERT INTO {prefix}posts_comments(ID_POST, ID_USER, content, publication_date)
    VALUES(param_id_post, param_id_user, param_content, NOW());

DROP PROCEDURE IF EXISTS `{prefix}add_message_attachment`;
CREATE PROCEDURE `{prefix}add_message_attachment`(IN `param_id_message` INT, IN `param_link` TEXT, IN `param_description` TEXT, IN `param_type_file` TEXT ) BEGIN
INSERT INTO {prefix}message_attachments(ID_message, link, description, type_file)
    VALUES(param_id_message, param_link, param_description, param_type_file);
END;

DROP PROCEDURE IF EXISTS `{prefix}add_notification`;
CREATE  PROCEDURE `{prefix}add_notification` (IN `param_id_user` INT, IN `param_content` TEXT, IN `param_link` TEXT)  BEGIN
INSERT INTO {prefix}notifications(ID_USER, content, link, requested_date)
    VALUES (param_id_user,param_content,param_link,NOW());
END;

DROP PROCEDURE IF EXISTS `{prefix}add_post`;
CREATE  PROCEDURE `{prefix}add_post` (IN `param_id_user` INT, IN `param_content` TEXT)  BEGIN
INSERT INTO {prefix}posts(ID_USER, content, publication_date)
  VALUES (param_id_user,param_content,NOW());
END;

DROP PROCEDURE IF EXISTS `{prefix}add_post_attachement`;
CREATE  PROCEDURE `{prefix}add_post_attachement` (IN `param_id_post` INT, IN `param_link` TEXT, IN `param_description` TEXT, IN `param_type_file` TEXT)  BEGIN
INSERT INTO {prefix}posts_attachments(ID_POST, link, description, type_file)
  VALUES (param_id_post,param_link,param_description,param_type_file);
END;

DROP PROCEDURE IF EXISTS `{prefix}add_statistic`;
CREATE  PROCEDURE `{prefix}add_statistic` (IN `param_id_user` INT, IN `param_page_viewed` TEXT, IN `param_ip_viewer` TEXT, IN `param_country_viewer` VARCHAR(2), IN `param_platform_viewer` TEXT, IN `param_os_viewer` TEXT, IN `param_browser_viewer` TEXT)  BEGIN
INSERT INTO {prefix}stats(ID_USER, page_viewed, ip_viewer, country_viewer, platform_viewer, os_viewer, browser_viewer, viewing_date)
    VALUES(param_id_user,param_page_viewed,param_ip_viewer,param_country_viewer,param_platform_viewer,param_os_viewer,param_browser_viewer,NOW());
END;

DROP PROCEDURE IF EXISTS `{prefix}add_student`;
CREATE  PROCEDURE `{prefix}add_student` (IN `param_id_te` INT, IN `param_id_ti` INT, IN `param_name` TEXT, IN `param_fname` TEXT, IN `param_group` TEXT, IN `param_email` TEXT, IN `param_phone` TEXT, IN `param_address` TEXT, IN `param_zip_code` TEXT, IN `param_city` TEXT, IN `param_country` VARCHAR(2), IN `param_birth_date` TEXT, IN `param_information` LONGTEXT, IN `param_deadline_date` DATE)  BEGIN
INSERT INTO {prefix}students(ID_TE,ID_TI,name,fname,`group`,email,phone,address,zip_code,city,country,birth_date,informations,creation_date,deadline_date)
    VALUES (param_id_te,param_id_ti,param_name,param_fname,param_group,param_email,param_phone,param_address,param_zip_code,param_city,param_country,param_birth_date,param_information,NOW(),param_deadline_date);
END;

DROP PROCEDURE IF EXISTS `{prefix}add_user`;
CREATE  PROCEDURE `{prefix}add_user` (IN `param_name` TEXT, IN `param_fname` TEXT, IN `param_type` INT, IN `param_email` TEXT, IN `param_phone` TEXT, IN `param_address` TEXT, IN `param_zip_code` TEXT, IN `param_city` TEXT, IN `param_country` VARCHAR(2), IN `param_language` VARCHAR(5), IN `param_publication_entitled` TINYINT)  BEGIN
INSERT INTO {prefix}users (name, fname, type, email, phone, address, zip_code, city, country, language, registration_date, publication_entitled
) VALUES (param_name, param_fname, param_type, param_email, param_phone, param_address, param_zip_code, param_city, param_country, param_language, NOW(), param_publication_entitled);
END;

DROP PROCEDURE IF EXISTS `{prefix}autorize_to_publish`;
CREATE  PROCEDURE `{prefix}autorize_to_publish` (IN `id_user` INT)  BEGIN
UPDATE {prefix}users SET publication_entitled=1 WHERE ID=id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}change_password`;
CREATE  PROCEDURE `{prefix}change_password` (IN `id_user` INT, IN `param_password` TEXT)  BEGIN
UPDATE {prefix}users SET pwd=md5(param_password) WHERE ID=id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}delete_all_answer`;
CREATE  PROCEDURE `{prefix}delete_all_answer` (IN `param_id_student` INT)  BEGIN
DELETE FROM {prefix}answers WHERE ID_student=param_id_student;
CALL {prefix}update_answer_status(param_id_student,FALSE);
END;

DROP PROCEDURE IF EXISTS `{prefix}delete_all_answer_for_all_students`;
CREATE  PROCEDURE `{prefix}delete_all_answer_for_all_students` ()  BEGIN
DELETE FROM {prefix}answers;
UPDATE {prefix}students SET answered=FALSE;
END;

DROP PROCEDURE IF EXISTS `{prefix}delete_all_message`;
CREATE  PROCEDURE `{prefix}delete_all_message` (IN `param_id_user` INT)  BEGIN
UPDATE {prefix}messages SET deleted = 1 WHERE id_recipient=param_id_user OR id_sender=param_id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}delete_all_students`;
CREATE  PROCEDURE `{prefix}delete_all_students` ()  BEGIN
UPDATE {prefix}students SET
  delete_date = NOW();
END;

DROP PROCEDURE IF EXISTS `{prefix}delete_all_user`;
CREATE  PROCEDURE `{prefix}delete_all_user` ()  BEGIN
UPDATE {prefix}users SET delete_date=NOW();
END;

DROP PROCEDURE IF EXISTS `{prefix}delete_answer`;
CREATE  PROCEDURE `{prefix}delete_answer` (IN `param_id_answer` INT)  BEGIN
DELETE FROM {prefix}answers WHERE ID=param_id_answer;
END;

DROP PROCEDURE IF EXISTS `{prefix}delete_comment`;
CREATE  PROCEDURE `{prefix}delete_comment` (IN `param_id_postC` INT)  DELETE FROM {prefix}posts_comments WHERE ID=param_id_postC;

DROP PROCEDURE IF EXISTS `{prefix}delete_group_message`;
CREATE  PROCEDURE `{prefix}delete_group_message` (IN `param_id_sender` INT, IN `param_id_recipient` INT)  UPDATE {prefix}messages SET deleted = 1 WHERE id_recipient=param_id_recipient AND id_sender=param_id_sender;

DROP PROCEDURE IF EXISTS `{prefix}delete_message`;
CREATE  PROCEDURE `{prefix}delete_message` (IN `param_id_message` INT)  UPDATE {prefix}messages SET deleted = 1 WHERE ID=param_id_message;

DROP PROCEDURE IF EXISTS `{prefix}delete_notification`;
CREATE  PROCEDURE `{prefix}delete_notification` (IN `param_id_notification` INT)  UPDATE {prefix}notifications SET
  deleted = 1
WHERE ID=1;

DROP PROCEDURE IF EXISTS `{prefix}delete_post`;
CREATE  PROCEDURE `{prefix}delete_post` (IN `param_id_post` INT)  DELETE FROM {prefix}posts WHERE ID=param_id_post;

DROP PROCEDURE IF EXISTS `{prefix}delete_post_attachments`;
CREATE  PROCEDURE `{prefix}delete_post_attachments` (IN `param_id_postA` INT)  DELETE FROM {prefix}posts_attachments WHERE ID=param_id_postA;

DROP PROCEDURE IF EXISTS `{prefix}delete_statistic`;
CREATE  PROCEDURE `{prefix}delete_statistic` (IN `param_id_stat` INT)  DELETE FROM {prefix}stats WHERE ID=param_id_stat;

DROP PROCEDURE IF EXISTS `{prefix}delete_student`;
CREATE  PROCEDURE `{prefix}delete_student` (IN `param_id_student` INT)  BEGIN
UPDATE {prefix}students SET
  delete_date = NOW()
WHERE ID=param_id_student;
END;

DROP PROCEDURE IF EXISTS `{prefix}delete_user`;
CREATE  PROCEDURE `{prefix}delete_user` (IN `id_user` INT)  BEGIN
UPDATE {prefix}users SET delete_date=NOW() WHERE ID=id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}edit_comment`;
CREATE  PROCEDURE `{prefix}edit_comment` (IN `param_id_comment` INT, IN `param_content` TEXT)  BEGIN
UPDATE {prefix}posts_comments SET
  content = param_content
  WHERE ID=param_id_comment;
END;

DROP PROCEDURE IF EXISTS `{prefix}edit_deadline_date`;
CREATE  PROCEDURE `{prefix}edit_deadline_date` (IN `param_id_student` INT, IN `param_deadline_date` DATE)  BEGIN
UPDATE {prefix}students SET
  deadline_date = param_deadline_date
WHERE ID=param_id_student;
END;

DROP PROCEDURE IF EXISTS `{prefix}edit_student`;
CREATE  PROCEDURE `{prefix}edit_student` (IN `param_id_student` INT, IN `param_id_te` INT, IN `param_id_ti` INT, IN `param_name` TEXT, IN `param_fname` TEXT, IN `param_group` TEXT, IN `param_email` TEXT, IN `param_phone` TEXT, IN `param_address` TEXT, IN `param_zip_code` TEXT, IN `param_city` TEXT, IN `param_country` VARCHAR(2), IN `param_birth_date` DATE, IN `param_information` LONGTEXT, IN `param_deadline_date` DATE)  BEGIN
UPDATE {prefix}students SET
  ID_TE = param_id_te,
  ID_TI = param_id_ti,
  name = param_name,
  fname = param_fname,
  `group` = param_group,
  email = param_email,
  phone = param_phone,
  address = param_address,
  zip_code = param_zip_code,
  city = param_city,
  country = param_country,
  birth_date = param_birth_date,
  informations = param_information,
  deadline_date = param_deadline_date
WHERE ID=param_id_student;
END;

DROP PROCEDURE IF EXISTS `{prefix}edit_user`;
CREATE  PROCEDURE `{prefix}edit_user` (IN `param_ID` INT, IN `param_name` TEXT, IN `param_fname` TEXT, IN `param_email` TEXT, IN `param_phone` TEXT, IN `param_address` TEXT, IN `param_zip_code` TEXT, IN `param_city` TEXT, IN `param_country` VARCHAR(2), IN `param_language` VARCHAR(5))  BEGIN
UPDATE {prefix}users
SET
    name=param_name,
    fname=param_fname,
    email=param_email,
    phone=param_phone,
    address=param_address,
    zip_code=param_zip_code,
    city=param_city,
    country=param_country,
    language=param_language
WHERE ID=param_ID;
END;

DROP PROCEDURE IF EXISTS `{prefix}like_post`;
CREATE  PROCEDURE `{prefix}like_post` (IN `param_id_post` INT, IN `param__id_user` INT)  INSERT INTO {prefix}liked_post(ID_POST, ID_USER, requested_date)
  VALUES (param_id_post,param__id_user,NOW());

DROP PROCEDURE IF EXISTS `{prefix}publish_message`;
CREATE  PROCEDURE `{prefix}publish_message` (IN `param_id_sender` INT, IN `param_id_recipient` INT, IN `param_object` TEXT, IN `param_content` TEXT, IN `param_id_respond` INT)  INSERT INTO {prefix}messages (id_sender,id_recipient,object, content, id_respond, send_date)
VALUES (param_id_sender,param_id_recipient,param_object,param_content,param_id_respond,NOW());

DROP PROCEDURE IF EXISTS `{prefix}set_user_language`;
CREATE  PROCEDURE `{prefix}set_user_language` (IN `param_id_user` INT, IN `param_lang` VARCHAR(5))  BEGIN
UPDATE {prefix}users SET language=param_lang WHERE ID=param_id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}unable_to_publish`;
CREATE  PROCEDURE `{prefix}unable_to_publish` (IN `id_user` INT)  BEGIN
UPDATE {prefix}users SET publication_entitled=0 WHERE ID=id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}undelete_student`;
CREATE  PROCEDURE `{prefix}undelete_student` (IN `param_id_student` INT)  BEGIN
UPDATE {prefix}students SET
  delete_date = NULL
WHERE ID=param_id_student;
END;

DROP PROCEDURE IF EXISTS `{prefix}undelete_user`;
CREATE  PROCEDURE `{prefix}undelete_user` (IN `id_user` INT)  BEGIN
UPDATE {prefix}users SET delete_date=NULL WHERE ID=id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}unlike_post`;
CREATE  PROCEDURE `{prefix}unlike_post` (IN `param_id_post` INT, IN `param_id_user` INT)  DELETE FROM {prefix}liked_post
WHERE ID_POST=param_id_post AND ID_USER=param_id_user;

DROP PROCEDURE IF EXISTS `{prefix}update_answer_status`;
CREATE  PROCEDURE `{prefix}update_answer_status` (IN `param_id_student` INT, IN `param_answered` BOOLEAN)  BEGIN
UPDATE {prefix}students SET
  answered = param_answered
WHERE ID=param_id_student;
END;

DROP PROCEDURE IF EXISTS `{prefix}update_last_login_user`;
CREATE  PROCEDURE `{prefix}update_last_login_user` (IN `id_user` INT)  BEGIN
UPDATE {prefix}users SET last_login_date=NOW() WHERE ID=id_user;
END;

DROP PROCEDURE IF EXISTS `{prefix}validate_survey`;
CREATE  PROCEDURE `{prefix}validate_survey` (IN `param_id_student` INT)  BEGIN
UPDATE {prefix}students SET answers_is_valided=TRUE WHERE ID=param_id_student;
END;

DROP PROCEDURE IF EXISTS `{prefix}viewed_all_notification`;
CREATE  PROCEDURE `{prefix}viewed_all_notification` (IN `param_id_user` INT)  UPDATE {prefix}notifications
SET ID=param_id_user
WHERE viewed=1;

DROP PROCEDURE IF EXISTS `{prefix}viewed_notification`;
CREATE  PROCEDURE `{prefix}viewed_notification` (IN `param_id_notification` INT)  UPDATE {prefix}notifications
SET ID=param_id_notification
WHERE viewed=1;

DROP FUNCTION IF EXISTS `{prefix}can_publish`;
CREATE  FUNCTION `{prefix}can_publish` (`id_user` INT) RETURNS TINYINT(1) NO SQL
BEGIN
    DECLARE result INT;
    SELECT publication_entitled INTO result FROM {prefix}users WHERE ID=id_user and activation_date IS NOT NULL and delete_date IS NULL;
    IF result=1 THEN
      RETURN TRUE;
    ELSE
      RETURN FALSE;
    END IF;
  END;

DROP FUNCTION IF EXISTS `{prefix}count_admin`;
CREATE  FUNCTION `{prefix}count_admin` () RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}users where delete_date IS NULL and type=1);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_deleted_messages`;
CREATE  FUNCTION `{prefix}count_deleted_messages` (`id_user` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}messages where id_recipient=id_user and deleted = 1);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_deleted_students`;
CREATE  FUNCTION `{prefix}count_deleted_students` () RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}students where delete_date IS NOT NULL);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_deleted_users`;
CREATE  FUNCTION `{prefix}count_deleted_users` () RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}users where delete_date IS NULL);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_like`;
CREATE  FUNCTION `{prefix}count_like` (`id_post` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}liked_post where ID_POST=id_post);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_new_messages`;
CREATE  FUNCTION `{prefix}count_new_messages` (`id_user` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}messages where id_recipient=id_user and deleted = 0 and {prefix}messages.viewed= 0);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_notifications`;
CREATE  FUNCTION `{prefix}count_notifications` (`id_user` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}notifications where ID_USER=id_user and deleted = 0);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_post`;
CREATE  FUNCTION `{prefix}count_post` () RETURNS INT(11) NO SQL
BEGIN
RETURN (SELECT count({prefix}posts.ID) from {prefix}posts);
END;

DROP FUNCTION IF EXISTS `{prefix}count_received_messages`;
CREATE  FUNCTION `{prefix}count_received_messages` (`id_user` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}messages where id_recipient=id_user and deleted = 0);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_sended_messages`;
CREATE  FUNCTION `{prefix}count_sended_messages` (`id_user` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}messages where id_sender=id_user and deleted = 0);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_students`;
CREATE  FUNCTION `{prefix}count_students` () RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}students where {prefix}students.deleted = 0);
  END;

DROP FUNCTION IF EXISTS `{prefix}count_users`;
CREATE  FUNCTION `{prefix}count_users` () RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}users where delete_date IS NULL);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_deadline_date`;
CREATE  FUNCTION `{prefix}get_deadline_date` (`param_id_student` INT) RETURNS DATE NO SQL
BEGIN
    RETURN (SELECT deadline_date from {prefix}students where ID = param_id_student);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_maxID_message_attachment`;
CREATE  FUNCTION `{prefix}get_maxID_message_attachment` () RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT max(ID) FROM {prefix}message_attachments);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_maxID_message`;
CREATE FUNCTION `{prefix}get_maxID_message`() RETURNS int(11)
    NO SQL
BEGIN
    RETURN (SELECT max(ID) as maxID FROM {prefix}messages);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_maxID_post_attachment`;
CREATE  FUNCTION `{prefix}get_maxID_post_attachment` () RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT max(ID) FROM {prefix}posts_attachments);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_post_by_comment`;
CREATE  FUNCTION `{prefix}get_post_by_comment` (`param_id_comment` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT ID_POST from {prefix}posts_comments where ID = param_id_comment);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_post_publisher_id_by_comment`;
CREATE  FUNCTION `{prefix}get_post_publisher_id_by_comment` (`param_id_comment` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT ID_USER from {prefix}posts_comments where ID = param_id_comment);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_publisher_id`;
CREATE  FUNCTION `{prefix}get_publisher_id` (`param_id_post` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT ID_USER from {prefix}posts where ID = param_id_post);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_TE_ID_of_student`;
CREATE  FUNCTION `{prefix}get_TE_ID_of_student` (`param_id_student` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT ID_TE from {prefix}students where ID = param_id_student);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_TI_ID_of_student`;
CREATE  FUNCTION `{prefix}get_TI_ID_of_student` (`param_id_student` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT ID_TI from {prefix}students where ID = param_id_student);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_UserID_with_email`;
CREATE  FUNCTION `{prefix}get_UserID_with_email` (`param_email_user` TEXT CHARSET utf8) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT ID from {prefix}users where email = param_email_user);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_User_language`;
CREATE  FUNCTION `{prefix}get_User_language` (`param_id_user` INT) RETURNS VARCHAR(5) CHARSET utf8 COLLATE utf8_unicode_ci NO SQL
BEGIN
    RETURN (SELECT language from {prefix}users where ID = param_id_user);
  END;

DROP FUNCTION IF EXISTS `{prefix}get_User_type`;
CREATE  FUNCTION `{prefix}get_User_type` (`param_id_user` INT) RETURNS INT(11) NO SQL
BEGIN
    RETURN (SELECT type from {prefix}users where ID = param_id_user);
  END;

DROP FUNCTION IF EXISTS `{prefix}have_answered`;
CREATE  FUNCTION `{prefix}have_answered` (`param_id_student` INT) RETURNS TINYINT(1) NO SQL
BEGIN
    RETURN (SELECT answered from {prefix}students where ID = param_id_student);
  END;

DROP FUNCTION IF EXISTS `{prefix}isset_student`;
CREATE  FUNCTION `{prefix}isset_student` (`param_id_student` INT) RETURNS TINYINT(1) NO SQL
BEGIN
    RETURN (SELECT count(ID) from {prefix}students where ID = param_id_student);
  END;

DROP FUNCTION IF EXISTS `{prefix}isTE`;
CREATE  FUNCTION `{prefix}isTE` (`id_user` INT) RETURNS INT(11) NO SQL
BEGIN
    IF EXISTS (SELECT * from {prefix}users where type=2 and ID = id_user) THEN
      RETURN TRUE;
    ELSE
      RETURN FALSE;
    END IF;
  END;

DROP FUNCTION IF EXISTS `{prefix}isTI`;
CREATE  FUNCTION `{prefix}isTI` (`id_user` INT) RETURNS INT(11) NO SQL
BEGIN
    IF EXISTS (SELECT * from {prefix}users where type=3 and ID = id_user) THEN
      RETURN TRUE;
    ELSE
      RETURN FALSE;
    END IF;
  END;

DROP FUNCTION IF EXISTS `{prefix}is_activated`;
CREATE  FUNCTION `{prefix}is_activated` (`id_user` INT) RETURNS TINYINT(4) NO SQL
BEGIN
    DECLARE result INT;
    SELECT count(*) INTO result FROM {prefix}users WHERE ID=id_user and activation_date IS NOT NULL and delete_date IS NULL;
    IF result=0 THEN
      RETURN FALSE;
    ELSE
      RETURN TRUE;
    END IF;
  END;

DROP FUNCTION IF EXISTS `{prefix}is_connected`;
CREATE  FUNCTION `{prefix}is_connected` (`id_user` INT) RETURNS TINYINT(1) NO SQL
BEGIN
    DECLARE result INT;
    SELECT count(*) INTO result FROM {prefix}users WHERE DATE_ADD(last_login_date,INTERVAL 3 SECOND)> NOW() and ID=id_user;
    IF result=0 THEN
      RETURN FALSE;
    ELSE
      RETURN TRUE;
    END IF;
  END;

DROP FUNCTION IF EXISTS `{prefix}is_deleted`;
CREATE  FUNCTION `{prefix}is_deleted` (`id_user` INT) RETURNS TINYINT(1) NO SQL
BEGIN
    DECLARE result INT;
    SELECT count(*) INTO result FROM {prefix}users WHERE ID=id_user and delete_date IS NOT NULL;
    IF result=0 THEN
      RETURN FALSE;
    ELSE
      RETURN TRUE;
    END IF;
  END;

DROP FUNCTION IF EXISTS `{prefix}survey_is_validate`;
CREATE  FUNCTION `{prefix}survey_is_validate` (`param_id_student` INT) RETURNS TINYINT(1) NO SQL
BEGIN
    RETURN (SELECT answers_is_valided from {prefix}students where ID = param_id_student);
  END;

DROP FUNCTION IF EXISTS `{prefix}userID_exist`;
CREATE  FUNCTION `{prefix}userID_exist` (`param_id_user` INT) RETURNS TINYINT(1) NO SQL
BEGIN
    RETURN (SELECT count(*) from {prefix}users where ID = param_id_user);
  END;

DROP FUNCTION IF EXISTS `{prefix}verification_connection`;
CREATE  FUNCTION `{prefix}verification_connection` (`param_email` TEXT CHARSET utf8, `param_password` TEXT CHARSET utf8) RETURNS TINYINT(4) NO SQL
BEGIN
    DECLARE result INT;
    SELECT count(*) INTO result FROM {prefix}users WHERE email=param_email and pwd=MD5(param_password) and delete_date IS NULL and activation_date IS NOT NULL;
    IF result = 0 THEN
      RETURN FALSE;
    ELSE
      RETURN TRUE;
    END IF;
  END;

DROP FUNCTION IF EXISTS `{prefix}verification_email`;
CREATE  FUNCTION `{prefix}verification_email` (`param_email` TEXT CHARSET utf8) RETURNS INT(11) BEGIN
    DECLARE result INT;
    SELECT count(*) INTO result FROM {prefix}users WHERE email=param_email;
    IF result = 0 THEN
      RETURN FALSE;
    ELSE
      RETURN TRUE;
    END IF;
END;

DROP FUNCTION IF EXISTS `{prefix}verification_id_password`;
CREATE  FUNCTION `{prefix}verification_id_password` (`param_id` INT, `param_password` TEXT CHARSET utf8) RETURNS TINYINT(1) NO SQL
BEGIN
    DECLARE result INT;
    SELECT count(*) INTO result FROM {prefix}users WHERE ID=param_id and pwd=MD5(param_password) and delete_date IS NULL and activation_date IS NOT NULL;
    IF result = 0 THEN
      RETURN FALSE;
    ELSE
      RETURN TRUE;
    END IF;
  END;





DROP TRIGGER IF EXISTS `{prefix}after_delete_posts_comment`;

CREATE TRIGGER `{prefix}after_delete_posts_comment` AFTER DELETE ON `{prefix}posts_comments` FOR EACH ROW BEGIN
  DELETE FROM {prefix}notifications WHERE content LIKE CONCAT('name[',old.ID_USER,']%') AND requested_date = old.publication_date;
END;

DROP TRIGGER IF EXISTS `{prefix}after_insert_posts_comments`;

CREATE TRIGGER `{prefix}after_insert_posts_comments` AFTER INSERT ON `{prefix}posts_comments` FOR EACH ROW BEGIN
  DECLARE insert_content TEXT;
  DECLARE id_user INT;
  SELECT {prefix}posts.ID_USER INTO id_user FROM {prefix}posts WHERE {prefix}posts.ID=new.ID_POST;
  SET insert_content = CONCAT('name[',new.ID_USER,'] {comment_action}');
END;


DROP TRIGGER IF EXISTS `{prefix}after_delete_posts`;

CREATE TRIGGER `{prefix}after_delete_posts` AFTER DELETE ON `{prefix}posts` FOR EACH ROW BEGIN
  DECLARE delete_content TEXT;
  SET delete_content = CONCAT('Un utilisateur a supprimé sa publication');
  INSERT INTO {prefix}action_report(ID_USER, content, requested_date) VALUES (old.ID_USER,delete_content,NOW());
END;

DROP TRIGGER IF EXISTS `{prefix}after_insert_posts`;

CREATE TRIGGER `{prefix}after_insert_posts` AFTER INSERT ON `{prefix}posts` FOR EACH ROW BEGIN
  DECLARE insert_content TEXT;
  SET insert_content = 'Un utilisateur a publié un message dans le fil d\'actualité';
  INSERT INTO {prefix}action_report(ID_USER, content, requested_date) VALUES (new.ID_USER,insert_content,NOW());
END;


DROP TRIGGER IF EXISTS `{prefix}after_delete_students`;

CREATE TRIGGER `{prefix}after_delete_students` AFTER DELETE ON `{prefix}students` FOR EACH ROW BEGIN
  DECLARE delete_content TEXT;
  SET delete_content = CONCAT('Suppression définitive de l\'étudiant "',old.fname,' ',old.name,'"');
  INSERT INTO {prefix}action_report(ID_USER, content, requested_date) VALUES (NULL,delete_content,NOW());
END;

DROP TRIGGER IF EXISTS `{prefix}after_insert_student`;

CREATE TRIGGER `{prefix}after_insert_student` AFTER INSERT ON `{prefix}students` FOR EACH ROW BEGIN
  DECLARE insert_content TEXT;
  SET insert_content = 'Création d\'un nouvel étudiant';
  INSERT INTO {prefix}action_report(ID_USER, content, requested_date) VALUES (NULL,insert_content,NOW());
END;

DROP TRIGGER IF EXISTS `{prefix}after_update_students`;

CREATE TRIGGER `{prefix}after_update_students` AFTER UPDATE ON `{prefix}students` FOR EACH ROW BEGIN
  DECLARE delete_content TEXT;
  CASE
    WHEN new.answered = 1 and new.answered <> old.answered THEN SET delete_content = CONCAT('Questionnaire répondu pour l\'étudiant N°',new.ID);
    WHEN new.delete_date IS NOT NULL and new.delete_date <> old.delete_date THEN SET delete_content = CONCAT('Étudiant N°',new.ID,' en demande de suppression ');
    WHEN new.delete_date IS NULL and new.delete_date <> old.delete_date THEN SET delete_content = CONCAT('Étudiant N°',new.ID,' remis en service');
    ELSE SET delete_content = CONCAT('Étudiant N°',new.ID,' modifié');
  END CASE;
  IF new.name <> old.name OR new.fname <> old.fname OR new.group <> old.group OR new.email <> old.email OR new.phone <> old.phone OR new.address <> old.address OR new.zip_code <> old.zip_code OR new.city <> old.city OR new.country <> old.country OR new.birth_date <> old.birth_date OR new.informations <> old.informations OR new.creation_date <> old.creation_date OR new.delete_date <> old.delete_date OR new.deadline_date <> old.deadline_date OR new.answered <> old.answered THEN
    INSERT INTO {prefix}action_report(ID_USER, content, requested_date) VALUES (NULL,delete_content,NOW());
  END IF;
END;


DROP TRIGGER IF EXISTS `{prefix}after_delete_users`;

CREATE TRIGGER `{prefix}after_delete_users` AFTER DELETE ON `{prefix}users` FOR EACH ROW BEGIN
DECLARE delete_content TEXT;
SET delete_content = CONCAT('Suppression d\'un utilisateur :',OLD.fname,' ',OLD.name);
INSERT INTO action_report(ID_USER, content, requested_date) VALUES (NULL,delete_content,NOW());
DELETE FROM notifications WHERE content LIKE CONCAT('%id_user/',OLD.ID,'%') OR content LIKE CONCAT('%id_publisher/',OLD.ID,'%');
END;


DROP TRIGGER IF EXISTS `{prefix}after_insert_users`;

CREATE TRIGGER `{prefix}after_insert_users` AFTER INSERT ON `{prefix}users` FOR EACH ROW BEGIN
  DECLARE insert_content TEXT;
  CASE NEW.type
    WHEN 1 THEN SET insert_content = 'Création d\'un nouvel administrateur';
    WHEN 2 THEN SET insert_content = 'Création d\'un nouveau Tuteur Entreprise';
    WHEN 3 THEN SET insert_content = 'Création d\'un nouveau Tuteur IUT';
  END CASE;
  INSERT INTO {prefix}action_report(ID_USER, content, requested_date) VALUES (NEW.ID,insert_content,NOW());
END;

DROP TRIGGER IF EXISTS `{prefix}after_update_users`;

CREATE TRIGGER `{prefix}after_update_users` AFTER UPDATE ON `{prefix}users` FOR EACH ROW BEGIN
  DECLARE update_content TEXT;
  CASE
    WHEN new.activation_date IS NOT NULL and new.activation_date <> old.activation_date THEN SET update_content = 'Utilisateur Activé';
    WHEN new.delete_date IS NOT NULL and new.delete_date <> old.delete_date THEN SET update_content = 'Utilisateur en demande de suppression';
    WHEN new.delete_date IS NULL and new.delete_date <> old.delete_date THEN SET update_content = 'Utilisateur remis en service';
    WHEN new.publication_entitled = 1 and new.publication_entitled <> old.publication_entitled THEN SET update_content = 'Utilisateur autorisé à publier';
    WHEN new.pwd <> old.pwd THEN SET update_content = 'Mot de passe utilisateur modifié';
    ELSE SET update_content = 'Utilisateur modifié';
  END CASE;
  IF new.name <> old.name OR new.fname <> old.fname OR new.type <> old.type OR new.email <> old.email OR new.pwd <> old.pwd OR new.phone <> old.phone OR new.address <> old.address OR new.zip_code <> old.zip_code OR new.city <> old.city OR new.country <> old.country OR new.language <> old.language OR new.registration_date <> old.registration_date OR new.activation_date <> old.activation_date OR new.delete_date <> old.delete_date OR new.publication_entitled <> old.publication_entitled THEN
    INSERT INTO {prefix}action_report(ID_USER, content, requested_date) VALUES (new.ID,update_content,NOW());
  END IF;
END;




DROP EVENT IF EXISTS `{prefix}auto_deletion_users`;
CREATE EVENT `{prefix}auto_deletion_users` ON SCHEDULE EVERY 1 DAY STARTS '2016-10-20 14:33:37' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Supprime tous les utilisateurs où date suppression >= 30j' DO DELETE FROM {prefix}users where DATE_ADD(delete_date,INTERVAL 30 DAY) < NOW();

DROP EVENT IF EXISTS `{prefix}auto_deletion_students`;
CREATE EVENT `{prefix}auto_deletion_students` ON SCHEDULE EVERY 1 DAY STARTS '2016-10-20 14:33:37' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Supprime tous les étudiants où date suppression >= 30j' DO DELETE FROM {prefix}students where DATE_ADD(delete_date,INTERVAL 30 DAY) < NOW();


