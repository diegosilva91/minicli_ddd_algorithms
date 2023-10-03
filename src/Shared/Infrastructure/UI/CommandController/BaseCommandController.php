<?php

namespace AK\Shared\Infrastructure\UI\CommandController;

use AK\App;
use AK\Shared\Infrastructure\Config\Config;
use AK\Shared\Infrastructure\Exception\MissingParametersException;
use AK\Shared\Domain\UI\Command\ControllerInterface;
use AK\Shared\Infrastructure\UI\CommandController\CommandCall;
use BadMethodCallException;

abstract class BaseCommandController implements ControllerInterface
{
    /**
     * app instance.
     *
     * @param App $app
     */
    protected App $app;

    /**
     * config instance.
     *
     * @param Config $config
     */
    protected Config $config;

    /**
     * command call instance.
     *
     * @param CommandCall $input
     */
    protected CommandCall $input;
    private CliPrinter $printer;
    private \AK\Shared\Infrastructure\DI\Container $container;


    /**
     * handle command.
     *
     * @return void
     */
    abstract public function handle(): void;

    public function boot(App $app, CommandCall $input): void
    {
        $this->app = $app;
        $this->container= $app->getContainer();
        $this->config = $app->config;
        $this->printer = $app->getPrinter();

        $missing = array_diff($this->required(), array_keys($input->params));

        if ([] !== $missing) {
            throw new MissingParametersException($missing);
        }
    }

    public function run(CommandCall $input): void
    {
        $this->input = $input;
        $this->handle();
    }

    public function required(): array
    {
        return [];
    }

    public function teardown(): void
    {
    }
    protected function getArgs(): array
    {
        return $this->input->args;
    }

    protected function getParams()
    {
        return $this->input->params;
    }

    protected function hasParam($param)
    {
        return $this->input->hasParam($param);
    }

    protected function getParam($param)
    {
        return $this->input->getParam($param);
    }

    protected function getApp()
    {
        return $this->app;
    }

    protected function getPrinter()
    {
        return $this->getApp()->getPrinter();
    }

    protected function hasFlag(string $flag): bool
    {
        return $this->input->hasFlag($flag);
    }

    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this->printer, $name)) {
            return $this->printer->$name(...$arguments);
        }

        throw new BadMethodCallException("Method {$name} does not exist.");
    }
}