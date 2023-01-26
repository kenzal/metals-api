<?php /** @noinspection PhpUnhandledExceptionInspection */

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;

it('can get', function () {
    Http::fake([
        '*' => Http::response('{
            "success": true,
            "historical": true,
            "date": "2013-12-24",
            "timestamp": 1387929599,
            "base": "GBP",
            "rates": {
            "USD": 1.636492,
            "EUR": 1.196476,
            "CAD": 1.739516
            }
        }', 200, ['Headers']),
    ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $rates     = $metalsApi->historical(Carbon::yesterday());


    expect($rates['USD'])->toBe(1.636492);
});

it('throws exception on bad bad response', function () {
    Http::fake(['*/latest?*' => Http::response(body: '{"success": false}', status:400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->historical(Carbon::yesterday());
})->throws(RequestException::class);
