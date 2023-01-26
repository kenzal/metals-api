<?php

/** @noinspection PhpUnhandledExceptionInspection */

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;

it('can get', function () {
    Http::fake([
        '*' => Http::response(/** @lang JSON */ '{
                        "success":true,
                        "fluctuation":true,
                        "start_date":"2018-02-25",
                        "end_date":"2018-02-26",
                        "base":"EUR",
                        "rates":{
                            "USD":{
                                "start_rate":1.228952,
                                "end_rate":1.232735,
                                "change":0.0038,
                                "change_pct":0.3078
                            },
                            "JPY":{
                                "start_rate":131.587611,
                                "end_rate":131.651142,
                                "change":0.0635,
                                "change_pct":0.0483
                            }
                        }
                    }', 200, ['Headers']),
    ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $rates = $metalsApi->fluctuation(startDate: Carbon::make('2012-05-01'),
        endDate  : Carbon::make('2012-05-03'),
        symbols  : ['USD', 'JPY'],
        base     : 'EUR');

    expect($rates)->toHaveKey('USD');
    expect($rates['USD'])->toHaveKey('change_pct');
    expect($rates['USD']['change_pct'])->toBe(0.3078);
});

it('throws exception on bad bad response', function () {
    Http::fake(['*/latest?*' => Http::response(body: '{"success": false}', status: 400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->fluctuation(startDate: Carbon::make('2012-05-01'),
        endDate  : Carbon::make('2012-05-03'),
        symbols  : ['USD', 'JPY'],
        base     : 'EUR');
})->throws(RequestException::class);
