<?php
use Puckett\PrioritizationMatrix\PrioritizationMatrix;
class PrioritizationMatrixTest extends PHPUnit_Framework_TestCase
{

  private $db;

  function __construct(){
    $this->db = new PDO(
      "mysql:host=".DATABASE_SERVER.";dbname=".DATABASE_NAME.";charset=utf8",
      DATABASE_USERNAME,
      DATABASE_PASSWORD
    );
  }

  public function testMetricCreated(){
    $pm = new PrioritizationMatrix($this->db);
    $data = [
      'name' => 'a metric',
      'weight' => 84,
      'scale' => 10
    ];
    $this->assertSame(1,$pm->create_metric($data));
  }

  public function testMetricFormCreated(){
    $pm = new PrioritizationMatrix($this->db);
    $this->assertSame(file_get_contents(__DIR__.'/data/metric.form.html'),$pm->get_metric());
  }

  public function testTravisFail(){
    $this->assertFalse(true);
  }

}
