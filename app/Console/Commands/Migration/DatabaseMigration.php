<?php

namespace App\Console\Commands\Migration;

use App\Support\MigrationSupport;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'migrate',
    description: 'Migrate all migrations.',
    hidden: false,
)]

class DatabaseMigration extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migrations = MigrationSupport::migrations();

        foreach($migrations as $migration) {
            require $migration->path;
            (new ("\Database\\Migrations\\{$migration->class}"))->up();

            $output->writeln("Migrated: <info>{$migration->name}</info>");
        }

        return Command::SUCCESS;
    }
}
