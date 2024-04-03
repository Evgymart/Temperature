<?php
declare(strict_types=1);
use Alignant\Temperature\router\Router;
use Alignant\Temperature\controller\ApiController;
use Alignant\Temperature\controller\SensorController;

/** @var Router $router */

$router->addGet(SensorController::class, 'read', 'ip');

$router->addPost(ApiController::class, 'push');