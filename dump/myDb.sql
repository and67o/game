SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


CREATE TABLE IF NOT EXISTS `game_numbers`
(
	`gn_id`       INT(11) NOT NULL AUTO_INCREMENT,
	`g_id`        INT(11) NOT NULL,
	`user_id`     INT(11) NOT NULL,
	`game_number` INT(11) NOT NULL,
	PRIMARY KEY (`gn_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 36
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `game_process`
(
	`gp_id`          INT(11)  NOT NULL AUTO_INCREMENT,
	`g_id`           INT(11)  NOT NULL,
	`dt`             DATETIME NOT NULL,
	`right_count`    INT(11)  NOT NULL,
	`right_position` INT(11)  NOT NULL,
	`move`           INT(11) DEFAULT NULL,
	PRIMARY KEY (`gp_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 36
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `games`
(
	`g_id`        INT(11)    NOT NULL AUTO_INCREMENT,
	`dt_start`    DATETIME DEFAULT NULL,
	`dt_finish`   DATETIME DEFAULT NULL,
	`game_status` TINYINT(1) NOT NULL,
	PRIMARY KEY (`g_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 54
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `images`
(
	`i_id` INT(11)     NOT NULL AUTO_INCREMENT,
	`path` VARCHAR(40) NOT NULL,
	PRIMARY KEY (`i_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `users`
(
	`u_id`           INT(11)                                                 NOT NULL AUTO_INCREMENT,
	`name`           VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`email`          VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
	`password`       VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`profile_avatar` INT(11)                                                DEFAULT NULL,
	`salt`           VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`reg_dt`         DATETIME                                               DEFAULT NULL,
	`role_id`        INT(11)                                                DEFAULT NULL,
	PRIMARY KEY (`u_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8;
