<?php

namespace App\Console\Commands\Migration;

use App\Support\MigrationSupport;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
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
    protected function configure()
    {
        $this->createMigrationTable();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migrations = MigrationSupport::migrations();
        $migratedFiles = MigrationSupport::getMigratedFiles();

        foreach($migrations as $migration) {
            $class = "\Database\\Migrations\\{$migration->class}";

            if(in_array($migration->name, $migratedFiles)) continue;
            if(!class_exists($class)) require $migration->path;

            (new $class)->up();
            $this->saveMigration($migration->name);

            $output->writeln("Migrated: <info>{$migration->name}</info>");
        }

        return Command::SUCCESS;
    }

    private function createMigrationTable()
    {
        $schema = Capsule::schema();

        if(!$schema->hasTable('migrations')) {
            $schema->create('migrations', function(Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('migration');
            });
        }
    }

    private function saveMigration(string $migration): void
    {
        Capsule::table('migrations')->insert(compact('migration'));
    }
}
