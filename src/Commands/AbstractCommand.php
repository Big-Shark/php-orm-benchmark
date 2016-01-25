<?php

namespace BigShark\ORMBenchmark\Commands;

use BigShark\ORMBenchmark\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;


abstract class AbstractCommand extends Command
{

    /**
     * @return array
     */
    protected function getDirs()
    {
        $dir = realpath(__DIR__.'/../../');
        return array_diff(glob($dir.'/*', GLOB_ONLYDIR), [$dir.'/src', $dir.'/vendor']);
    }


    /**
     * @param $command
     * @param $dir
     * @param OutputInterface $output
     */
    protected function runCommand($command, $dir, OutputInterface $output)
    {
        $output->writeln($dir.' '.$command);

        $process = new Process($command, $dir);
        $process->setTimeout(0);
        $process->run(function ($type, $buffer) use ($output) {
            $output->write($buffer);
        });
    }
}
