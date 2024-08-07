<?php

use InnoGE\LaravelSpeculationRulesApi\LaravelSpeculationRulesApi;

test('blade directive', function () {
    LaravelSpeculationRulesApi::$routeSpeculationRules = [
        'prerender' => [],
        'prefetch' => [],
    ];

    expect(Blade::compileString('@speculationRulesApi'))
        ->toBe('<?php echo \InnoGE\LaravelSpeculationRulesApi\LaravelSpeculationRulesApi::renderSpeculationRules() ?>')
        ->and(Blade::render('@speculationRulesApi'))
        ->toBe('<script type="speculationrules">[]</script>');
});

test('route macros', function () {
    LaravelSpeculationRulesApi::$routeSpeculationRules = [
        'prerender' => [],
        'prefetch' => [],
    ];

    Route::get('page-1', fn() => null)->prerender();
    Route::get('page-2', fn() => null)->prerender('eager');
    Route::get('page-3', fn() => null)->prefetch();
    Route::get('page-4', fn() => null)->prefetch('eager');

    expect(LaravelSpeculationRulesApi::$routeSpeculationRules)->toMatchSnapshot();
});

test('speculation rules are merged properly', function () {
    LaravelSpeculationRulesApi::$routeSpeculationRules = [
        'prerender' => [],
        'prefetch' => [],
    ];

    Route::get('page-1', fn() => null)->prerender();
    Route::get('page-2', fn() => null)->prerender('eager');

    config()->set('speculation-rules-api', [
        'prerender' => [
            [
                'source' => 'list',
                'urls' => ['page-3'],
                'eagerness' => 'conservative',
            ],
        ],
        'prefetch' => [
            [
                'urls' => ['page-4'],
                'referrer_policy' => 'no-referrer',
                'eagerness' => 'moderate',
            ],
        ],
    ]);

    expect(LaravelSpeculationRulesApi::speculationRules())->toMatchSnapshot();
});
