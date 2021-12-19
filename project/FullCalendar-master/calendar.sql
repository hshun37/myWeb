CREATE TABLE `event` (
	`_id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	`start` DATETIME NOT NULL,
	`end` DATETIME NOT NULL,
	`backgroundColor` TEXT NOT NULL,
	`textColor` TEXT NOT NULL,
	`allDay` INT(11) NOT NULL,
	PRIMARY KEY (`_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=11
;
