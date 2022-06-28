<?php
chdir(dirname(__DIR__));
define('ROOT_PATH', dirname(__DIR__) . '/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('APP_PATH', ROOT_PATH . 'app/');

require APP_PATH . 'Core/init.php';
use App\Core\Application;
$app = new Application();