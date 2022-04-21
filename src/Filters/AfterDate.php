<?php

namespace Wdelfuego\Nova\DateTime\Filters;

class AfterDate extends OnDate
{
    public function __construct(string $name, string $column)
    {
        parent::__construct($name, $column);
        $this->after();
    }
}
