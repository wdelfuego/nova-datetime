<?php

namespace Wdelfuego\Nova\DateTime\Filters;

class BeforeOrOnDate extends OnDate
{
    public function __construct(string $name, string $column)
    {
        parent::__construct($name, $column);
        $this->beforeOrOn();
    }
}
