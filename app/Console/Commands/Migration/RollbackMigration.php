<?php

namespace App\Console\Commands\Migration;

use App\Support\MigrationSupport;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'migrate:rollback',
    description: 'Rollback migration(s)',
    hidden: false,
)]

class RollbackMigration extends Command
{
    protected function configure(): void
    {
        $this->addOption('all', 'a', InputOption::VALUE_NONE, 'rollback all migrations');
        Capsule::schema()->disableForeignKeyConstraints();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migratedFiles = MigrationSupport::getMigratedFiles();
        $migrations = match($input->getOption('all')) {
                        true => $migratedFiles,
                        false => [end($migratedFiles)]
                    };

        foreach($migrations as $migration) {
            $info = MigrationSupport::getMigration($migration);
            $class = "\\Database\\Migrations\\$info->class";

            if(is_null($info)) continue;
            if(!class_exists($class)) require $info->path;

            (new $class)->down();
            $this->deleteMigration($migration);

            $output->writeln("Rolled back: <info>{$info->name}</info>");
        }

        return Command::SUCCESS;
    }

    private function deleteMigration(string $migration): void
    {
        Capsule::table('migrations')->where('migration', $migration)->delete();
    }
}
