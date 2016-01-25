<?php

namespace BigShark\ORMBenchmark\Commands;

use BigShark\ORMBenchmark\Console;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;


class RunCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $avg = function($array, $key) {
            $sum = array_sum(array_column($array, $key));
            return number_format($sum / count($array), 2);
        };

        $env = [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'ormtest',
            'username'  => 'root',
            'password'  => '',
            'port'      => '3306',
        ];
        $env['dsn'] = $env['driver'].':host='.$env['host'].';port='.$env['port'].';dbname='.$env['database'];

        $results = [];
        $dirs = $this->getDirs();
        foreach ($dirs as $dir) {
            $tests = glob($dir.'/Test*.php');
            foreach ($tests as $test) {

                $pathinfo = pathinfo($test);
                $namespace = substr($pathinfo['dirname'], strrpos($pathinfo['dirname'], '/') + 1);
                $class = $pathinfo['filename'];

                $subResults = [];
                for($i = 1; $i <= 3; $i++) {
                    $process = new Process('php Runner.php "'.$namespace.'" "'.$class.'"', realpath(__DIR__.'/..'), $env);
                    $process->setTimeout(0);
                    $process->mustRun();
                    $processOutput = $process->getOutput();
                    $subResults[] = json_decode($processOutput, true);
                    sleep(1);
                }

                $name = false;
                foreach($subResults as $subResult) {
                    if(true === $name){
                        $subResult['name'] = '';
                    }
                    $name = true;
                    $results[] = $subResult;
                }
                $results[] = new TableSeparator();
                $results[] = [
                    'AVG',
                    $avg($subResults, 'memory'),
                    $avg($subResults, 'time'),
                    $avg($subResults, 'insertAuthor'),
                    $avg($subResults, 'insertBook'),
                    $avg($subResults, 'findByPk'),
                ];
                $results[] = new TableSeparator();
            }
        }

        $lastResult = count($results)-1;
        if($results[$lastResult] instanceof TableSeparator)
        {
            unset($results[$lastResult]);
        }
        $table = new Table($output);
        $table
            ->setHeaders(['name', 'memory', 'time', 'insertAuthor', 'insertBook', 'findByPk'])
            ->setRows($results)
        ;
        $table->render();
    }
}
