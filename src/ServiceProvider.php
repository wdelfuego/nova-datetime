<?php

namespace Wdelfuego\Nova\DateTime;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Nova\Fields;
use DateTimeInterface;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Adds the withDateFormat macro to DateFields
        Fields\DateTime::macro('withDateFormat', function (string $format) {
            return $this->displayUsing(fn ($d) => ($d instanceof DateTimeInterface) ? $d->format($format) : '');
        });
    }
}
