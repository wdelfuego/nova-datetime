<?php

namespace Wdelfuego\Nova\DateTime\Fields;

use Laravel\Nova\Fields\DateTime as BaseField;

class DateTime extends BaseField
{
    /**
     * The global date time format (eg 'Y-m-d H:i:s')
     *
     * @var string
     */
    public static $globalFormat = null;
    
    /**
     * Set the global date time format that should be applied to all fields
     *
     * @param  string  $format
     * @return void
     */
    public static function setGlobalFormat(string $format = null) : void
    {
        self::$globalFormat = $format;
    }
    
    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|\Closure|callable|object|null  $attribute
     * @param  (callable(mixed, mixed, ?string):mixed)|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        
        if(self::$globalFormat)
        {
            $this->withDateFormat(self::$globalFormat);
        }
    }
}