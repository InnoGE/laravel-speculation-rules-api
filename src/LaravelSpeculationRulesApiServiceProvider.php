<?php

namespace InnoGE\LaravelSpeculationRulesApi;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelSpeculationRulesApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-speculation-rules-api')
            ->hasConfigFile();
    }

    public function bootingPackage(): void
    {
        Route::macro('prerender', function (?string $eagerness = null) {
            LaravelSpeculationRulesApi::$routeSpeculationRules['prerender'][] = [
                'eagerness' => $eagerness ?? config('speculation-rules-api.default_eagerness'),
                'uri' => $this->uri,
            ];

            return $this;
        });

        Route::macro('prefetch', function (?string $eagerness = null) {
            LaravelSpeculationRulesApi::$routeSpeculationRules['prefetch'][] = [
                'eagerness' => $eagerness ?? config('speculation-rules-api.default_eagerness'),
                'uri' => $this->uri,
            ];

            return $this;
        });

        Blade::directive('speculationRulesApi', function () {
            return '<?php echo \InnoGE\LaravelSpeculationRulesApi\LaravelSpeculationRulesApi::renderSpeculationRules() ?>';
        });
    }
}
