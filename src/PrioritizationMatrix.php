<?php namespace Puckett\PrioritizationMatrix;

class PrioritizationMatrix
{

  private $pdo;

  function __construct($pdo){
    if($pdo instanceof \PDO)
      $this->pdo = $pdo;
    else
      trigger_error(
        'ERROR: PrioritizationMatrix requires a PDO database object.',
        E_USER_ERROR
      );
  }

}
