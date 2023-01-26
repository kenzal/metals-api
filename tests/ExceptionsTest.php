<?php /** @noinspection PhpUnhandledExceptionInspection */

use Illuminate\Support\Facades\Http;
use Kenzal\MetalsApi\MetalsApi;
use Kenzal\MetalsApi\Exceptions;

$responseExceptions = [
    // The requested resource does not exist.
    404 => Exceptions\ResourceNotExistsException::class,
    // No API Key was specified or an invalid API Key was specified.
    101 => Exceptions\NoApiKeyException::class,
    // The requested API endpoint does not exist.
    103 => Exceptions\EndpointNotExistsException::class,
    // The maximum allowed amount of monthly API requests has been reached.
    104 => Exceptions\NotExistsException::class,
    // The current subscription plan does not support this API endpoint.
    105 => Exceptions\EndpointNotAllowedException::class,
    // The current request did not return any results.
    106 => Exceptions\NoResultsException::class,
    // The account this API request is coming from is inactive.
    102 => Exceptions\AccountInactiveException::class,
    // An invalid base currency has been entered.
    201 => Exceptions\InvalidBaseCurrencyException::class,
    // One or more invalid symbols have been specified.
    202 => Exceptions\InvalidSymbolException::class,
    // No date has been specified. [historical]
    301 => Exceptions\DateNotSpecifiedException::class,
    // An invalid date has been specified. [historical, convert]
    302 => Exceptions\InvalidDateException::class,
    // No or an invalid amount has been specified. [convert]
    403 => Exceptions\InvalidAmountException::class,
    // No or an invalid timeframe has been specified. [timeseries]
    501 => Exceptions\InvalidTimeframeException::class,
    // No or an invalid "start_date" has been specified. [timeseries, fluctuation]
    502 => Exceptions\InvalidStartDateException::class,
    // No or an invalid "end_date" has been specified. [timeseries, fluctuation]
    503 => Exceptions\InvalidEndDateException::class,
    // The specified timeframe is too long, exceeding 365 days. [timeseries, fluctuation]
    504 => Exceptions\InvalidTimeframeException::class,
    // An invalid timeframe has been specified. [timeseries, fluctuation]
    505 => Exceptions\InvalidTimeframeException::class,
];

foreach ($responseExceptions as $httpCode => $exception) {
    it("on $httpCode response throws $exception", function () use ($httpCode) {
        Http::fake(['*' => Http::response(body: '{"success": false}', status: $httpCode)]);

        $metalsApi = new MetalsApi(config('metalsApi'));

        $metalsApi->symbols();
    })->throws(exception: $exception);
}
