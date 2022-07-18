<?php

namespace Wdelfuego\Nova\DateTime\Fields;

use DateTimeInterface;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\DateTime as BaseField;
use DateTimeZone;

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
     * Returns the function that, given a date $format, will set the
     * display resolution function of the Field it's macro'd to 
     * to a function that applies the specified $format in the current locale
     *
     * @return callable
     */
    public static function withDateFormatFunction() : callable
    {
        return function (string $format) {
            return $this->displayUsing(fn ($d) =>
                ($d instanceof Carbon)
                    ? (config('app.timezone')
                        ? $d->setTimezone(new DateTimeZone(config('app.timezone')))->translatedFormat($format)
                        : $d->translatedFormat($format))
                    : (($d instanceof DateTimeInterface)
                        ? (config('app.timezone')
                            ? $d->setTimezone(new DateTimeZone(config('app.timezone')))->format($format)
                            : $d->format($format))
                        : '')
                );
        };
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