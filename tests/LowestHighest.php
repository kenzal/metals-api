<?php

/** @noinspection PhpUnhandledExceptionInspection */

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;

it('can get', function () {
    Http::fake([
        '*' => Http::response(
            /** @lang JSON */
            '{
                                "success": true,
                                "timestamp": 1641842149,
                                "date": "2022-01-01",
                                "base": "USD",
                                "symbol": "XAU",
                                "rates": {
                                    "low": 0.0005470547,
                                    "high": 0.00054754153
                                },
                                "unit": "per ounce"
                              }',
            200),
    ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $rates = $metalsApi->lowestHighest(date: Carbon::make('2022-01-01'), symbol: 'XAU', base: 'USD');

    expect($rates['low'])->toBe(0.0005470547);
});

it('throws exception on bad bad response', function () {
    Http::fake(['*/latest?*' => Http::response(body: '{"success": false}', status: 400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->lowestHighest(date: Carbon::make('2022-01-01'), symbol: 'XAU', base: 'USD');
})->throws(RequestException::class);
