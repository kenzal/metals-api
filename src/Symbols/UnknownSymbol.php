<?php

namespace Kenzal\MetalsApi\Symbols;

use Illuminate\Support\Facades\Log;
use Kenzal\MetalsApi\Contracts\SymbolInterface;

class UnknownSymbol implements SymbolInterface
{
    protected string $symbol;

    protected string $description;

    public function __construct(string $symbol, string $description)
    {
        $this->symbol = $symbol;
        $this->description = $description;
        Log::info('Unknown Symbol', compact('symbol', 'description'));
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
