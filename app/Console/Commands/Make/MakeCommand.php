<?php

namespace App\Console\Commands\Make;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'make:command',
    description: 'Make command.',
    hidden: false,
)]

class MakeCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Command name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = explode('/', $input->getArgument('name'));
        $name = array_pop($names);
        $path = make_dirs(app_path('Console/Commands'), $names);
        $namespace = $this->namespace($names);

        if(file_exists("{$path}/{$name}.php")) {
            $output->writeln("<error>Command {$namespace}\\{$name} has already exist</error>");
            return Command::FAILURE;
        }

        file_put_contents("{$path}/{$name}.php", load_stub('command', $namespace, $name));
        $output->writeln("Created command: <info>{$namespace}\\{$name}</info>");

        return Command::SUCCESS;
    }

    private function namespace(array $names): string
    {
        $namespace = implode('\\', $names);

        if(strlen($namespace) > 0) return "\\{$namespace}";
        return $namespace;
    }
}
