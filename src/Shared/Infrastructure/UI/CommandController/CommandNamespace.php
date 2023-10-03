<?php

namespace AK\Shared\Infrastructure\UI\CommandController;

use AK\App;
use AK\Shared\Domain\Bus\Command\CommandBus;
use AK\Shared\Domain\Bus\Query\QueryBus;
use AK\Shared\Infrastructure\DI\Container;

class CommandNamespace
{
    protected $name;

    protected $controllers = [];

    public function __construct($name, private Container $container)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function loadControllers($commands_path)
    {
        $glob = glob($commands_path . '/' . $this->getName() . '/Infrastructure/UI/CommandController/*Controller.php');
        foreach (glob($commands_path . '/' . $this->getName() .'/Infrastructure/UI/CommandController'. '/*Controller.php') as $controller_file) {
            $this->loadCommandMap($controller_file);
        }

        return $this->getControllers();
    }

    public function getControllers()
    {
        return $this->controllers;
    }

    public function getController($command_name)
    {
        return isset($this->controllers[$command_name]) ? $this->controllers[$command_name] : null;
    }

    protected function loadCommandMap($controller_file)
    {
        $filename = basename($controller_file);

        $controller_class = str_replace('.php', '', $filename);
        $command_name = strtolower(str_replace('Controller', '', $controller_class));
        $full_class_name = sprintf(
            "AK\\%s\\Infrastructure\\UI\\CommandController\\%s",
            $this->getName(),
            $controller_class
        );

        if ($controller_class !== 'BaseCommandController') {
            /** @var BaseCommandController $controller */
            $queryBus = $this->container->get(QueryBus::class);
            $commandBus = $this->container->get(CommandBus::class);
            $controller = new $full_class_name($queryBus, $commandBus);
            $this->controllers[$command_name] = $controller;
        }
    }
}