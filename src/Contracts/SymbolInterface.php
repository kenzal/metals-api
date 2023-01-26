<?php

namespace Kenzal\MetalsApi\Contracts;

interface SymbolInterface
{
    public function getSymbol(): string;
    public function getDescription(): string;
}
