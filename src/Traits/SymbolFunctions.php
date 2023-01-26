<?php

namespace Kenzal\MetalsApi\Traits;

trait SymbolFunctions
{

    public function getSymbol(): string
    {
        return $this->value;
    }

    public abstract function getDescription(): string;

}
