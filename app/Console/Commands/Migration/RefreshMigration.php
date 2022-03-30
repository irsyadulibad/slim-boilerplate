<?php

namespace App\Console\Commands\Migration;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'migrate:fresh',
    description: 'Refresh migration',
    hidden: false,
)]

class RefreshMigration extends Command
{
    protected function configure(): void
    {
        $this->addOption('seed', 's', InputOption::VALUE_NONE, 'Run seeder after migrate');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getApplication();
        $rollback = $app->find('migrate:rollback');
        $migrate = $app->find('migrate');
        $seed = $app->find('db:seed');

        $output->writeln('<comment>Rolling back all migrations:</comment>');
        $rollback->run(new ArrayInput(['-a' => true]), $output);
        
        $output->writeln("\n<comment>Migrating all migrations:</comment>");
        $migrate->run(new ArrayInput([]), $output);
        
        if($input->getOption('seed')) {
            $output->writeln("\n<comment>Run seeder:</comment>");
            $seed->run(new ArrayInput([]), $output);
        }

        return Command::SUCCESS;
    }
}
