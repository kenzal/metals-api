<?php

/** @noinspection PhpUnhandledExceptionInspection */

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;
use Kenzal\MetalsApi\Symbols\Currency;
use Kenzal\MetalsApi\Symbols\Metal;

it('can get', function () {
    Http::fake([
        '*' => Http::response(
            body: '{
                "ALU":"Aluminum",
                "AUD":"Australian Dollar",
                "BCH":"Bitcoin Cash",
                "BRASS":"Brass",
                "BTC":"Bitcoin",
                "CAD":"Canadian Dollar",
                "EUR":"Euro",
                "GBP":"British Pound",
                "IRD":"Iridium (Troy Ounce)",
                "IRON":"Iron Ore",
                "ISK":"Icelandic Kr\u00f3na",
                "JPY":"Japanese Yen",
                "PHP":"Philippine Peso",
                "URANIUM":"Uranium",
                "USD":"United States Dollar",
                "XAG":"Silver (Troy Ounce)",
                "XAU":"Gold (Troy Ounce)"
            }',
            status: 200
        ),
    ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $symbols = $metalsApi->symbols();

    expect($symbols)->toContain(Currency::USD, Metal::XAU);
});

it('throws exception on bad bad response', function () {
    Http::fake(['*' => Http::response(body: '{"success": false}', status:400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->symbols();
})->throws(exception: RequestException::class);
