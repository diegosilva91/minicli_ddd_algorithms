<?php

declare(strict_types=1);
function load_config(array $defaultConfig, string $configPath): array
{
    $config = [];

    foreach ((array) glob("{$configPath}/*.php") as $configFile) {
        $configData = include $configFile;
        if (is_array($configData)) {
            $config = [...$config, ...$configData];
        }
    }

    return [...$defaultConfig, ...$config];
}