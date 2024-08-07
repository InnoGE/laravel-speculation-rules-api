<?php

namespace InnoGE\LaravelSpeculationRulesApi\Tests;

use InnoGE\LaravelSpeculationRulesApi\LaravelSpeculationRulesApiServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelSpeculationRulesApiServiceProvider::class,
        ];
    }
}
