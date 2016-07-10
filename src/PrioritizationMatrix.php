<?php namespace Puckett\PrioritizationMatrix;

class PrioritizationMatrix
{

  /*

      functionName($params = DEFAULTS) returns

      __construct($pdo)
      create_metric([name,weight,scale]) INT $id

  */

  private $pdo;

  function __construct($pdo){
    if(!$pdo instanceof \PDO)
      trigger_error(
        'ERROR: PrioritizationMatrix requires a PDO database object.',
        E_USER_ERROR
      );

    $this->pdo = $pdo;
    $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
  }

  public function create_metric($data){
    $sql = 'CALL pm_create_metric(:name,:weight,:scale)';
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch()['mid'];
  }

}
