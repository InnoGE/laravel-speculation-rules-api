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

    Route::get('page-1', fn () => null)->prerender();
    Route::get('page-2', fn () => null)->prerender('eager');
    Route::get('page-3', fn () => null)->prefetch();
    Route::get('page-4', fn () => null)->prefetch('eager');

    expect(LaravelSpeculationRulesApi::$routeSpeculationRules)->toMatchSnapshot();
});

test('default eagerness', function () {
    LaravelSpeculationRulesApi::$routeSpeculationRules = [
        'prerender' => [],
        'prefetch' => [],
    ];

    Route::get('page-1', fn () => null)->prerender();

    expect(data_get(LaravelSpeculationRulesApi::$routeSpeculationRules, 'prerender.0.eagerness'))
        ->toBe('moderate');

    config()->set('speculation-rules-api.default_eagerness', 'eager');

    Route::get('page-1', fn () => null)->prerender();

    expect(data_get(LaravelSpeculationRulesApi::$routeSpeculationRules, 'prerender.1.eagerness'))
        ->toBe('eager');
});

test('speculation rules are merged properly', function () {
    LaravelSpeculationRulesApi::$routeSpeculationRules = [
        'prerender' => [],
        'prefetch' => [],
    ];

    Route::get('page-1/{param1}', fn () => null)->prerender();
    Route::get('page-2/{param1}/{param2}', fn () => null)->prerender('eager');
    Route::get('page-3', fn () => null)->prerender('eager');

    config()->set('speculation-rules-api', [
        'prerender' => [
            [
                'source' => 'list',
                'urls' => ['page-4'],
                'eagerness' => 'conservative',
            ],
        ],
        'prefetch' => [
            [
                'urls' => ['page-5'],
                'referrer_policy' => 'no-referrer',
                'eagerness' => 'moderate',
            ],
        ],
    ]);

    expect(LaravelSpeculationRulesApi::speculationRules())->toMatchSnapshot();
});

test('rule creation', function () {
    expect(LaravelSpeculationRulesApi::createRule('page'))
        ->toBe([
            ['href_matches' => 'page'],
        ])
        ->and(LaravelSpeculationRulesApi::createRule('page/{param}'))
        ->toBe([
            ['href_matches' => '/page/*'],
            ['not' => ['href_matches' => '/page/*/*']],
        ])
        ->and(LaravelSpeculationRulesApi::createRule('page/{param1}/{param2}/{param3}'))
        ->toBe([
            ['href_matches' => '/page/*/*/*'],
            ['not' => ['href_matches' => '/page/*/*/*/*']],
        ]);
});
