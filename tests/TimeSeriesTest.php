<?php

/** @noinspection PhpUnhandledExceptionInspection */

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;

it('can get', function () {
    Http::fake([
        '*' => Http::response(/** @lang JSON */ '{
            "success": true,
            "timeseries": true,
            "start_date": "2012-05-01",
            "end_date": "2012-05-03",
            "base": "EUR",
            "rates": {
                "2012-05-01":{
                    "USD": 1.322891
                },
                "2012-05-02": {
                    "USD": 1.315066
                },
                "2012-05-03": {
                    "USD": 1.314491
                }
            }
        }', 200, ['Headers']),
    ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $rates = $metalsApi->timeSeries(startDate: Carbon::make('2012-05-01'),
        endDate  : Carbon::make('2012-05-03'),
        symbol   : 'USD',
        base     : 'EUR');

    expect($rates)->toHaveKey('2012-05-01');
    expect($rates['2012-05-01'])->toHaveKey('USD');
    expect($rates['2012-05-01']['USD'])->toBe(1.322891);
});

it('throws exception on bad bad response', function () {
    Http::fake(['*/latest?*' => Http::response(body: '{"success": false}', status: 400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->timeSeries(startDate: Carbon::make('2012-05-01'),
        endDate  : Carbon::make('2012-05-03'),
        symbol   : 'USD',
        base     : 'EUR');
})->throws(RequestException::class);
