<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'serve',
    description: 'Run development serve.',
    hidden: false,
    aliases: ['app:s']
)]

class ServeApp extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Development server started on http://localhost:8080</info>');
        shell_exec("php -S localhost:8080 -t " . public_path());
    }
}
