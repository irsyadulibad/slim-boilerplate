<?php

namespace App\Console\Commands\Make;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'make:model',
    description: 'Make model class.',
    hidden: false,
)]

class MakeModel extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Model name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = ucfirst($input->getArgument('name'));
        $path = app_path("Models/{$name}.php");

        if(file_exists($path)) {
            $output->writeln("<error>Model $name has already exist</error>");
            return Command::FAILURE;
        }

        file_put_contents($path, load_stub('model', $name));
        $output->writeln("<info>Created Model: </info> $name");

        return Command::SUCCESS;
    }
}
