<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'db:seed',
    description: 'Seed the database.',
    hidden: false,
)]

class SeedDatabase extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::OPTIONAL, 'Seeder name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name') ?? 'DatabaseSeeder';
        $namespace = "\\Database\\Seeders\\";

        (new ($namespace . $name))->run();
        $output->writeln("<info>Seeded: </info>$name");

        return Command::SUCCESS;
    }
}
