<?php
set_time_limit(0);
require_once __DIR__ . '/../config/common.php';
if(DEBUG === true)
{
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}

require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__ . '/../lib/vendor/autoload.php';

$route = new Route();
$route->run();




 ?>
