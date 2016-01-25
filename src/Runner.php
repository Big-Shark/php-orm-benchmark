<?php
$_ENV += array_intersect_key($_SERVER, array_flip(['driver', 'host', 'database', 'username', 'password', 'port', 'dsn']));
include_once 'TestInterface.php';
include_once 'AbstractTest.php';
require_once __DIR__.'/../'.$_SERVER['argv'][1].'/vendor/autoload.php';
include_once __DIR__.'/../'.$_SERVER['argv'][1].'/'.$_SERVER['argv'][2].'.php';

$class = '\\'.$_SERVER['argv'][1].'\\'.$_SERVER['argv'][2];
$test = new $class;
echo $test->run();