<?php

declare(strict_types=1);

it('provides string configuration values to string consumers', function (string $key) {
    expect(config($key))->toBeString();
})->with([
    'cache prefix' => 'cache.prefix',
    'Redis prefix' => 'database.redis.options.prefix',
    'log viewer environment name' => 'log-viewer.hosts.local.name',
    'mail local domain' => 'mail.mailers.smtp.local_domain',
    'session cookie' => 'session.cookie',
]);

it('provides lists of strings to list configuration consumers', function (string $key) {
    $values = config($key);

    expect($values)->toBeArray();

    foreach ($values as $value) {
        expect($value)->toBeString();
    }
})->with([
    'previous encryption keys' => 'app.previous_keys',
    'logging stack' => 'logging.channels.stack.channels',
    'Sanctum stateful domains' => 'sanctum.stateful',
]);

it('provides nullable stateful domains to the log viewer', function () {
    $domains = config('log-viewer.api_stateful_domains');

    expect($domains === null || is_array($domains))->toBeTrue();

    foreach ($domains ?? [] as $domain) {
        expect($domain)->toBeString();
    }
});
