<?php

namespace InnoGE\LaravelSpeculationRulesApi;

class LaravelSpeculationRulesApi
{
    public static array $routeSpeculationRules = [];

    private static function prerenderRules(): array
    {
        return collect(self::$routeSpeculationRules['prerender'] ?? [])
            ->map(fn (array $urls, string $eagerness) => [
                'source' => 'list',
                'urls' => $urls,
                'eagerness' => $eagerness,
            ])
            ->values()
            ->merge(config('speculation-rules-api.prerender', []))
            ->toArray();
    }

    private static function prefetchRules(): array
    {
        return collect(self::$routeSpeculationRules['prefetch'] ?? [])
            ->map(fn (array $urls, string $eagerness) => [
                'urls' => $urls,
                'eagerness' => $eagerness,
                'referrer_policy' => 'no-referrer',
            ])
            ->values()
            ->merge(config('speculation-rules-api.prefetch', []))
            ->toArray();
    }

    public static function speculationRules(): array
    {
        return array_filter([
            'prerender' => self::prerenderRules(),
            'prefetch' => self::prefetchRules(),
        ]);
    }

    public static function renderSpeculationRules(): string
    {
        return sprintf(
            '<script type="speculationrules">%s</script>',
            json_encode(
                self::speculationRules(),
                JSON_PRETTY_PRINT,
            ),
        );
    }
}
