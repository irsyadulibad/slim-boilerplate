<?php

namespace App\Console\Commands;

use App\Kernel;
use Slim\App;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'route:list',
    description: 'List all routes.',
    hidden: false,
)]

class RouteList extends Command
{
    private App $slim;

    protected function configure(): void
    {
        $this->slim = Kernel::$app;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $routes = $this->slim->getRouteCollector()->getRoutes();
        $tableRows = [];
        
        $table->setStyle('borderless');

        foreach($routes as $route) {
            $tableRows[] = [
                '<info>' . implode('|', $route->getMethods()) . '</info>',
                $route->getPattern(),
                '<comment>' . $route->getName() . '</comment>',
                $this->genAction($route->getCallable())
            ];
        }

        $table->setRows($tableRows);
        $table->render();

        return Command::SUCCESS;
    }

    private function genAction($action): string
    {
        $action = match(gettype($action)) {
            'array' => implode('@', $action),
            'object' => 'closure',
            'string' => $action
        };

        return "<comment>{$action}</comment>";
    }
}
