-- MySQL Workbench Synchronization
-- Generated: 2019-06-11 08:46
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Озармехр
-- Запустите этот скрипт для создания БД для проекта pastebin.analog

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `pastebin` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE IF NOT EXISTS `pastebin`.`access` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL COMMENT 'Название',
  `title_rus` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COMMENT = 'Ограничение доступа';

CREATE TABLE IF NOT EXISTS `pastebin`.`log_in` (
  `id` INT(10) UNSIGNED ZEROFILL NOT NULL,
  `login` VARCHAR(255) NOT NULL COMMENT 'логин',
  `password` VARCHAR(255) NOT NULL COMMENT 'пароль',
  PRIMARY KEY (`login`, `password`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'таблица для хранения логинов и паролец пользователей';

CREATE TABLE IF NOT EXISTS `pastebin`.`paste` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `short_title` VARCHAR(255) NOT NULL COMMENT 'Короткое название',
  `paste_text` TEXT NOT NULL,
  `date_create` DATETIME NOT NULL,
  `status` TINYINT(4) NOT NULL DEFAULT '1' COMMENT 'Статус пасты',
  `expiration_time` DATETIME NOT NULL COMMENT 'Время действительности',
  `url` VARCHAR(255) NOT NULL COMMENT 'URL пасты',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `url_UNIQUE` (`url` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 68
DEFAULT CHARACTER SET = utf8
COMMENT = 'Таблица для хранения паст';

CREATE TABLE IF NOT EXISTS `pastebin`.`paste_access` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `paste_id` INT(11) NOT NULL,
  `access_id` INT(11) NOT NULL,
  PRIMARY KEY (`paste_id`, `access_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_paste_access_paste_idx` (`paste_id` ASC) ,
  INDEX `fk_paste_access_access1_idx` (`access_id` ASC) ,
  CONSTRAINT `fk_paste_access_access1`
    FOREIGN KEY (`access_id`)
    REFERENCES `pastebin`.`access` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_paste_access_paste`
    FOREIGN KEY (`paste_id`)
    REFERENCES `pastebin`.`paste` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 50
DEFAULT CHARACTER SET = utf8
COMMENT = 'Таблица для хранения доступок паст. \nУ одной пасты может несколько ограничений для доступа.\nПаста может быть скрыта от конкретного пользователя, может быть доступна по ссылке и тд';

CREATE TABLE IF NOT EXISTS `pastebin`.`user` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `surname` VARCHAR(255) NOT NULL,
  `patronymic` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Таблица пользователей';

CREATE TABLE IF NOT EXISTS `pastebin`.`user_paste` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `paste_id` INT(11) NOT NULL,
  PRIMARY KEY (`user_id`, `paste_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_user_paste_paste1_idx` (`paste_id` ASC) ,
  CONSTRAINT `fk_user_paste_paste1`
    FOREIGN KEY (`paste_id`)
    REFERENCES `pastebin`.`paste` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_paste_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `pastebin`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Пасты пользователя ';


-- -----------------------------------------------------
-- Placeholder table for view `pastebin`.`view_pastes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pastebin`.`view_pastes` (`paste_id` INT, `short_title` INT, `paste_text` INT, `date_create` INT, `expiration_time` INT, `url` INT, `access_id` INT, `status` INT);


USE `pastebin`;

-- -----------------------------------------------------
-- View `pastebin`.`view_pastes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pastebin`.`view_pastes`;
USE `pastebin`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pastebin`.`view_pastes` AS select `pastebin`.`paste`.`id` AS `paste_id`,`pastebin`.`paste`.`short_title` AS `short_title`,`pastebin`.`paste`.`paste_text` AS `paste_text`,`pastebin`.`paste`.`date_create` AS `date_create`,`pastebin`.`paste`.`expiration_time` AS `expiration_time`,`pastebin`.`paste`.`url` AS `url`,`pastebin`.`paste_access`.`access_id` AS `access_id`,`pastebin`.`paste`.`status` AS `status` from (`pastebin`.`paste` join `pastebin`.`paste_access` on((`pastebin`.`paste_access`.`paste_id` = `pastebin`.`paste`.`id`)));

