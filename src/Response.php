<?php

namespace Kenzal\MetalsApi;

use Illuminate\Http\Client\Response as HttpResponse;

class Response extends HttpResponse
{
    /**
     * Determine if the response indicates a client or server error occurred.
     *
     * @return bool
     */
    public function failed()
    {
        return $this->serverError() || $this->clientError() || ! $this->json('success', true);
    }

    public function toException(): Exceptions\MetalsApiException|null
    {
        if ($this->failed()) {
            return match ($this->status()) {
                404 => new Exceptions\ResourceNotExistsException($this->response),   // The requested resource does not exist.
                101 => new Exceptions\NoApiKeyException($this->response),            // No API Key was specified or an invalid API Key was specified.
                103 => new Exceptions\EndpointNotExistsException($this->response),   // The requested API endpoint does not exist.
                104 => new Exceptions\NotExistsException($this->response),           // The maximum allowed amount of monthly API requests has been reached.
                105 => new Exceptions\EndpointNotAllowedException($this->response),  // The current subscription plan does not support this API endpoint.
                106 => new Exceptions\NoResultsException($this->response),           // The current request did not return any results.
                102 => new Exceptions\AccountInactiveException($this->response),     // The account this API request is coming from is inactive.
                201 => new Exceptions\InvalidBaseCurrencyException($this->response), // An invalid base currency has been entered.
                202 => new Exceptions\InvalidSymbolException($this->response),       // One or more invalid symbols have been specified.
                301 => new Exceptions\DateNotSpecifiedException($this->response),    // No date has been specified. [historical]
                302 => new Exceptions\InvalidDateException($this->response),         // An invalid date has been specified. [historical, convert]
                403 => new Exceptions\InvalidAmountException($this->response),       // No or an invalid amount has been specified. [convert]
                501 => new Exceptions\InvalidTimeframeException($this->response),    // No or an invalid timeframe has been specified. [timeseries]
                502 => new Exceptions\InvalidStartDateException($this->response),    // No or an invalid "start_date" has been specified. [timeseries, fluctuation]
                503 => new Exceptions\InvalidEndDateException($this->response),      // No or an invalid "end_date" has been specified. [timeseries, fluctuation]
                504 => new Exceptions\InvalidTimeframeException($this->response),    // An invalid timeframe has been specified. [timeseries, fluctuation]
                505 => new Exceptions\InvalidTimeframeException($this->response),    // The specified timeframe is too long, exceeding 365 days. [timeseries, fluctuation]
                default => new Exceptions\MetalsApiException($this->response)
            };
        }
        return null;
    }
}
