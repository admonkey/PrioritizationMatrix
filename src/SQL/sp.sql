DROP PROCEDURE IF EXISTS `pm_create_metric`;

DELIMITER $$

CREATE PROCEDURE `pm_create_metric` (
  IN `p_name` VARCHAR(255),
  IN `p_weight` INT,
  IN `p_scale` INT
)
this_procedure:BEGIN

  INSERT INTO `pm_metrics` (
    `name`,
    `weight`,
    `scale`
  ) VALUES (
    `p_name`,
    `p_weight`,
    `p_scale`
  );

  SELECT LAST_INSERT_ID()
  AS 'mid';

END $$

DELIMITER ;
