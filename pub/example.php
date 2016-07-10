<?php require_once __DIR__.'/../vendor/autoload.php';
use Puckett\PrioritizationMatrix\PrioritizationMatrix;

// define database credentials
$database_server = "localhost";
$database_username = "pm_UA_LU8h8";
$database_password = "zX4ScugUsBQoAI5c";
$database_name = "pm_D_LU8h8";

// trump with local credentials
$credentials_file = __DIR__.'/../credentials.local.inc.php';
if (file_exists($credentials_file))
  require_once($credentials_file);

$pdo = new PDO(
  "mysql:host=$database_server;dbname=$database_name;charset=utf8",
  $database_username,
  $database_password
);
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$pm = new PrioritizationMatrix($pdo);
