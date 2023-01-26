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
                                "timestamp": 1653931700,
                                "date": "2022-05-20",
                                "base": "XAU",
                                "symbol": "USD",
                                "rates": {
                                    "open": 1841.1889341969709,
                                    "high": 1851.6666851833336,
                                    "low": 1816.419890887657,
                                    "close": 1844.828964194302
                                },
                                "unit": "per ounce"
                            }',
            200),
    ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $rates = $metalsApi->OHLC(date: Carbon::make('2022-01-01'), symbol: 'XAU', base: 'USD');

    expect($rates)->toHaveKey('open');
    expect($rates['open'])->toBeFloat();
    expect($rates)->toHaveKey('high');
    expect($rates['high'])->toBeFloat();
    expect($rates)->toHaveKey('low');
    expect($rates['low'])->toBeFloat();
    expect($rates)->toHaveKey('close');
    expect($rates['close'])->toBeFloat();
});

it('throws exception on bad bad response', function () {
    Http::fake(['*/latest?*' => Http::response(body: '{"success": false}', status: 400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->OHLC(date: Carbon::make('2022-01-01'), symbol: 'XAU', base: 'USD');
})->throws(RequestException::class);
