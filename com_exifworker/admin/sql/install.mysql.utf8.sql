DROP TABLE IF EXISTS `#__exifworker`;

CREATE TABLE `#__exifworker` (
	`ExifworkerId` INT(11) NOT NULL AUTO_INCREMENT,
	`Name` VARCHAR(32) NOT NULL,
	`Path` VARCHAR(64) NOT NULL,
	`Exif` VARCHAR(4096),
	`CreationDate` CHAR(19) NOT NULL,
	`LastEdited` TIMESTAMP NOT NULL,
	`UserId` INT(11) NOT NULL,
	PRIMARY KEY (`ExifworkerId`)
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8;