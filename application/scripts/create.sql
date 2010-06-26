SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';




-- -----------------------------------------------------
-- Table `Players`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Players` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fname` VARCHAR(50) NULL ,
  `sname` VARCHAR(100) NULL ,
  `mailadr` VARCHAR(150) NULL ,
  `gender` CHAR(1) NULL ,
  `accept` CHAR(1) NULL ,
  `registered` TIMESTAMP NULL DEFAULT current_timestamp ,
  `registered_by` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `ind_player_mailadr` (`mailadr` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Tournaments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Tournaments` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tname` VARCHAR(255) NOT NULL ,
  `kind` VARCHAR(6) NOT NULL DEFAULT 'male' ,
  `start_date` DATE NOT NULL ,
  `start_time` TIME NULL ,
  `city` VARCHAR(100) NULL ,
  `zip` VARCHAR(6) NULL ,
  `street` VARCHAR(150) NULL ,
  `rank` VARCHAR(50) NULL ,
  `max_team_no` INT(11) NULL ,
  `start_enroll` DATE NULL ,
  `end_enroll` DATE NULL ,
  `latitude` FLOAT NULL ,
  `longitude` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Teams`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Teams` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `teammate1_id` INT UNSIGNED NULL ,
  `teammate2_id` INT UNSIGNED NULL ,
  `place` INT UNSIGNED NULL ,
  `score` INT UNSIGNED NULL ,
  `enrolled` TIMESTAMP NULL DEFAULT current_timestamp ,
  `Tournaments_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `Tournaments_id`) ,
  INDEX `fk_Teams_Tournaments1` (`Tournaments_id` ASC) ,
  CONSTRAINT `fk_Teams_Tournaments1`
    FOREIGN KEY (`Tournaments_id` )
    REFERENCES `Tournaments` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Ranks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Ranks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `score` INT UNSIGNED NOT NULL DEFAULT 0 ,
  `Players_id` INT NOT NULL ,
  `Tournaments_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `Players_id`, `Tournaments_id`) ,
  INDEX `fk_Ranks_Players1` (`Players_id` ASC) ,
  INDEX `fk_Ranks_Tournaments1` (`Tournaments_id` ASC) ,
  CONSTRAINT `fk_Ranks_Players1`
    FOREIGN KEY (`Players_id` )
    REFERENCES `Players` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ranks_Tournaments1`
    FOREIGN KEY (`Tournaments_id` )
    REFERENCES `Tournaments` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Galeries`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Galeries` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `gname` VARCHAR(100) NOT NULL ,
  `gdescription` TEXT NULL ,
  `tournament_id` INT UNSIGNED NULL DEFAULT 0 ,
  `owner` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Fotos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Fotos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `sourcename` VARCHAR(50) NOT NULL ,
  `description` VARCHAR(200) NULL ,
  `tags` TEXT NULL ,
  `owner` INT NOT NULL ,
  `author` VARCHAR(100) NULL ,
  `added` TIMESTAMP NULL DEFAULT current_timestamp ,
  `Tournaments_id` INT NOT NULL ,
  `Galeries_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`, `Tournaments_id`, `Galeries_id`) ,
  INDEX `fk_Fotos_Tournaments1` (`Tournaments_id` ASC) ,
  INDEX `fk_Fotos_Galeries1` (`Galeries_id` ASC) ,
  CONSTRAINT `fk_Fotos_Tournaments1`
    FOREIGN KEY (`Tournaments_id` )
    REFERENCES `Tournaments` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Fotos_Galeries1`
    FOREIGN KEY (`Galeries_id` )
    REFERENCES `Galeries` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Tags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Tags` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tname` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `ind_tag_name` (`tname` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `FotosPlayers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `FotosPlayers` (
  `Fotos_id` INT UNSIGNED NOT NULL ,
  `Players_id` INT NOT NULL ,
  PRIMARY KEY (`Fotos_id`, `Players_id`) ,
  INDEX `fk_FotosPlayers_Fotos1` (`Fotos_id` ASC) ,
  INDEX `fk_FotosPlayers_Players1` (`Players_id` ASC) ,
  CONSTRAINT `fk_FotosPlayers_Fotos1`
    FOREIGN KEY (`Fotos_id` )
    REFERENCES `Fotos` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FotosPlayers_Players1`
    FOREIGN KEY (`Players_id` )
    REFERENCES `Players` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `FotosTags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `FotosTags` (
  `Fotos_id` INT UNSIGNED NOT NULL ,
  `Fotos_Tournaments_id` INT NOT NULL ,
  `Fotos_Galeries_id` INT UNSIGNED NOT NULL ,
  `Tags_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`Fotos_id`, `Fotos_Tournaments_id`, `Fotos_Galeries_id`, `Tags_id`) ,
  INDEX `fk_FotosTags_Fotos1` (`Fotos_id` ASC, `Fotos_Tournaments_id` ASC, `Fotos_Galeries_id` ASC) ,
  INDEX `fk_FotosTags_Tags1` (`Tags_id` ASC) ,
  CONSTRAINT `fk_FotosTags_Fotos1`
    FOREIGN KEY (`Fotos_id` , `Fotos_Tournaments_id` , `Fotos_Galeries_id` )
    REFERENCES `Fotos` (`id` , `Tournaments_id` , `Galeries_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FotosTags_Tags1`
    FOREIGN KEY (`Tags_id` )
    REFERENCES `Tags` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Adminusers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Adminusers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(40) NOT NULL ,
  `password` VARCHAR(40) NOT NULL ,
  `mailadr` VARCHAR(150) NOT NULL ,
  `fname` VARCHAR(50) NOT NULL ,
  `sname` VARCHAR(100) NOT NULL ,
  `created` TIMESTAMP NOT NULL DEFAULT now() ,
  `modified` TIMESTAMP NULL ,
  `lastcorrectlogin` TIMESTAMP NULL ,
  `lastfaultylogin` TIMESTAMP NULL ,
  `loginamount` INT NULL DEFAULT 0 ,
  `active` CHAR(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Aktuals`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Aktuals` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(150) NULL ,
  `shortcontent` TEXT NULL ,
  `fullcontent` TEXT NULL ,
  `tags` TEXT NULL ,
  `created` TIMESTAMP NULL ,
  `modified` TIMESTAMP NULL ,
  `active` CHAR(1) NULL ,
  `link` VARCHAR(160) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Labels`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Labels` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `Gname` VARCHAR(50) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `AktualsLabels`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `AktualsLabels` (
  `Aktuals_id` INT NOT NULL ,
  `Labels_id` INT NOT NULL ,
  PRIMARY KEY (`Aktuals_id`, `Labels_id`) ,
  INDEX `fk_AktualsLabels_Aktuals1` (`Aktuals_id` ASC) ,
  INDEX `fk_AktualsLabels_Labels1` (`Labels_id` ASC) ,
  CONSTRAINT `fk_AktualsLabels_Aktuals1`
    FOREIGN KEY (`Aktuals_id` )
    REFERENCES `Aktuals` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AktualsLabels_Labels1`
    FOREIGN KEY (`Labels_id` )
    REFERENCES `Labels` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Pages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Pages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `pname` VARCHAR(100) NULL ,
  `link` VARCHAR(120) NULL ,
  `hd_title` VARCHAR(200) NULL ,
  `hd_keywords` TEXT NULL ,
  `content` TEXT NULL ,
  `created` TIMESTAMP NULL DEFAULT now() ,
  `modified` TIMESTAMP NULL ,
  `active` CHAR(1) NULL ,
  `owner` VARCHAR(30) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Pageshistory`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Pageshistory` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `backedup` TIMESTAMP NULL ,
  `content` VARCHAR(45) NULL ,
  `backedup_by` VARCHAR(30) NULL ,
  `Pages_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`, `Pages_id`) ,
  INDEX `fk_Pageshistory_Pages1` (`Pages_id` ASC) ,
  CONSTRAINT `fk_Pageshistory_Pages1`
    FOREIGN KEY (`Pages_id` )
    REFERENCES `Pages` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `AktualsTags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `AktualsTags` (
  `Aktuals_id` INT NOT NULL ,
  `Tags_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`Aktuals_id`, `Tags_id`) ,
  INDEX `fk_AktualsTags_Aktuals1` (`Aktuals_id` ASC) ,
  INDEX `fk_AktualsTags_Tags1` (`Tags_id` ASC) ,
  CONSTRAINT `fk_AktualsTags_Aktuals1`
    FOREIGN KEY (`Aktuals_id` )
    REFERENCES `Aktuals` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AktualsTags_Tags1`
    FOREIGN KEY (`Tags_id` )
    REFERENCES `Tags` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `Menus`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Menus` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `mname` VARCHAR(20) NULL ,
  `type` VARCHAR(10) NULL ,
  `link` VARCHAR(100) NULL ,
  `parent_id` INT(11) NULL ,
  `active` CHAR(1) NULL ,
  `Pages_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Menus_Pages1` (`Pages_id` ASC) ,
  CONSTRAINT `fk_Menus_Pages1`
    FOREIGN KEY (`Pages_id` )
    REFERENCES `Pages` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
