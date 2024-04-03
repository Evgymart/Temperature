<?php
declare(strict_types=1);

use Alignant\Temperature\App;
use Alignant\Temperature\router\Router;

require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

global $Application;
$Application = new App(__DIR__);
$Application->setRouter(new Router());
$Application->run();
