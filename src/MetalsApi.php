<?php

namespace Kenzal\MetalsApi;

use DateTime;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class MetalsApi
{
    protected array $config;

    public function __construct($config)
    {
        $this->setConfig($config);
    }

    /**
     * Set config.
     *
     * @param  array  $config
     * @return $this
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;

        $this->validateConfig();

        return $this;
    }

    /**
     * Merge config.
     *
     * Given an array of configs, they will be merged into the existing config
     * instead of replacing them completely
     * The supplied configs are given priority.
     *
     * @param  array  $config
     * @return $this
     */
    public function mergeConfig(array $config): self
    {
        $this->config = array_merge($this->config ?: [], $config);

        $this->validateConfig();

        return $this;
    }

    /**
     * Supported Symbols Endpoint
     *
     * The Metals-API API comes with a constantly updated endpoint returning all available currencies.
     *
     * @throws RequestException
     */
    public function symbols(): array
    {
        $url = $this->buildURL('symbols');
        $response = new Response(Http::get($url));
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json(null, []);
    }

    /**
     * Latest Rates Endpoint
     *
     * Depending on your subscription plan, the API's latest endpoint will return real-time exchange rate data updated
     * every 60 minutes, every 10 minutes or every 60 seconds.
     *
     * @param  string|string[]|null  $symbols  array or comma-separated string of currency codes or metal codes to limit output codes, empty string for all
     * @param  string|null  $base  The three-letter currency code or metal code of your preferred base currency.
     * @return array
     *
     * @throws RequestException
     */
    public function latest(string|array $symbols = null, string $base = null): array
    {
        $symbols = ($symbols === null) ? $this->config['symbols'] ?? '' : '';
        $symbols = is_array($symbols) ? implode(',', $symbols) : $symbols;
        $base = ($base === null) ? $this->config['base'] : '';

        $url = $this->buildURL('latest', ['base' => $base, 'symbols' => $symbols]);
        $response = Http::get($url);
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json('rates');
    }

    /**
     * Historical Rates Endpoint
     *
     * Historical rates are available for most currencies all the way back to the year of 2019.
     *
     * @param  DateTime  $date  Date for historical data retrieval
     * @param  string|string[]|null  $symbols  array or comma-separated string of currency codes or metal codes to limit output codes, empty string for all
     * @param  string|null  $base  The three-letter currency code or metal code of your preferred base currency.
     * @return array
     *
     * @throws RequestException
     */
    public function historical(DateTime $date, string|array $symbols = null, string $base = null): array
    {
        $symbols = ($symbols === null) ? $this->config['symbols'] ?? '' : '';
        $symbols = is_array($symbols) ? implode(',', $symbols) : $symbols;
        $base = ($base === null) ? $this->config['base'] : '';

        $url = $this->buildURL($date->format('Y-m-d'), ['base' => $base, 'symbols' => $symbols]);
        $response = Http::get($url);
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json('rates');
    }

    /**
     * Convert Endpoint
     *
     * The Metals-API API comes with a separate currency conversion endpoint, which can be used to convert any amount
     * from one currency to another.
     *
     * @param  string  $from  The three-letter currency code or metal code of the symbol you would like to convert from
     * @param  string  $to  The three-letter currency code or metal code or metal code of the currency you would like to convert to
     * @param  int|float  $amount  The amount to be converted
     * @param  DateTime|null  $date  Specify a date to use historical rates for this conversion
     * @return float
     *
     * @throws RequestException
     */
    public function convert(string $from, string $to, int|float $amount, DateTime $date = null): float
    {
        $url = $this->buildURL(
            'convert',
            [
                'from' => $from,
                'to' => $to,
                'amount' => $amount,
                'date' => $date ? $date->format('Y-m-d') : '',
            ]);
        $response = Http::get($url);
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json('result');
    }

    /**
     * Time Series Endpoint
     *
     * Metals-API timeseries endpoint lets you query the API for daily historical rates between two dates of your
     * choice, with a maximum time frame of 365 days.
     *
     * This endpoint has a limitation of 365 days and only one symbol per request. If you need to query more than 365
     * days and more than one symbol, you should send another API call.
     *
     * For LMBA and LME markets, the Information provided in this endpoint corresponds to the last known price of the
     * day before. Ex: 2022-03-20 shows the 19th's closing price.
     *
     * You can not use the current date on the parameter "end_date". We recommend using a day prior to the current date
     * in order to get a successful response. To get the last price you will have to use the latest endpoint.
     *
     * @param  DateTime  $startDate  The start date of your preferred timeframe.
     * @param  DateTime  $endDate  The end date of your preferred timeframe.
     * @param  string  $symbol  The three-letter currency code or metal codes to request
     * @param  string|null  $base  The three-letter currency code or metal code of your preferred base currency.
     * @return array
     *
     * @throws RequestException
     */
    public function timeSeries(DateTime $startDate, DateTime $endDate, string $symbol, string $base = null): array
    {
        $base = ($base === null) ? $this->config['base'] : '';

        $url = $this->buildURL(
            'timeseries',
            [
                'base' => $base,
                'symbols' => $symbol,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]);
        $response = Http::get($url);
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json('rates');
    }

    /**
     * Fluctuation Endpoint
     *
     * Using the Metals-API API's fluctuation endpoint you will be able to retrieve information about how currencies
     * fluctuate on a day-to-day basis. To use this feature, simply append a start_date and end_date and choose which
     * currencies (symbols) you would like to query the API for. Please note that the maximum allowed timeframe is
     * 365 days.
     *
     * @param  DateTime  $startDate  The start date of your preferred timeframe.
     * @param  DateTime  $endDate  The end date of your preferred timeframe.
     * @param  string|string[]|null  $symbols  array or comma-separated string of currency codes or metal codes to limit output codes, empty string for all
     * @param  string|null  $base  The three-letter currency code or metal code of your preferred base currency.
     * @param  string|null  $type  weekly, monthly, yearly
     * @return array
     *
     * @throws RequestException
     */
    public function fluctuation(
        DateTime $startDate,
        DateTime $endDate,
        string|array $symbols = null,
        string $base = null,
        string $type = null
    ): array {
        $symbols = ($symbols === null) ? $this->config['symbols'] ?? '' : '';
        $symbols = is_array($symbols) ? implode(',', $symbols) : $symbols;
        $base = ($base === null) ? $this->config['base'] : '';

        $url = $this->buildURL(
            'timeseries',
            [
                'base' => $base,
                'symbols' => $symbols,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'type' => $type,
            ]);
        $response = Http::get($url);
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json('rates');
    }

    /**
     * Carat Endpoint
     *
     * Using the Metals-API API's carat endpoint you will be able to retrieve information about Gold rates by Carat.
     *
     * @param  string|null  $base  The three-letter currency code or metal code of your preferred base currency.
     * @return array
     *
     * @throws RequestException
     */
    public function carat(string $base = null): array
    {
        $base = ($base === null) ? $this->config['base'] : '';
        $url = $this->buildURL(
            'carat',
            [
                'base' => $base,
            ]);
        $response = Http::get($url);
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json('rates');
    }

    /**
     * Lowest-Highest Endpoint
     *
     * Metals-API lowest-highest/YYYY-MM-DD endpoint allows you to query the API to get the lowest and highest price.
     *
     * This endpoint has a limitation of one symbol per request.
     *
     * @param  DateTime  $date  The start date of your preferred timeframe.
     * @param  string  $symbol  The three-letter currency code or metal codes to request
     * @param  string|null  $base  The three-letter currency code or metal code of your preferred base currency.
     * @return array
     *
     * @throws RequestException
     */
    public function lowestHighest(DateTime $date, string $symbol, string $base = null): array
    {
        $base = ($base === null) ? $this->config['base'] : '';

        $url = $this->buildURL(
            "lowest-highest/{$date->format('Y-m-d')}",
            [
                'base' => $base,
                'symbols' => $symbol,
            ]);
        $response = Http::get($url);
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json('rates');
    }

    /**
     * Open/High/Low/Close (OHLC) Price Endpoint
     *
     * Metals-API open-high-low-close/YYYY-MM-DD endpoint allows you to query the API to get the open, high, low,
     * and close price.
     *
     * This endpoint has a limitation of one symbol per request.
     *
     * @param  DateTime  $date  The start date of your preferred timeframe.
     * @param  string  $symbol  The three-letter currency code or metal codes to request
     * @param  string|null  $base  The three-letter currency code or metal code of your preferred base currency.
     * @return array
     *
     * @throws RequestException
     */
    public function OHLC(DateTime $date, string $symbol, string $base = null): array
    {
        $base = ($base === null) ? $this->config['base'] : '';

        $url = $this->buildURL(
            "open-high-low-close/{$date->format('Y-m-d')}",
            [
                'base' => $base,
                'symbols' => $symbol,
            ]);
        $response = Http::get($url);
        if ($response->failed()) {
            throw $response->toException();
        }

        return $response->json('rates');
    }

    protected function buildURL(string $endpoint, array $options = []): string
    {
        $this->config['port'] ??= str_starts_with(strtolower($this->config['host']), 'https://') ? 443 : 80;
        $base = "{$this->config['host']}:{$this->config['port']}/api/{$endpoint}?access_key={$this->config['access_key']}";

        return $options ? "{$base}&".http_build_query($options) : $base;
    }

    /**
     * Check config for required params.
     */
    protected function validateConfig(): void
    {
        if (! isset($this->config['access_key'])) {
            throw new Exceptions\InvalidConfigException();
        }

        if (! isset($this->config['host'])) {
            throw new Exceptions\InvalidConfigException();
        }
    }
}
