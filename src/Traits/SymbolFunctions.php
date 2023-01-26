<?php

namespace Kenzal\MetalsApi\Traits;

trait SymbolFunctions
{
    public function getSymbol(): string
    {
        return $this->value;
    }

    abstract public function getDescription(): string;
}
