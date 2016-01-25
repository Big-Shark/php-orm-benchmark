#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new \BigShark\ORMBenchmark\Commands\InstallCommand());
$application->add(new \BigShark\ORMBenchmark\Commands\UpdateCommand());
$application->add(new \BigShark\ORMBenchmark\Commands\RunCommand());
$application->run();