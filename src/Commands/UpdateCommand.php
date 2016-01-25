<?php

namespace BigShark\ORMBenchmark\Commands;

use BigShark\ORMBenchmark\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class UpdateCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('update')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dirs = $this->getDirs();
        foreach ($dirs as $dir) {
            $this->runCommand('composer update', $dir, $output);
        }
        $output->writeln('Done');
    }
}
