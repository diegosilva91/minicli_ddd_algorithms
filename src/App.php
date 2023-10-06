<?php

namespace AK;

use AK\ChocoBilly\Domain\Repository\BirdsRepository;
use AK\ChocoBilly\Infrastructure\Service\BirdsService;
use AK\Chocobos\Domain\Repository\DNACloningRepository;
use AK\Chocobos\Infrastructure\Service\DNACloning;
use AK\Shared\Domain\Adapter\FileReaderInterface;
use AK\Shared\Domain\Bus\Command\CommandBus;
use AK\Shared\Domain\Bus\Handler;
use AK\Shared\Domain\Bus\Query\QueryBus;
use AK\Shared\Infrastructure\Bus\ContainerHandler;
use AK\Shared\Infrastructure\Bus\SimpleCommandBus;
use AK\Shared\Infrastructure\Bus\SimpleQueryBus;
use AK\Shared\Infrastructure\Config\Config;
use AK\Shared\Infrastructure\Config\ServiceInterface;
use AK\Shared\Infrastructure\DI\Container;
use AK\Shared\Infrastructure\FileManager\ReadFile;
use AK\Shared\Infrastructure\UI\CommandController\BaseCommandController;
use AK\Shared\Infrastructure\UI\CommandController\CliPrinter;
use AK\Shared\Infrastructure\UI\CommandController\CommandCall;
use AK\Shared\Infrastructure\UI\CommandController\CommandRegistry;
use BadMethodCallException;
use Closure;

class App
{
    private const DEFAULT_SIGNATURE = './minicli help';
    protected $printer;

    protected $command_registry;

    protected $app_signature;
    protected Container $container;

    public function __construct(
        array   $config = [],
        string  $signature = self::DEFAULT_SIGNATURE,
        ?string $appRoot = null
    )
    {
        $this->container = Container::getInstance();
        $this->printer = new CliPrinter();
        $this->bindPaths($appRoot);
        $this->boot($config, $signature);

        //   $this->command_registry = new CommandRegistry(__DIR__ . '/');
    }


    protected function loadConfig(array $config, string $signature): void
    {
        $config = array_merge([
            'app_path' => $this->base_path . '/src',
            'theme' => '',
            'debug' => true,
        ], $config);

        $this->addService('config', new Config(load_config($config, $this->config_path)));

        $appSignature = self::DEFAULT_SIGNATURE === $signature && $this->config->app_name
            ? $this->config->app_name
            : $signature;

        $this->setSignature($appSignature);
    }

    public function boot(array $config, string $signature): void
    {
        $this->loadConfig($config, $signature);
        $this->loadServices();

        $commandsPath = $this->config->app_path;
        if (!is_array($commandsPath)) {
            $commandsPath = [$commandsPath];
        }

        $commandSources = [];
        foreach ($commandsPath as $path) {
            if (str_starts_with($path, '@')) {
                $path = str_replace('@', $this->base_path . '/vendor/', $path) . '/Command';
            }
            $commandSources[] = $path;
        }
        $commandRegistry = new CommandRegistry($commandSources);
        $commandRegistry->setContainer($this->container);
        $this->addService('commandRegistry', $commandRegistry);
    }

    public function addService(string $name, ServiceInterface|Closure $service): void
    {
        if ($service instanceof Closure) {
            $this->container->bind($name, fn() => $service($this));
            return;
        }

        $service->load($this);
        $this->container->bind($name, fn() => $service);
    }

    public function __get(string $name): mixed
    {
        return $this->container->has($name)
            ? $this->container->get($name)
            : null;
    }

    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this->getPrinter(), $name)) {
            return $this->getPrinter()->$name(...$arguments);
        }

        throw new BadMethodCallException("Method {$name} does not exist.");
    }

    public function getPrinter()
    {
        return $this->printer;
    }

    public function getSignature()
    {
        return $this->app_signature;
    }

    public function printSignature()
    {
        $this->getPrinter()->display(sprintf("usage: %s", $this->getSignature()));
    }

    public function setSignature($app_signature)
    {
        $this->app_signature = $app_signature;
    }


    public function registerCommand(string $name, callable $callable): void
    {
        $this->commandRegistry->registerCommand($name, $callable);
    }

    public function runCommand(array $argv = [])
    {
        $input = new CommandCall($argv);

        if (count($input->args) < 2) {
            $this->printSignature();
            return;
        }

        $controller = $this->commandRegistry->getCallableController((string)$input->command, $input->subcommand);

        if ($controller instanceof BaseCommandController) {
            $controller->boot($this, $input);
            $controller->run($input);
            $controller->teardown();
            exit;
        }

        $this->runSingle($input);
    }

    protected function runSingle(CommandCall $input)
    {
        try {
            $callable = $this->command_registry->getCallable($input->command);
            call_user_func($callable, $input);
        } catch (\Exception $e) {
            $this->getPrinter()->display("ERROR: " . $e->getMessage());
            $this->printSignature();
            exit;
        }
    }

    public function getAppRoot(): string
    {
        $root_app = dirname(__DIR__);

        if (!is_file($root_app . '/vendor/autoload.php')) {
            $root_app = dirname(__DIR__, 4);
        }

        return $root_app;
    }


    protected function bindPaths(?string $appRoot): void
    {
        $appRoot ??= $this->getAppRoot();

        $this->container->bind('base_path', fn() => $appRoot);
        $this->container->bind('config_path', fn() => "{$appRoot}/config");
        $this->container->bind('logs_path', fn() => "{$appRoot}/logs");
        $this->addService('handler', new ContainerHandler());
        $this->container->bind(Handler::class, ContainerHandler::class);
        $this->addService('simpleQueryBus', new SimpleQueryBus($this->container->get('handler')));
        $this->addService('simpleCommandBus', new SimpleCommandBus($this->container->get('handler')));
        $this->container->bind(QueryBus::class, SimpleQueryBus::class);
        $this->container->bind(CommandBus::class, SimpleCommandBus::class);
        $this->container->bind(FileReaderInterface::class, ReadFile::class);
        $this->container->bind(BirdsRepository::class, BirdsService::class);

          $this->container->bind(DNACloningRepository::class, DNACloning::class);
    }

    protected function loadServices(): void
    {
        $this->loadDefaultServices();

        $services = $this->config->services ?? [];
        if ([] === $services) {
            return;
        }

        foreach ($services as $name => $service) {
            $this->addService($name, new $service());
        }
    }

    protected function loadDefaultServices(): void
    {
        //$this->addService('logger', new Logger());
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}