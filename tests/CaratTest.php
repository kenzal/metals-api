<?php /** @noinspection PhpUnhandledExceptionInspection */

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;

it('can get', function () {
    Http::fake([
                   '*' => Http::response(
                       body  : '{
                "success": true,
                "timestamp": 1623165936,
                "base": "USD",
                "rates": {
                    "Carat 24K": 12173,
                    "Carat 23K": 11666,
                    "Carat 22K": 11159,
                    "Carat 21K": 10652,
                    "Carat 18K": 9130,
                    "Carat 16K": 8115,
                    "Carat 14K": 7101,
                    "Carat 12K": 6087,
                    "Carat 10K": 5072,
                    "Carat 9K": 4565,
                    "Carat 8K": 4058,
                    "Carat 6K": 3043
                }
            }',
                       status: 200
                   ),
               ]);

    $metalsApi = new MetalsApi(config('metalsApi'));
    $symbols   = $metalsApi->carat('USD');


    expect($symbols)->toHaveKey('Carat 24K');
    expect($symbols['Carat 24K'])->toBe(12173);
});

it('throws exception on bad bad response', function () {
    Http::fake(['*/latest?*' => Http::response(body: '{"success": false}', status: 400)]);

    $metalsApi = new MetalsApi(config('metalsApi'));

    $metalsApi->carat('USD');
})->throws(exception: RequestException::class);
