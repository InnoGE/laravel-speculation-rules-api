<?php

namespace InnoGE\LaravelSpeculationRulesApi;

class LaravelSpeculationRulesApi
{
    public static array $routeSpeculationRules = [];

    private static function prerenderRules(): array
    {
        return collect(self::$routeSpeculationRules['prerender'] ?? [])
            ->map(fn (array $item) => [
                'where' => ['and' => self::createRule($item['uri'])],
                'eagerness' => $item['eagerness'],
            ])
            ->values()
            ->merge(array_filter(config('speculation-rules-api.prerender', [])))
            ->toArray();
    }

    private static function prefetchRules(): array
    {
        return collect(self::$routeSpeculationRules['prefetch'] ?? [])
            ->map(fn (array $item) => [
                'where' => ['and' => self::createRule($item['uri'])],
                'eagerness' => $item['eagerness'],
                'referrer_policy' => 'no-referrer',
            ])
            ->values()
            ->merge(array_filter(config('speculation-rules-api.prefetch', [])))
            ->toArray();
    }

    public static function createRule(string $uri): array
    {
        preg_match_all('/{[^}]+}/', $uri, $matches);

        if (count($matches[0]) === 0) {
            return [['href_matches' => $uri]];
        }

        $hrefMatches = trim(preg_replace('/{[^}]+}/', '*', $uri), '/');

        return [
            ['href_matches' => "/$hrefMatches"],
            ['not' => ['href_matches' => "/$hrefMatches/*"]],
        ];
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
