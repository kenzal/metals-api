<?php

/** @noinspection PhpUnhandledExceptionInspection */

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;

it('can get', function () {
    Http::fake([
        '*' => Http::response('{
            "success": true,
            "query": {
                "from": "GBP",
                "to": "JPY",
                "amount": 25
            },
            "info": {
                "timestamp": 1519328414,
                "rate": 148.972231
            },
            "historical": "",
            "date": "2018-02-22",
            "result": 3724.305775
        }', 200, ['Headers']),
    ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $result = $metalsApi->convert(from: 'GBP', to: 'JPY', amount: 25);

    expect($result)->toBe(3724.305775);
});

it('throws exception on bad bad response', function () {
    Http::fake(['*' => Http::response(body: '{"success": false}', status:400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->convert(from: 'GBP', to: 'JPY', amount: 25);
})->throws(RequestException::class);
