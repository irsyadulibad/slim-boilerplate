<?php

namespace App\Console\Commands\Make;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'make:migration',
    description: 'Make table migration.',
    hidden: false,
)]

class MakeMigration extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Migration name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $filename = date('Y_m_d_His_') . $name;
        $content = $this->content($name);
        
        file_put_contents(base_path("database/migrations/{$filename}.php"), $content);
        $output->writeln("<info>Created Migration: </info> $filename");

        return Command::SUCCESS;
    }

    private function content(string $name)
    {
        return load_stub("migration", cap_after('_', $name));
    }
}
