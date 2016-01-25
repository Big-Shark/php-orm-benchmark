<?php

namespace BigShark\ORMBenchmark\Commands;

use BigShark\ORMBenchmark\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class InstallCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('install')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dirs = $this->getDirs();
        foreach ($dirs as $dir) {
            $this->runCommand('composer install', $dir, $output);
        }
        $output->writeln('Done');
    }
}
