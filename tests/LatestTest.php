<?php

/** @noinspection PhpUnhandledExceptionInspection */

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;

it('can get', function () {
    Http::fake([
        '*/latest?*' => Http::response('{
      "success": true,
      "timestamp": 1674663420,
      "date": "2023-01-25",
      "base": "BTC",
      "rates": {
        "EUR": 20786.331662910616,
        "GBP": 18315.057926304482,
        "JPY": 2935281.092856604,
        "USD": 22606.174999998493,
        "XAG": 0.001043135283359529,
        "XAU": 0.08532182025486948
      },
      "unit": "per ounce"
    }', 200, ['Headers']),
    ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $rates = $metalsApi->latest('USD,GBP,JPY,EUR,XAU,XAG,BTC', 'BTC');

    expect($rates['USD'])->toBe(22606.174999998493);
});

it('throws exception on bad bad response', function () {
    Http::fake(['*/latest?*' => Http::response(body: '{"success": false}', status:400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->latest('USD,GBP,JPY,EUR,XAU,XAG,BTC', 'BTC');
})->throws(RequestException::class);
