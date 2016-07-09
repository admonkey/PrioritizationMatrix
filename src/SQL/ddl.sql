DROP TABLE IF EXISTS `pm_metric_parents`;
DROP TABLE IF EXISTS `pm_metrics`;

CREATE TABLE IF NOT EXISTS `pm_metrics` (

  `name` VARCHAR(255) NOT NULL UNIQUE,
  `weight` INT NOT NULL DEFAULT 100,
  `scale` INT NOT NULL DEFAULT 10,

  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `creation_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP

) AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `pm_metric_parents` (

  `pid` INT NOT NULL,
  FOREIGN KEY (`pid`) REFERENCES `pm_metrics`(`id`),
  `cid` INT NOT NULL,
  FOREIGN KEY (`cid`) REFERENCES `pm_metrics`(`id`),
  PRIMARY KEY (`pid`,`cid`)

);
