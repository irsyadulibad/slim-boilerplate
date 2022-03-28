<?php

namespace App\Console\Commands\Make;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'make:seeder',
    description: 'Make database seeder.',
    hidden: false,
)]

class MakeSeeder extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Seeder name');        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = ucfirst($input->getArgument('name'));
        $path = base_path("database/seeders/{$name}.php");

        if(file_exists($path)) {
            $output->writeln("<error>Seeder $name has already exist</error>");
            return Command::FAILURE;
        }

        file_put_contents($path, load_stub('seeder', $name));
        $output->writeln("<info>Created Seeder: </info> $name");

        return Command::SUCCESS;
    }
}
